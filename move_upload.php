<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $targetDir = "uploads/test/";
    
    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0777, true);
    }
    
    $uploadedFile = $_FILES["fileToUpload"]["tmp_name"];
    
    $originalName = $_FILES["fileToUpload"]["name"];
    
    $targetPath = $targetDir . basename($originalName);
    
    if (move_uploaded_file($uploadedFile, $targetPath)) {
        echo "File has been uploaded and moved successfully.";
    } else {
        echo "Error moving file.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>File Upload</title>
</head>
<body>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
        <input type="file" name="fileToUpload">
        <input type="submit" value="Upload File" name="submit">
    </form>
</body>
</html>