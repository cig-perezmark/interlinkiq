<?php 
/**
 * IIQ User Class
 * 
 * Models the intended user from the tbl_user.ID column.
 * To minimize the task to fetch user data (employer, employee, and the user itself).
 */
class IIQ_User {
    protected $db;
    protected $tblUserData = array();
    protected $allowEmpty;
    
    public $isEnterpriseAccount = false;
    public $ID; 

    /**
     * 
     * @param mysqli|mysqli_extended $conn Database connection instance to be used.
     * @param string|int $userID User ID to be used. Default is null, eventually uses the cookie ID. Expects the ID from the tbl_user table.
     * @param boolean $empty Default is false. Allows the instance store empty/null user data.
     */
    public function __construct($conn, $userID = null, $empty = false) {
        $this->db = $conn;
        $this->ID = $userID ?? $_COOKIE['ID'] ?? null;
        $this->allowEmpty = $empty;
        $this->isEnterpriseAccount = false;

        if($this->ID) {
            $myOwnEmployer = $this->db->execute("SELECT * FROM tbl_user WHERE ID = ?", $this->ID)->fetchAssoc();
    
            if($myOwnEmployer['employee_id'] == 0) {
                $this->isEnterpriseAccount = true;
                $this->tblUserData = $myOwnEmployer;
            } else {
                $this->tblUserData = $this->fetchData();
            }
        }
    }

    /**
     * Sets new user ID
     * 
     * @param string|int $userID New user ID.
     * 
     * @return self 
     */
    public function setUserID($userID) {
        if(isset($userID)) {
            $this->ID = $userID;
            $this->isEnterpriseAccount = false;
            
            $myAccount = $this->db->execute("SELECT * FROM tbl_user WHERE ID = ?", $this->ID)->fetchAssoc();
            if($myAccount['employee_id'] == 0) {
                $this->isEnterpriseAccount = true;
                $this->tblUserData = $myAccount;
            } else {
                $this->tblUserData = $this->fetchData();
            }
            return $this;
        }

        echo 'Invalid ID';
        exit();
    }

    /**
     * Fetches the employer data of the selected user.
     * 
     * @param string $column The column name(s) to be fetched. 
     * @param function $callback (Optional).
     * 
     * @return mixed Records from the database.
     */
    public function employer($column = '*', $callback = null) {
        return $this->fetchData('employer', $column, $callback);
    }

    /**
     * Fetches the employee data of the selected user.
     * 
     * @param string $column The column name(s) to be fetched. 
     * @param function $callback (Optional).
     * 
     * @return mixed Records from the database.
     */
    public function employee($column = '*', $callback = null) {
        return $this->fetchData('employee', $column, $callback);
    }

    /**
     * Magic method
     * 
     * So, instead of accessing the $tblUserData array, we tend to access the key directly as if it's a public variable of the class.
     */
    public function __get($var) {
        // Check if the property exists in the $tblUserData array
        if (array_key_exists($var, $this->tblUserData)) {
            return $this->tblUserData[$var];
        } else {
            return null;
        }
    }

    /**
     * Private function for fetching either user, employer, or employee data.
     * 
     * @param string $column The column name(s) to be fetched from the records/database data. Multiple column name(s) are separated by comma(s) - same as a typical mysql query. Default is all (*). 
     * @param function $callback (Optional) Allows you to manipulate the returned data before its actual usage.
     * 
     * @return string|int|array|void Depends on the actual result.
     */
    private function fetchData($type = 'user', $column = '*', $callback = null) {
        if(isset($this->ID)) {
            $prefixedColumnNames = $this->prefixTableName($column, $type);
            $sql = match($type) {
                'employer' => "SELECT $prefixedColumnNames FROM tbl_user AS user JOIN tbl_hr_employee AS employee ON employee.ID = user.employee_id JOIN tbl_user AS employer ON employer.ID = employee.user_id WHERE user.ID = ?",
                'employee' => "SELECT $prefixedColumnNames FROM tbl_user AS user JOIN tbl_hr_employee AS employee ON employee.ID = user.employee_id WHERE user.ID = ?",
                'user' => "SELECT $prefixedColumnNames FROM tbl_user AS user JOIN tbl_hr_employee AS employee ON employee.ID = user.employee_id WHERE user.ID = ?",
                default => null
            };

            if(isset($sql)) {
                $data = $this->isEnterpriseAccount ? $this->tblUserData : $this->db->execute($sql, $this->ID)->fetchAssoc();

                // if only one column is specified, return the data itself
                if(isset($column) && $column != '*') {
                    $columnArr = explode(',', $column);
                    if(count($columnArr) == 1) {
                        $data = $data[$columnArr[0]];
                    }
                }

                // callback is provided
                if ($callback != null && is_callable($callback)) {
                    $value = call_user_func($callback, $data);
                    return isset($value) ? $value : $data;
                }
                
                return $data;
            }
        }
        
        if(!$this->allowEmpty) {
            echo "ID is null";
            exit();
        }
    }

    /**
     * Add prefix to each column specified.
     * 
     * @param string $column The table column name(s).
     * @param string $tableName Could be an alias or the actual table name.
     * 
     * @return string String with columnn(s) prefixed with the table name.
     */
    private function prefixTableName($column, $tableName) {
        $column = explode(',', $column);
        return implode(',', array_map(function($x) use($tableName) { return $tableName . '.' . trim($x); }, $column));
    }

    /**
     * Strategically intended if the availble ID is an employee ID.
     * 
     * @param int|string $employeeID The employee ID of the user.
     * 
     * @return IIQ_User|void IIQ_User instance if the ID provided is valid.
     */
    public static function fromEmployeeID($employeeID) {
        global $conn;
        if(!isset($employeeID)) {
            echo 'Employee ID cannot be null';
            exit();
        }

        $userID = $conn->execute("SELECT user.ID FROM tbl_user AS user JOIN tbl_hr_employee AS employee ON employee.ID = user.employee_id WHERE employee.ID = ?", $employeeID)->fetchAssoc();
        
        if(count($userID)) {
            $iiqUser = new self($conn, $userID['ID']);
            return $iiqUser;
        }

        echo 'Employee ID not found';
        exit();
    }
}

?>