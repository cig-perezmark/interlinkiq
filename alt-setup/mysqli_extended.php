<?php

/**
 * "mysqli_extended" is an inheritance of mysqli class which has been added with more easy-to-use methods to help php developers
 *
 * Extended mysqli class with CRUD operations and error handling.
 *
 * This class inherits from the built-in `mysqli` class and provides additional
 * functionalities for database interactions, including:
 *
 * - CRUD (Create, Read, Update, Delete) operations through methods like `insert`, `select`, `update`, and `delete`.
 * - Escaping strings for safe SQL usage with the `escapeString` method.
 * - Optional error handling and display capabilities through the `showError` method (customizable behavior depends on the class's `show_error` property).
 *
 * Credits to David Adams, the author of Super-fast PHP MySQL Database Class
 * blog link: https://codeshack.io/super-fast-php-mysql-database-class/
 *
 */

interface CRUD {
    public function insert(string $tableName, ParamBuilder | array $params);
    public function update(string $tableName, ParamBuilder | array $params, $condition = null, string $opr = "AND");
    public function select(string $tableName, array | string $columns = [], $condition = null, string $opr = "AND");
    public function delete(string $tableName, array | string $condition, string $opr = "AND");
}

class mysqli_extended extends mysqli implements CRUD {
    protected $query;
    protected $query_closed = true;
    protected $query_count = 0;
    public $show_error = true;
    public $charset = 'utf8';
    public $escapeString = true;
    public $stripTags = false;

    public function __construct($hostname = 'localhost', $username = 'root', $password = '', $database = null) {
        try {
            parent::__construct($hostname, $username, $password, $database);
            $this->set_charset($this->charset);

            if($this->connect_error) {
                $this->showError('Database connection failed.');
            }
        } catch(Exception $e) {
            $this->showError($e->getMessage());
        }
    }

    public function __destruct()
    {
        try {
            if($this->ping()) {
                $this->close();
            }
        } catch (Throwable $e) {}
    }

    /**
     * Executes a prepared SQL statement with optional parameters via MySQLi.
     *
     * This function prepares and executes a provided SQL query using MySQLi,
     * optionally binding parameters if provided. It handles potential errors
     * during preparation, parameter binding, and execution.
     *
     * @param string $query The SQL query string to execute.
     * @param mixed ...$args Optional additional arguments representing the
     *        parameters to be bound to the query. Parameters can be single values
     *        or arrays of values for binding multiple elements.
     *
     * @return mysqli_extended The mysqli_extended object instance (fluent interface).
     *
     * @throws Exception If an error occurs during query preparation, parameter
     *                   binding, or statement execution.
     */
    public function execute(string $query) {
        try {
            if (!$this->query_closed) {
                $this->query->close();
            }

            // Prepare the statement
            $this->query = $this->prepare($query);
            if (!$this->query) {
                throw new Error('Unable to prepare MySQL statement (check your syntax) - ' . $this->error);
            }

            // Bind parameters
            if (func_num_args() > 1) {
                $x = func_get_args();
                $args = array_slice($x, 1);
				$types = '';
                $args_ref = array();
                foreach ($args as $k => &$arg) {
					if (is_array($args[$k])) {
						foreach ($args[$k] as $j => &$a) {
                            $t = $this->_gettype($args[$k][$j]);
							$types .= $t;

                            if($t === 's') {
                                $value = &$a;
                                if($this->stripTags ) $value = strip_tags($value);
                                if($this->escapeString && !is_array(json_decode($value, true))) $value = mysqli_real_escape_string($this, $value);
                                $args_ref[] = $value;
                            } else {
                                $args_ref[] = &$a;
                            }
						}
					} else {
	                	$types .= $this->_gettype($args[$k]);
	                    $args_ref[] = &$arg;
					}
                }

                array_unshift($args_ref, $types);
                if (!call_user_func_array([$this->query, 'bind_param'], $args_ref)) {
                    throw new Error('Unable to bind parameters for MySQL statement - ' . $this->query->error);
                }
            }

            // Execute the statement
            $this->query->execute();
            if ($this->query->errno) {
                throw new Error('Unable to process MySQL query (check your params) - ' . $this->query->error);
            }

            $this->query_closed = false;
            $this->query_count++;

            return $this;
        } catch(Throwable $t) {
            $this->showError($t->getMessage());
        }
    }

