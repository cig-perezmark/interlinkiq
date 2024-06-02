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
