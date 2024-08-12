<?php

function isEmpty($value)
{
    return !isset($value) || empty($value);
}

function null_if_empty($value)
{
    return isEmpty($value) ? null : $value;
}

function fetchHaccpTeamRoster($conn, $user_id)
{
    $team = $conn->execute("SELECT * FROM tbl_fsp_team_roster WHERE user_id=? AND deleted_at IS NULL", $user_id)->fetchAll();
    $teamRoster = [];

    foreach ($team as $t) {
        $members = [];
        $members[] = !isEmpty($t['primary_member']) ? $t['primary_member'] : 0;
        $members[] = !isEmpty($t['alternate_member']) ? $t['alternate_member'] : 0;
        $members = implode(',', $members);

        $employeeData = $conn->execute("SELECT ID,CONCAT(first_name, ' ', last_name) AS name,department_id,job_description_id FROM tbl_hr_employee WHERE ID in ($members)")->fetchAll();
        $data = array(
            'primary' => [],
            'alternate' => [],
            'roster_id' => $t['id'],
        );

        foreach ($employeeData as $ed) {
            $d = explode(', ', $ed['department_id'])[0] ?? 0;
            $j = explode(', ', $ed['job_description_id'])[0] ?? 0;
            $dept = '';
            $job = '';

            if (!empty($d)) {
                $dept = $conn->query("SELECT title FROM tbl_hr_department WHERE ID=$d")->fetch_assoc()['title'] ?? '';
            }

            if (!empty($j)) {
                $job = $conn->query("SELECT title FROM tbl_hr_job_description WHERE ID=$j")->fetch_assoc()['title'] ?? '';
            }

            $temp = [
                'name' => $ed['name'],
                'department' => $dept,
                // 'description' => $job, // hidden
            ];
            if ($ed['ID'] == $t['primary_member']) {
                $temp['id'] = $t['primary_member'];
                $temp['position'] = $t['primary_title'];
                $data['primary'] = $temp;
            } else if ($ed['ID'] == $t['alternate_member']) {
                $temp['id'] = $t['alternate_member'];
                $temp['position'] = $t['alternate_title'];
                $data['alternate'] = $temp;
            }
        }

        $teamRoster[] = $data;
    }

    return $teamRoster;
}

// recursive functions ahead

function html($markup)
{
    if (is_array($markup)) {
        foreach ($markup as $k => $v) {
            $markup[$k] = html($v);
        }
        return $markup;
    }
    return htmlentities($markup, ENT_QUOTES, 'UTF-8');
}

function htmlDecode($string)
{
    if (is_array($string)) {
        foreach ($string as $k => $v) {
            $string[$k] = htmlDecode($v);
        }
        return $string;
    }

    return strip_tags(html_entity_decode($string));
}

// calculating current time difference from a certain date 
function timeElapsed($datetime)
{
    // Create a DateTime object from the provided datetime
    $then = new DateTime($datetime);

    // Get the current time
    $now = new DateTime();

    // Calculate the time difference in seconds
    $diff = $now->diff($then);

    // Get the difference in various units
    $seconds = $diff->s;
    $minutes = $diff->i;
    $hours = $diff->h;
    $days = $diff->d;
    $weeks = floor($diff->days / 7);

    // Determine the unit
    $unit = "";
    if ($weeks > 0) {
        $unit = ($weeks == 1) ? "week" : "weeks";
    } else if ($days > 0) {
        $unit = ($days == 1) ? "day" : "days";
    } else if ($hours > 0) {
        $unit = ($hours == 1) ? "hour" : "hours";
    } else if ($minutes > 0) {
        $unit = ($minutes == 1) ? "minute" : "minutes";
    } else if ($seconds > 0) {
        $unit = ($seconds == 1) ? "second" : "seconds";
    } else {
        // Handle "just now" case
        $unit = "just now";
    }

    // Combine count and unit without duplicates
    $elapsed = "";
    if ($weeks > 0) {
        $elapsed = $weeks . " " . $unit;
    } else if ($days > 0) {
        $elapsed = $days . " " . $unit;
    } else if ($hours > 0) {
        $elapsed = $hours . " " . $unit;
    } else if ($minutes > 0) {
        $elapsed = $minutes . " " . $unit;
    } else if ($seconds > 0) {
        $elapsed = $seconds . " " . $unit;
    } else {
        $elapsed = $unit;
    }

    // Add "ago" for past dates
    $elapsed .= ($unit != "just now") ? " ago" : "";

    // Return the formatted string
    return trim($elapsed);
}


function yesNo($value)
{
    if ($value === 1 || $value === '1')
        return "Yes";
    else if ($value === 0 || $value === '0')
        return "No";
    else
        return "N/A";
}

$slResult = function ($sl) {
    return match ($sl) {
        '' => '',
        'significant' => 'Preventive Control',
        'high' => 'CCP',
        default => 'Control not required.'
    };
};

function isYes($v)
{
    return $v == 'y';
}
function isNo($v)
{
    return $v == 'n';
}

function isCCP($ccp)
{
    return (isYes($ccp['B']['q1']) && isYes($ccp['B']['q2'])) ||
        (isYes($ccp['B']['q1']) && isNo($ccp['B']['q2']) && isYes($ccp['B']['q3']) && isNo($ccp['B']['q4'])) ||
        (isYes($ccp['C']['q1']) && isYes($ccp['C']['q2'])) ||
        (isYes($ccp['C']['q1']) && isNo($ccp['C']['q2']) && isYes($ccp['C']['q3']) && isNo($ccp['C']['q4'])) ||
        (isYes($ccp['P']['q1']) && isYes($ccp['P']['q2'])) ||
        (isYes($ccp['P']['q1']) && isNo($ccp['P']['q2']) && isYes($ccp['P']['q3']) && isNo($ccp['P']['q4']));
}