    /**
     * Fetches all rows from the result set and optionally applies a callback function.
     *
     * This function fetches all rows from the currently prepared query and returns them as an array.
     * It uses result metadata to bind results by reference and then iterates through each row,
     * optionally applying a callback function to each row before adding it to the final result set.
     *
     * @param callable|null $callback A callback function to be applied to each row of data.
     *                                The callback function should accept a single array argument
     *                                representing the current row and should return the modified row
     *                                or 'break' to stop iterating.
     *
     * @return array An array containing all fetched rows of data. If the callback function
     *                returns 'break' from processing a row, the iteration will stop and the
     *                remaining rows will not be processed.
     *
     * @throws Throwable If an error occurs during the database operation.
     */
	public function fetchAll($callback = null) {
        try {
            $row = [];
            $params = [];
            $meta = $this->query->result_metadata();
            while ($field = $meta->fetch_field()) {
                $params[] = &$row[$field->name];
            }

            $result = [];
            if (call_user_func_array([$this->query, 'bind_result'], $params)) {
                while ($this->query->fetch()) {
                    $rowData = [];
                    // Extract values directly into an array using references from $params
                    foreach ($row as $key => &$value) {
                        $rowData[$key] = $value;  // Explicit assignment to elements in $row
                    }

                    if ($callback != null && is_callable($callback)) {
                        $rowData = call_user_func($callback, $rowData);
                        if ($rowData === 'break') break;
                    }

                    $result[] = $rowData;
                }
                $this->query->close();
                $this->query_closed = true;
            }

            return $result;
        } catch(Throwable $t) {
            $this->showError($t->getMessage());
        }
    }

    /**
     * Fetches the first associative row from the result set and optionally applies a callback function.
     *
     * This function fetches the first associative row from the currently prepared query and returns it as an array.
     * It uses result metadata to bind results by reference and then iterates through the first row,
     * optionally applying a callback function to the row before returning it.
     *
     * If there are no rows in the result set, this function will return an empty array.
     *
     * @param callable|null $callback A callback function to be applied to the fetched row of data.
     *                                The callback function should accept a single array argument
     *                                representing the row and should return the modified row
     *                                or 'break' to stop processing.
     *
     * @return array The first associative row of data from the result set, or an empty array if no rows exist.
     *               If the callback function returns 'break', processing will stop and the
     *               modified row will be returned.
     *
     * @throws Throwable If an error occurs during the database operation.
     */
    public function fetchAssoc($callback = null) {
        try {
            $row = [];
            $params = [];
            $meta = $this->query->result_metadata();
            while ($field = $meta->fetch_field()) {
                $params[] = &$row[$field->name];
            }

            $result = [];
            if (call_user_func_array([$this->query, 'bind_result'], $params)) {
                while ($this->query->fetch()) {
                    $rowData = [];
                    // Directly populate result array using references from $params
                    foreach ($row as $key => &$value) {
                        $rowData[$key] = $value;
                    }

                    if ($callback != null && is_callable($callback)) {
                        $rowData = call_user_func($callback, $rowData);
                        if ($rowData === 'break') break;
                    }

                    $result = $rowData;
                }
                $this->query->close();
                $this->query_closed = true;
            }

            return $result;
        } catch(Throwable $t) {
            $this->showError($t->getMessage());
        }
    }

    /**
     * Inserts a new record into a database table.
     *
     * This function inserts a new record into the specified table using the provided parameters.
     * It can handle both dictionaries (associative arrays) and a `ParamBuilder` object for parameter binding.
     *
     * @param string $tableName The name of the database table to insert into.
     * @param ParamBuilder|array $params The data to insert. Can be either:
     *     - An associative array where keys are column names and values are the corresponding data for those columns.
     *     - A `ParamBuilder` object containing pre-built parameters for the insertion query.
     * @return mixed The result of the execution (implementation specific). This typically depends on the underlying database driver.
     * @throws Exception (or a more specific subclass) If there is an error during the insertion process.
     */
    public function insert(string $tableName, ParamBuilder | array $params) {
        if(is_array($params)) {
            $params = new ParamBuilder($params);
        }

        $columns = $params->columnNames;
        $parameters = $params->params;

        return $this->execute("INSERT INTO $tableName ($columns) VALUE($parameters)", $params->values);
    }

