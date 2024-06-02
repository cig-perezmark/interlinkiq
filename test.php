
<?php


function isValidFile($filename) {
    // List of disallowed extensions
    $disallowedExtensions = ['php', 'php3', 'php4', 'php5', 'phtml', 'cgi', 'pl', 'sh', 'py', 'rb', 'exe', 'dll'];

    // List of disallowed MIME types corresponding to disallowed extensions
    $disallowedMimeTypes = [
        'application/x-php',
        'application/x-httpd-php',
        'application/php',
        'text/php',
        'text/x-php',
        'application/x-httpd-php-source',
        'text/x-php-source',
        'application/x-perl',
        'text/x-perl',
        'application/x-shellscript',
        'text/x-shellscript',
        'application/x-python',
        'text/x-python',
        'application/x-ruby',
        'text/x-ruby',
        'application/x-msdos-program',
        'application/octet-stream'
    ];

    // Check file extension
    $fileExtension = pathinfo($filename, PATHINFO_EXTENSION);
    print_r($fileExtension);
    if (in_array(strtolower($fileExtension), $disallowedExtensions)) {
        return false;
    }

    // // Check MIME type
    // $finfo = finfo_open(FILEINFO_MIME_TYPE);
    // if (!$finfo) {
    //     return false; // If finfo_open fails, consider the file invalid
    // }

    // $mimeType = finfo_file($finfo, $filename);
    // finfo_close($finfo);

    // if (in_array($mimeType, $disallowedMimeTypes)) {
    //     print_r($mimeType);
    //     return false;
    // }

    return true;
}


    phpinfo();


if($_SERVER['REQUEST_METHOD'] == 'POST' && isset( $_POST['upload_test'] ) ) {
    // echo 'hi';

    echo "<pre>";

    $file = $_FILES['file'];
    $filename = $file['name'];

    echo 'file uploaded:<br>';
    print_r($file);
    echo "<br>";

    $fileExtension = pathinfo($filename, PATHINFO_EXTENSION);
    print_r($fileExtension);

    // Check MIME type
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    echo "<br>";

    $mimeType = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);

    print_r($mimeType);
    echo "<br>";
    echo "</pre>";

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>test</title>
</head>

<body>
    <form action="./test.php" method="post" enctype="multipart/form-data">
        <div>
            <label for="file">Upload file here</label>
            <input type="file" name="file" id="file" required>
        </div>
        <input type="submit" name="upload_test" value="submit" />
    </form>
</body>

</html>

<?php exit(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Frequency Selector</title>
</head>
<body>
    <label for="frequency">Select frequency:</label>
    <select id="frequency" onchange="showAdditionalFields()">
        <option value="">Select</option>
        <option value="daily">Daily</option>
        <option value="weekly">Weekly</option>
        <option value="monthly">Monthly</option>
        <option value="yearly">Yearly</option>
    </select>

    <div id="additionalFields" style="display: none;">
        <br>
        <div id="dayOfWeekSection" style="display: none;">
            <label for="dayOfWeek">Day of the week:</label>
            <select id="dayOfWeek">
                <option value="Monday">Monday</option>
                <option value="Tuesday">Tuesday</option>
                <option value="Wednesday">Wednesday</option>
                <option value="Thursday">Thursday</option>
                <option value="Friday">Friday</option>
                <option value="Saturday">Saturday</option>
                <option value="Sunday">Sunday</option>
            </select>
            <br><br>
        </div>
        <div id="dayOfMonthSection" style="display: none;">
            <label for="dayOfMonth">Day of the month:</label>
            <input type="number" id="dayOfMonth" min="1" max="31" placeholder="Enter day of the month">
            <br><br>
        </div>
        <div id="monthAndDayOfYearSection" style="display: none;">
            <label for="monthOfYear">Month of the year:</label>
            <select id="monthOfYear">
                <option value="January">January</option>
                <option value="February">February</option>
                <option value="March">March</option>
                <!-- Add options for other months -->
            </select>
            <br><br>
            <label for="dayOfMonth">Day of the month:</label>
            <input type="number" id="dayOfMonthYearly" min="1" max="31" placeholder="Enter day of the month">
        </div>
    </div>

    <script>
        function showAdditionalFields() {
            const frequency = document.getElementById("frequency").value;
            const additionalFieldsDiv = document.getElementById("additionalFields");
            const dayOfWeekSection = document.getElementById("dayOfWeekSection");
            const dayOfMonthSection = document.getElementById("dayOfMonthSection");
            const monthAndDayOfYearSection = document.getElementById("monthAndDayOfYearSection");

            if (frequency === "weekly") {
                additionalFieldsDiv.style.display = "block";
                dayOfWeekSection.style.display = "block";
                dayOfMonthSection.style.display = "none";
                monthAndDayOfYearSection.style.display = "none";
            } else if (frequency === "monthly") {
                additionalFieldsDiv.style.display = "block";
                dayOfWeekSection.style.display = "none";
                dayOfMonthSection.style.display = "block";
                monthAndDayOfYearSection.style.display = "none";
            } else if (frequency === "yearly") {
                additionalFieldsDiv.style.display = "block";
                dayOfWeekSection.style.display = "none";
                dayOfMonthSection.style.display = "none";
                monthAndDayOfYearSection.style.display = "block";
            } else {
                additionalFieldsDiv.style.display = "none";
            }
        }
    </script>
</body>
</html>
