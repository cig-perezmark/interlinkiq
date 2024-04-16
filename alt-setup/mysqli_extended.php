<?php
/**
 * Mysqli-Extended Class
 * 
 * Usage: (see HACCP Plan Module)
 * 
 * @version 1.0
 * @link: https://github.com/amiano4/mysqli_extended.git
 */

class mysqli_extended extends mysqli {
    protected $execution;
    protected $execution_closed = true;
    public $execution_count = 0;
    public $show_error = true;
    
    public function __construct($hostname = 'localhost', $username = 'root', $password = '', $database = null) {
        parent::__construct($hostname, $username, $password, $database);
    }

    public function execute($query) {
        if (!$this->execution_closed) {
            $this->execution->close();
        }
		if ($this->execution = $this->prepare($query)) {
            if (func_num_args() > 1) {
                $x = func_get_args();
                $args = array_slice($x, 1);
				$types = '';
                $args_ref = array();
                foreach ($args as $k => &$arg) {
					if (is_array($args[$k])) {
						foreach ($args[$k] as $j => &$a) {
							$types .= $this->_gettype($args[$k][$j]);
							$args_ref[] = &$a;
						}
					} else {
	                	$types .= $this->_gettype($args[$k]);
	                    $args_ref[] = &$arg;
					}
                }
				array_unshift($args_ref, $types);
                call_user_func_array(array($this->execution, 'bind_param'), $args_ref);
            }
            $this->execution->execute();
           	if ($this->execution->errno) {
				$this->showError('Unable to process MySQL execution (check your params) - ' . $this->execution->error);
           	}
            $this->execution_closed = FALSE;
			$this->execution_count++;
        } else {
            $this->showError('Unable to prepare MySQL statement (check your syntax) - ' . $this->error);
        }
		return $this;
    }
    
	public function fetchAll($callback = null) {
	    $params = array();
        $row = array();
	    $meta = $this->execution->result_metadata();
	    while ($field = $meta->fetch_field()) {
	        $params[] = &$row[$field->name];
	    }
	    call_user_func_array(array($this->execution, 'bind_result'), $params);
        $result = array();
        while ($this->execution->fetch()) {
            $r = array();
            foreach ($row as $key => $val) {
                $r[$key] = $val;
            }
            if ($callback != null && is_callable($callback)) {
                $value = call_user_func($callback, $r);
                if ($value == 'break') break;
            } else {
                $result[] = $r;
            }
        }
        $this->execution->close();
        $this->execution_closed = TRUE;
		return $result;
	}

	public function fetchAssoc() {
	    $params = array();
        $row = array();
	    $meta = $this->execution->result_metadata();
	    while ($field = $meta->fetch_field()) {
	        $params[] = &$row[$field->name];
	    }
	    call_user_func_array(array($this->execution, 'bind_result'), $params);
        $result = array();
		while ($this->execution->fetch()) {
			foreach ($row as $key => $val) {
				$result[$key] = $val;
			}
		}
        $this->execution->close();
        $this->execution_closed = TRUE;
		return $result;
	}

    public function numRows() {
		$this->execution->store_result();
		return $this->execution->num_rows;
	}

	public function affectedRows() {
		return $this->execution->affected_rows;
	}

    public function lastInsertID() {
    	return $this->insert_id;
    }

    public function showError($error = null) {
        if($this->show_error) {
            exit($error ?? $this->error);
        }
    }

    public function close() {
        if(!$this->execution_closed && $this->execution instanceof mysqli_stmt) {
            $this->execution->close();
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

?>