    /**
     * Updates existing records in a database table.
     *
     * This function updates existing records in the specified table based on the provided parameters and optional conditions.
     * It can handle both dictionaries (associative arrays) and a `ParamBuilder` object for parameter binding.
     *
     * @param string $tableName The name of the database table to update in.
     * @param ParamBuilder|array $params The data to update. Can be either:
     *     - An associative array where keys are column names and values are the corresponding data for those columns.
     *     - A `ParamBuilder` object containing pre-built parameters for the update query.
     * @param mixed $condition (Optional) The condition(s) to apply for filtering the update. Can be either:
     *     - An associative array where keys are column names and values are the corresponding conditions for those columns.
     *     - A string representing a custom WHERE clause.
     * @param string $opr (Optional) The operator to use for combining multiple conditions in the WHERE clause (defaults to "AND").
     * @return mixed The result of the execution (implementation specific). This typically depends on the underlying database driver.
     * @throws Exception (or a more specific subclass) If there is an error during the update process.
     */
    public function update(string $tableName, ParamBuilder | array $params, $condition = null, string $opr = "AND") {
        if(is_array($params)) {
            $params = new ParamBuilder($params);
        }

        $parameters = $params->namedParams;
        $values = $params->values;

        $sql = "UPDATE $tableName SET $parameters";

        if(!empty($condition)) {
            $whereClause = "";
            if(is_array($condition)) {
                $conParams = new ParamBuilder($condition);
                $whereClause = implode(" $opr ", $conParams->namedParamsArray);
                array_push($values, ...$conParams->values);
            } else if(is_string($condition)) {
                $whereClause = $condition;
            }

            $sql .= " WHERE $whereClause";
        }

        return $this->execute($sql, $values);
    }

    /**
     * Selects records from a database table.
     *
     * This function retrieves records from the specified table based on provided columns and optional conditions.
     * It allows selecting all columns (`*`), specific columns (as an array), or using a custom WHERE clause.
     *
     * @param string $tableName The name of the database table to select from.
     * @param array|string $columns (Optional) The columns to select. Can be either:
     *     - An empty string, "*", or an empty array to select all columns.
     *     - An array of column names to select specific columns.
     * @param mixed $condition (Optional) The condition(s) to apply for filtering the selection. Can be either:
     *     - An associative array where keys are column names and values are the corresponding conditions for those columns.
     *     - A string representing a custom WHERE clause.
     * @param string $opr (Optional) The operator to use for combining multiple conditions in the WHERE clause (defaults to "AND").
     * @return mixed The result of the execution (implementation specific). This typically depends on the underlying database driver and
     * can be an array of selected rows or a specific data structure based on your implementation.
     * @throws Exception (or a more specific subclass) If there is an error during the selection process.
     */
    public function select(string $tableName, array | string $columns = [], $condition = null, string $opr = "AND") {
        if(in_array($columns, ["", "*", "[]", []])) {
            $columns = "*";
        } else if(is_array($columns)) {
            $columns = implode(',', $columns);
        }

        $sql = "SELECT $columns FROM $tableName";
        $values = [];

        if(!empty($condition)) {
            $whereClause = "";
            if(is_array($condition)) {
                $conParams = new ParamBuilder($condition);
                $whereClause = implode(" $opr ", $conParams->namedParamsArray);
                array_push($values, ...$conParams->values);
            } else if(is_string($condition)) {
                $whereClause = $condition;
            }

            $sql .= " WHERE $whereClause";
        }

        return (!empty($values) ? $this->execute($sql, $values) : $this->execute($sql));
    }

