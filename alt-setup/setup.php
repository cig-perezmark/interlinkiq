<?php

include_once __DIR__ . '/defs.php';
include_once __DIR__ . '/IIQ_User.php';
include_once __DIR__ . '/db_iiq.php';

if (!empty($_COOKIE['switchAccount'])) {
	$portal_user = $_COOKIE['ID'];
	$user_id = $_COOKIE['switchAccount'];
}
else {
	$portal_user = $_COOKIE['ID'];
	$user_id = new IIQ_User($conn, $portal_user);
	$user_id = $user_id->employer('ID');
}

// instantiate the current user for universal use
$currentUser = new IIQ_User($conn);

// timestamp
$currentTimestamp = date('Y-m-d H:i:s');


$pageUrl =  "http://" . $_SERVER['SERVER_NAME'];
// Check for HTTPS if enabled
if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {
	$pageUrl = "https://" . $_SERVER['SERVER_NAME'];
}

/**
 * Validates strings. Intended for the new mysqli_extended class methods - to set column value(s) to null instead of an empty string itself.
 * 
 * @param mixed $var Variable to be validated.
 * @return null|string Returns null if it is an empty or not a string at all, otherwise, the string itself.
 */
function val_str($var) {
    return isset($var) && is_string($var) && empty($var) ? null : $var;
}

/**
 * Sets timezone to America/Chicago
 */
function default_timezone() {
	global $currentTimestamp;
	date_default_timezone_set('America/Chicago');
	$currentTimestamp = date('Y-m-d H:i:s');
}

/**
 * Send responses to the client browser.
 * 
 * @param mixed $data The response data to be sent.
 * @param int $code (Optional) The response/status code.
 * @param array $headers (Optional) Custom headers to be included in the response.
 */
function send_response($data, $code = 200, $headers = []) {
	try {
		ob_start(); // start output buffering

		http_response_code($code);
		
		// setting custom headers
		foreach($headers as $key => $value) {
			header($key . ': ' . $value);
		}

		// handle different types of responses
		if(is_array($data)) {
			header('Content-Type: application/json');
			echo json_encode($data);
		} else if($data === null)  {
			echo 'null';
		} else if($data === false) {
			echo 'false';
		} else {
			echo $data;
		}

		ob_end_flush(); // clean output buffer
	} catch(Exception $e) {
		http_response_code(500);
		echo $e->getMessage();
	}
}

/**
 * Returns upload directory, if not exists, eventually creates it.
 * 
 * @param string $dir
 */
function getUploadsDir($dir) {
    $base = 'uploads' . DIRECTORY_SEPARATOR;

    if (!$dir) {
        throw new Exception('Directory path is required.');
    }

    $folderPath = $base . str_replace('/', DIRECTORY_SEPARATOR, $dir);

    if (!file_exists($folderPath)) {
        // Create the folder 
        mkdir($folderPath, 0777, true);
    }

    return $folderPath;
}

/**
 * Uploading files
 */
function uploadFile($path, $file, $newFilename = null) {
    if (!is_dir($path)) {
        throw new Exception("Destination path is not a valid directory.");
    }

    if(is_array($file['tmp_name'])) {
        $filenameArr = [];
        $fileCount = count($file['tmp_name']);

        for ($i = 0; $i < $fileCount; $i++) {
            if (!is_uploaded_file($file["tmp_name"][$i]) || $file["error"][$i] !== UPLOAD_ERR_OK) {
                throw new Exception("Upload failed with error code " . $file["error"]);
            }
            
            $filename = uniqid() . ' - ' . basename(htmlentities($file["name"][$i]));
            $uploadFile = rtrim($path, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $filename;
            if (move_uploaded_file($file["tmp_name"][$i], $uploadFile)) {
                $filenameArr[] = $filename;
            }
        }
        return $filenameArr;
    } else {
        if (!is_uploaded_file($file["tmp_name"]) || $file["error"] !== UPLOAD_ERR_OK) {
            throw new Exception("Upload failed with error code " . $file["error"]);
        }
        
        $filename = $newFilename ?? uniqid() . ' - ' . basename(htmlentities($file["name"]));
        $uploadFile = rtrim($path, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $filename;
    
        if (move_uploaded_file($file["tmp_name"], $uploadFile)) {
            return $filename;
        }
    }

    throw new Exception("Failed to move uploaded file.");
}

?>