    /**
     * Deletes records from a database table.
     *
     * This function removes records from the specified table based on provided conditions.
     * It allows defining conditions using either an associative array, a `ParamBuilder` object, or a custom WHERE clause string.
     *
     * @param string $tableName The name of the database table to delete from.
     * @param array|string|ParamBuilder $condition The condition(s) to apply for filtering the deletion. Can be one of:
     *     - An associative array where keys are column names and values are the corresponding conditions for those columns.
     *     - A `ParamBuilder` object containing pre-built parameters for the WHERE clause.
     *     - A string representing a custom WHERE clause.
     * @param string $opr (Optional) The operator to use for combining multiple conditions in the WHERE clause (defaults to "AND").
     * @return mixed The result of the execution (implementation specific). This typically depends on the underlying database driver and
     * might indicate the number of affected rows or success/failure.
     * @throws Exception (or a more specific subclass) If there is an error during the deletion process.
     */
    public function delete(string $tableName, array | string | ParamBuilder $condition, string $opr = "AND") {
        $sql = "DELETE FROM $tableName WHERE ";

        if($condition instanceof ParamBuilder || is_array($condition)) {
            if(is_array($condition)) {
                $condition = new ParamBuilder($condition);
            }

            $sql .= implode(" $opr ", $condition->namedParamsArray);
            if(count($condition->values)) {
                return $this->execute($sql, $condition->values);
            }

            return $this->execute($sql);
        }

        return $this->execute($sql . $condition);
    }

    /**
     * Escapes a string for safe use in SQL queries.
     *
     * This method escapes special characters within the provided string
     * to prevent SQL injection vulnerabilities. It's primarily intended
     * for compatibility with older code or specific use cases. For new
     * development, consider using prepared statements with parameter
     * binding for enhanced security and robustness.
     *
     * @param string $str The string to escape.
     * @return string The escaped string, ready for inclusion in an SQL query.
     * @throws InvalidArgumentException If the input `$str` is not a string.
     * @throws RuntimeException If there's an error during escaping.
     */
    public function escapeString(string $str): string {
        try {
            if(!is_string($str)) {
                throw new InvalidArgumentException("Input must be a string.");
            }

            return mysqli_real_escape_string($this, $str);
        } catch (Throwable $t) {
            $this->showError($t->getMessage());
        }
    }

    public function numRows() {
		$this->query->store_result();
		return $this->query->num_rows;
	}

	public function affectedRows() {
		return $this->query->affected_rows;
	}

    /**
     * @deprecated This method is deprecated. Please use getInsertId().
     */
    public function lastInsertID() {
    	return $this->insert_id;
    }

    public function getInsertId() {
        return $this->insert_id;
    }

    /**
     * Displays or logs an error message (optional).
     *
     * This function displays or logs an error message depending on the `show_error` property of the class.
     * It can handle both provided error messages and retrieving errors from the current connection.
     *
     * @param string $error (Optional) The specific error message to display/log.
     * @throws Exception If there's an error during processing or re-throwing a caught exception.
     */
    public function showError($error = null) {
        if($this->show_error) {
            try {
                $err = new MySQLiExtendedException(($error ?? $this->error). ' (mysqli_extended error) ');
                http_response_code(500);
                echo $err->getCustomMessage();
                throw $err;
            } catch (Throwable $t) {
                throw new Exception($t->getMessage());
            }
        }
    }

    public function close() {
        if(!$this->query_closed && $this->query instanceof mysqli_stmt) {
            $this->query->close();
        }
        parent::close();
    }

	private function _gettype($var) {
	    if (is_string($var)) return 's';
	    if (is_float($var)) return 'd';
	    if (is_int($var)) return 'i';
	    return 'b';
	}
}

/**
 * Builds parameter information for database operations.
 *
 * This class takes an associative array representing column names and values and generates
 * information for constructing database queries with placeholders. It provides properties for:
 *
 * - `columnNames`: A comma-separated string of column names from the input array.
 * - `values`: An array containing the values corresponding to the column names.
 * - `params`: A comma-separated string of question marks representing placeholders for values.
 * - `namedParams`: A comma-separated string of named parameters with placeholders (e.g., "name=?", "age=?").
 *
 * Used for building prepared statements or constructing SQL queries with placeholders.
 */
class ParamBuilder {
    public $columnNames;
    public $columnNamesArray;
    public $values;
    public $params;
    public $namedParams;
    public $namedParamsArray;

    public function __construct(array $arr)
    {
        $this->columnNamesArray = array_keys($arr);
        $this->columnNames = implode(',', array_keys($arr));
        $this->values = array_values($arr);

        // Loop for placeholder generation (version agnostic)
        $placeholders = array();
        for ($i = 0; $i < count($arr); $i++) {
          $placeholders[] = '?';
        }
        $this->params = implode(',', $placeholders);

        // Loop for named parameter generation (version agnostic)
        $namedParams = array();
        foreach (array_keys($arr) as $key) {
          $namedParams[] = "$key=?";
        }
        $this->namedParamsArray = $namedParams;
        $this->namedParams = implode(',', $namedParams);
    }


}

/**
 * Custom Exception class for MySQLi related errors with enhanced error display.
 *
 * This class extends the built-in `Exception` class and provides a more informative
 * error message format for MySQLi errors. It generates HTML markup with a Material Design
 * look and uses a monospaced font for better readability of the stack trace.
 *
 * This class offers the following functionalities:
 *
 * - Inherits all functionalities from the `Exception` class.
 * - Provides a custom constructor that accepts the same arguments as the parent constructor.
 * - Defines a method `getCustomMessage` which generates a detailed HTML error message. This message includes:
 *     - Error code
 *     - Error message
 *     - File and line where the error occurred
 *     - Stack trace information with function call details (excluding the current function call)
 *     - Information about the thrown exception object itself
 */
class MySQLiExtendedException extends Exception {
    public function __construct($message, $code = 0, Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }

    /**
     * Generates HTML markup for a custom error message with stack trace.
     *
     * This function extracts error data like error code, message, file, line,
     * and stack trace information. It then formats this data into an HTML
     * structure with a Material Design look and uses a monospaced font (Consolas)
     * for better readability of code snippets within the stack trace.
     *
     * @return string The formatted HTML error message.
     */
    final public function getCustomMessage() {
        // Begin by getting the stack trace.
        $stackTrace = $this->getTrace();

        // Extract error data from the retrieved stack trace.
        $errorCode = strtoupper($this->code);
        $errorMessage = $this->message;
        $file = isset($stackTrace[0]['file']) ? $stackTrace[0]['file'] : 'Unknown File';
        $line = isset($stackTrace[0]['line']) ? $stackTrace[0]['line'] : 'Unknown Line';

        // Starting to build the error message with an outer container.
        $errorHTML = "
        <div style='
            background-color: #fff;
            padding: 20px;
            border-radius: 2px;
            box-shadow: 0 2px 2px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            font-family: Consolas, monospace;
        '>";

        // Creating a header section to display the error code and message.
        $errorHTML .= "
            <div style='
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 10px;
            '>
                <h2 style='font-size: 18px; color: #333; font-weight: bold;'>Error</h2>
                <span style='color: #ff0033; font-size: 14px;'>Error Code: $errorCode</span>
            </div>
        ";

        // Creating a section to display the error message and file location.
        $errorHTML .= "
            <div style='margin-bottom: 10px;'>
                <p style='font-size: 16px; color: #333;'>$errorMessage</p>
                <p style='font-size: 14px; color: #757575;'>
                    <span style='color: #333;'>File:</span> $file (<span style='color: #333;'>$line</span>)
                </p>
            </div>
        ";

        // Creating a dedicated section for the function call stack.
        $errorHTML .= "
            <div style='margin-top: 10px;'>
                <h3>Function Call Stack</h3>
                <ul style='padding-left: 0; list-style: none;'>
        ";

        // Iterating through the stack trace to construct function calls.
        foreach ($stackTrace as $index => $call) {
            // Skipping the first call as it's the current function.
            if ($index === 0) {
                continue;
            }

            // Extracting function name, class name, and arguments from the call.
            $functionName = isset($call['function']) ? $call['function'] : 'Unknown Function';
            $className = isset($call['class']) ? $call['class'] : null;
            $args = isset($call['args']) ? $call['args'] : [];

            // Constructing the function call string.
            $classString = ($className !== null) ? $className . '::' : '';
            $argsString = implode(', ', array_map(function ($arg) {
                return var_export($arg, true);
            }, $args));
            $callString = "$classString$functionName($argsString)";

            // Adding the function call to the error HTML.
            $errorHTML .= "
                    <li style='font-size: 14px; color: #333; margin-bottom: 5px;'>$callString</li>
            ";
        }

        // Closing the error HTML
        $errorHTML .= "
                </ul>
                <h3>Exception Handler Object</h3>
                <ul style='padding-left: 0; list-style: none;'>
                    <li style='font-size: 14px; color: #333; margin-bottom: 5px;'>$this</li>
                </ul>
            </div>
        </div>";

        return $errorHTML;
    }
}