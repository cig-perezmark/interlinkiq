<?php

include_once __DIR__ . '/../../alt-setup/setup.php';
include_once __DIR__ . '/api_functions.php';

require __DIR__ . '/../../PHPMailer/src/Exception.php';
require __DIR__ . '/../../PHPMailer/src/PHPMailer.php';
require __DIR__ . '/../../PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if (!defined("CIG_USER_ID")) {
    define("CIG_USER_ID", 34);
}

default_timezone();

class Haccp
{
    public $id, $version_id, $details_id, $title, $supersedes, $status, $facility;
    public $owner_id;
    protected $changeHistory;
    protected mysqli_extended $conn;
    protected $ts;

    public static $step = [
        '1' => 'draft',
        '2' => 'for-review',
        '3a' => 'for-approval',
        '3b' => 'for-revision',
        '4a' => 'internally-approved',
        '4b' => 'returned-to-reviewer',
        '4c' => 'redraft',
        '5' => 'client-reviewed',
        '6' => 'client-approved',
        '7' => 'post-update',
    ];

    public function __construct($id = null)
    {
        global $conn, $currentTimestamp;
        $this->conn = $conn;
        $this->ts = $currentTimestamp;
        $this->changeHistory = [];

        if ($id) {
            $this->setId($id);
        }
    }

    /* setters */
    public function setId($id, $hashed = false)
    {
        global $switch_user_id, $user_id;
        try {
            if (!isset($id)) {
                throw new Exception('ID cannot be null');
            }

            $data = $this->conn->execute(
                "SELECT id, title, user_id,
                (SELECT id FROM tbl_fsp_version WHERE haccp_id = h.id AND since IS NOT NULL ORDER BY created_at DESC LIMIT 1) AS vid,
                (SELECT facility_id FROM tbl_fsp_version_details WHERE version_id = vid) AS facility,
                (SELECT id FROM tbl_fsp_version_details WHERE version_id = vid) AS did
                FROM tbl_fsp h WHERE " . ($hashed ? 'md5(id)' : 'id') . " = ? AND deleted_at IS NULL",
                $id
            )->fetchAssoc();

            if ($data['user_id'] != ($switch_user_id ?? $user_id)) {
                throw new Exception("Incorrect HACCP Id.");
            }

            if (!count($data)) {
                throw new Exception("No existing record with the id provided was found.");
            } else {
                $this->id = $data['id'];
                $this->version_id = $data['vid'];
                $this->details_id = $data['did'];
                $this->title = $data['title'];
                $this->owner_id = $data['user_id'];
                $this->facility = $data['facility'];
            }

            return $data;
        } catch (Exception $e) {
            http_response_code(500);
            exit($e->getMessage());
        }
    }

    public function setVersion($version_id, $hashed = false)
    {
        global $switch_user_id, $user_id;
        try {
            if (!isset($version_id)) {
                throw new Exception('ID cannot be null');
            }

            $data = $this->conn->execute(
                "SELECT id, title, user_id,
                (SELECT id FROM tbl_fsp_version WHERE " . ($hashed ? 'MD5(id)' : 'id') . " = ?) AS vid,
                (SELECT facility_id FROM tbl_fsp_version_details WHERE version_id = vid) AS facility,
                (SELECT id FROM tbl_fsp_version_details WHERE version_id = vid) AS did
                FROM tbl_fsp h WHERE id = ? AND deleted_at IS NULL",
                $version_id,
                $this->id
            )->fetchAssoc();

            if ($data['user_id'] != ($switch_user_id ?? $user_id)) {
                throw new Exception("Incorrect HACCP Id.");
            }

            if (!count($data)) {
                throw new Exception("No existing record with the id provided was found.");
            } else {
                $this->id = $data['id'];
                $this->version_id = $data['vid'];
                $this->details_id = $data['did'];
                $this->title = $data['title'];
                $this->owner_id = $data['user_id'];
                $this->facility = $data['facility'];
            }

            return $data;
        } catch (Exception $e) {
            http_response_code(500);
            exit($e->getMessage());
        }
    }

    public function getResource($withComponents = false)
    {
        $details = $this->conn->execute("SELECT * FROM tbl_fsp_version_details WHERE id = ?", $this->details_id)->fetchAssoc();
        $components = $this->conn->execute("SELECT * FROM tbl_fsp_components WHERE version_id = ?", $this->version_id)->fetchAll();

        $data = array(
            'id' => $this->id,
            'version_id' => $this->version_id,
            'description' => $this->title,
            'version' => $this->versionName(),
            'status' => $this->versionStatus(),
            'facility' => $details['facility_id'] ?? null,
            'diagram' => json_decode($details['diagram'] ?? '[]', true),
            'products' => json_decode($details['products'] ?? '[]'),
            'products_name' => $details['products_name'] ?? '',
            'document_code' => $details['document_code'],
            'issue_date' => $details['issue_date'] ?? '',
            'processes' => array(),
        );

        if ($withComponents) {
            foreach ($components as $c) {
                $data['processes'][$c['id']] = array(
                    'id' => $c['id'],
                    'label' => $c['label'],
                    'process' => $c['process_step'],
                    'hazardAnalysis' => htmlDecode(json_decode($c['hazard_analysis'], true)),
                    'ccpDetermination' => htmlDecode(json_decode($c['ccp_determination'], true)),
                    'clmca' => htmlDecode(json_decode($c['clmca'], true)),
                    'vrk' => htmlDecode(json_decode($c['vrk'], true)),
                );
            }
        }

        return $data;
    }

    public function getDiagramImage()
    {
        $details = $this->conn->execute("SELECT diagram_image FROM tbl_fsp_version_details WHERE id = ?", $this->details_id)->fetchAssoc();
        return $details['diagram_image'] ?? null;
    }

    public function versionName()
    {
        $versions = $this->getVersions();

        foreach ($versions as $v) {
            if (isset($v['current']) && $v['current']) {
                return $v['version'];
            }
        }
    }

    public function versionStatus()
    {
        $version = $this->conn->execute("SELECT status FROM tbl_fsp_version WHERE id = ?", $this->version_id)->fetchAssoc();
        return $this->getEqStatus($version['status']);
    }

    public function getEqStatus($status)
    {
        switch ($status) {
            case self::$step['1']:
                return 'Draft';
            case self::$step['2']:
                return 'For Review';
            case self::$step['3a']:
                return 'For Approval';
            case self::$step['3b']:
                return 'For Revision';
            case self::$step['4a']:
                return 'Approved by CIG';
            case self::$step['4b']:
                return 'Returned To Reviewer';
            case self::$step['4c']:
                return 'Returned To Drafter';
            case self::$step['5']:
                return 'Reviewed by Client';
            case self::$step['6']:
                return 'Approved by Client';
            default:
                return 'Unknown status';
        }
    }

    public function getLogs($user_id, $version = null)
    {
        if (!isset($version)) {
            $version = hash('md5', $this->version_id);
        }

        $logs = $this->conn->execute("SELECT l.*, CONCAT(hr.first_name, ' ', hr.last_name) AS logger, hr.user_id AS employer_id FROM tbl_fsp_logs l LEFT JOIN tbl_user u ON u.id = l.portal_user JOIN tbl_hr_employee hr ON u.employee_id = hr.ID WHERE MD5(version_id) = ? ORDER BY l.created_at DESC", $version)->fetchAll();
        $data = [];

        $user = new IIQ_User($this->conn, $user_id);
        $user_id = $user->employer('ID');

        foreach ($logs as $l) {
            $compliance = $l['logger'];

            // current user is not a CIG employee
            if ($user_id != CIG_USER_ID) {
                // logger is a CIG employee, display only 'compliance'
                // otherwise, display the name
                $compliance = $l['employer_id'] != CIG_USER_ID ? $l['logger'] : 'Compliance';
            } else {
                // logger is a CIG employee, display name with compliance indicator
                $compliance = $l['employer_id'] == CIG_USER_ID ? $l['logger'] . (' (Compliance)') : $l['logger'];
            }

            $data[] = array(
                'description' => $l['description'],
                'category' => $this->getEqStatus($l['category']),
                'datetime' => date('M j Y g:i A', strtotime($l['created_at'])),
                'time_elapsed' => timeElapsed($l['created_at']),
                'user' => $compliance
            );
        }

        return $data;
    }

    public function getChangeHistory($version = null)
    {
        if (!isset($version)) {
            $version = $this->version_id;
            $this->changeHistory = [];
        }

        $data = $this->conn->execute("SELECT * FROM tbl_fsp_version WHERE id = ?", $version)->fetchAssoc();
        if (count($data)) {
            $lastLog = $this->conn->execute("SELECT description FROM tbl_fsp_logs WHERE version_id = ? ORDER BY created_at DESC LIMIT 1", $data['id'])->fetchAssoc();
            $firstLog = $this->conn->execute("SELECT portal_user FROM tbl_fsp_logs WHERE version_id = ? ORDER BY created_at ASC LIMIT 1", $data['id'])->fetchAssoc();

            $author = new IIQ_User($this->conn, $firstLog['portal_user']);
            $authorEmp = $author->employee('ID');
            $author = $author->employer('ID') != CIG_USER_ID ? ($author->first_name . ' ' . $author->last_name) : 'Arnel Ryan';

            if ($author == 'Arnel Ryan') {
                $position = 'FSC, PCQI, FSVPQI';
            } else {
                $position = $this->getTeamPosition($authorEmp);
            }

            $ver = $this->getEqStatus($data['status']);
            $ver = ($ver == 'Approved by Client' || $ver == 'Reviewed by Client') ? 1 : 'draft';
            $this->changeHistory[] = array(
                'id' => $data['id'],
                'version' => $ver,
                'date' => date('Ymd', strtotime($data['created_at'])),
                'description' => $lastLog['description'] ?? '',
                'author' => $author,
                'supersedes' => $data['supersedes'],
                'title' => $position,
            );

            // recurse if there is supersedes
            // to store the previous versions
            if (isset($data['supersedes'])) {
                $this->getChangeHistory($data['supersedes']);
            }
        }

        return $this->changeHistory;
    }

    public function getVersions()
    {
        $versions = $this->getChangeHistory();
        $data = [];

        $count = 0;
        foreach ($versions as $v) {
            $arr = array(
                'id' => $v['id'],
                'version' => $v['version'] == 'draft' ? 'Draft' : (!isset($v['supersedes']) ? 'Original' : ('Revision ' . ++$count))
            );

            if ($v['id'] == $this->version_id) {
                $arr['current'] = true;
            }
            $data[] = $arr;
        }
        return $data;
    }

    /**
     * Copy of php_mailer_1 function
     */
    public function sendEmail($to, $user, $subject, $body, $from, $name)
    {
        try {
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            // $mail->SMTPDebug  = SMTP::DEBUG_SERVER;
            $mail->Host       = 'interlinkiq.com';
            $mail->CharSet       = 'UTF-8';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'admin@interlinkiq.com';
            $mail->Password   = 'L1873@2019new';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;
            $mail->clearAddresses();
            $mail->setFrom('services@interlinkiq.com', 'Interlink IQ');
            $mail->addAddress($to, $user);
            $mail->addReplyTo($from, $name);
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $body;
            $mail->send();
            return true;
        } catch (Exception $e) {
            send_response(['error' => "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"], 500);
            exit();
        }
    }

    // creating new haccp plan
    public function create($arr)
    {
        try {
            $this->conn->begin_transaction();

            $haccpParams = self::paramBuilder([
                'user_id' => $arr['owner'],
                'title' => $arr['description'],
                'developed_by' => $arr['developer'] ?? null,
                'developed_at' => date('Y-m-d', strtotime($this->ts)),
                'developer_sign' => $arr['developer_sign'] ?? null,
            ]);

            // create haccp record first...
            $this->conn->execute("INSERT INTO tbl_fsp({$haccpParams['columns']}) VALUE({$haccpParams['params']})", $haccpParams['values']);
            $this->id = $this->conn->lastInsertID();
            $this->version_id = $this->newVersion(self::$step['1'], $arr);
            $this->haccpComponents(json_decode($arr['processes'], true));

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            http_response_code(500);
            $this->conn->rollback();
            exit($e->getMessage());
        }
    }

    public function update($arr, $user, IIQ_User $currentUser)
    {
        try {
            $this->conn->begin_transaction();

            $description = trim($arr['change_description']);
            $description = empty($description) ? null : $description;
            $resultMsg = '';
            $assignedBy = $currentUser->employer('ID') == CIG_USER_ID ? 'Arnel Ryan' : ($_COOKIE['first_name'] ?? '') . ' ' . ($_COOKIE['last_name'] ?? '');
            $session = isset($arr['session']) ? $this->getAction($arr['session']) : null;

            if ($session) {
                $lastSender = new IIQ_User($this->conn, $session['portal_user']);
                $session['sender'] = $lastSender->employee('ID');
            }

            // update haccp title
            $this->conn->execute("UPDATE tbl_fsp SET title = ? WHERE id = ?", $arr['description'], $this->id);

            if (isset($arr['save_as'])) {
                $this->updateCurrentVersion($arr);
            }

            switch ($arr['save_as'] ?? null) {
                case 'draft':
                    $this->createLog($description ?? 'Updated as draft', self::$step['1'], $user);
                    $resultMsg = 'Update(s) have been saved.';
                    break;
                case 'post_approval_change':
                    $this->createLog($description ?? 'Updated', self::$step['7'], $user);
                    $resultMsg = 'Saved successfully.';
                    break;
                case 'submit_for_review':
                    $logId = $this->createLog($description ?? 'Submitted for review', self::$step['2'], $user);
                    $emailInfo = $this->prepEmailInfo($arr['reviewer'], $arr['facility']);
                    $action = $this->newAction(self::paramBuilder([
                        'version_id' => $this->version_id,
                        'log_id' => $logId,
                        'portal_user' => $user,
                        'recipient_id' => $arr['reviewer'],
                        'type' => self::$step['2'],
                    ]));
                    $this->updateVersionStatus(self::$step['2']);

                    $this->sendEmail(
                        $emailInfo['recipient_email'],
                        $emailInfo['recipient_name'],
                        'HACCP Module - Reviewer',
                        'Hi ' . $emailInfo['recipient_name'] . ', <br><br>
                            <b>Task</b> <br>
                            InterlinkIQ HACCP Module Review <br><br>
                            <b>Description</b> <br>
                            ' . $arr['description'] . ' <br><br>
                            <b>Assigned by</b> <br>
                            ' . $assignedBy . ' <br><br>
                            ' . $this->emailBtn($action) . '
                        ',
                        $emailInfo['enterprise_email'],
                        $emailInfo['enterprise_name']
                    );
                    $resultMsg = 'A notification has been sent to the reviewer.';
                    break;
                case 'reject_review':
                    if ($session == null) {
                        throw new Exception('Session not found or is invalid.');
                    }

                    $this->updateVersionStatus(self::$step['3b']);
                    $logId = $this->createLog($description ?? 'Returned for revision', self::$step['3b'], $user);

                    // send email back to the sender/drafter
                    $emailInfo = $this->prepEmailInfo($session['sender'], $arr['facility']);

                    // close the last session
                    $this->updateAction(self::paramBuilder(['status' => 'closed']), $session['id']);

                    // create new session/action
                    $action = $this->newAction(self::paramBuilder([
                        'version_id' => $this->version_id,
                        'log_id' => $logId,
                        'portal_user' => $user,
                        'recipient_id' => $session['sender'],
                        'in_response_to' => $session['id'],
                        'type' => self::$step['3b'],
                        'remark' => null_if_empty($arr['comment']),
                    ]));

                    $this->sendEmail(
                        $emailInfo['recipient_email'],
                        $emailInfo['recipient_name'],
                        'HACCP Module Notification',
                        'Hi ' . $emailInfo['recipient_name'] . ', <br><br>
                            <b>Task</b> <br>
                            InterlinkIQ HACCP Module Revision <br><br>
                            <b>Description</b> <br>
                            ' . $arr['description'] . ' has been returned by the reviewer for revision. <br><br>
                            <b>Comment</b> <br>
                            ' . (isEmpty($arr['comment']) ? '(None)' : $arr['comment']) . ' <br><br>
                            ' . $this->emailBtn($action) . '
                        ',
                        $emailInfo['enterprise_email'],
                        $emailInfo['enterprise_name']
                    );
                    $resultMsg = 'An email notification has been sent.';
                    break;
                case 'accept_review':
                    if ($session == null) {
                        throw new Exception('Session not found or is invalid.');
                    }

                    $this->updateVersionStatus(self::$step['3a']);
                    $logId = $this->createLog($description ?? 'Reviewed and submitted for approval', self::$step['3a'], $user);
                    $emailInfo = $this->prepEmailInfo($arr['approver'], $arr['facility']);

                    // close the last session
                    $this->updateAction(self::paramBuilder(['status' => 'closed']), $session['id']);

                    // create new session/action
                    $action = $this->newAction(self::paramBuilder([
                        'version_id' => $this->version_id,
                        'log_id' => $logId,
                        'portal_user' => $user,
                        'recipient_id' => $arr['approver'],
                        'in_response_to' => $session['id'],
                        'type' => self::$step['3a'],
                    ]));

                    $this->sendEmail(
                        $emailInfo['recipient_email'],
                        $emailInfo['recipient_name'],
                        'HACCP Module - Approver',
                        'Hi ' . $emailInfo['recipient_name'] . ', <br><br>
                            <b>Task</b> <br>
                            InterlinkIQ HACCP Module for Approval <br><br>
                            <b>Description</b> <br>
                            ' . $arr['description'] . ' <br><br>
                            <b>Assigned by</b> <br>
                            ' . $assignedBy . ' <br><br>
                            ' . $this->emailBtn($action) . '
                        ',
                        $emailInfo['enterprise_email'],
                        $emailInfo['enterprise_name']
                    );
                    $resultMsg = 'Assigned and sent for approval.';
                    break;
                case 'accept_approval':
                    if ($session == null) {
                        throw new Exception('Session not found or is invalid.');
                    }

                    $this->updateVersionStatus(self::$step['4a']);
                    $logId = $this->createLog($description ?? 'Approved by CIG', self::$step['4a'], $user);
                    // close the last session
                    $this->updateAction(self::paramBuilder(['status' => 'closed']), $session['id']);
                    $resultMsg = 'Approved status has been saved.';
                    break;
                case 'reject_approval':
                    if ($session == null) {
                        throw new Exception('Session not found or is invalid.');
                    }

                    $this->updateVersionStatus(self::$step['4b']);
                    $logId = $this->createLog($description ?? 'Returned to reviewer', self::$step['4b'], $user);

                    // send email back to the sender/drafter
                    $emailInfo = $this->prepEmailInfo($session['sender'], $arr['facility']);

                    // close the last session
                    $this->updateAction(self::paramBuilder(['status' => 'closed']), $session['id']);

                    // create new session/action
                    $action = $this->newAction(self::paramBuilder([
                        'version_id' => $this->version_id,
                        'log_id' => $logId,
                        'portal_user' => $user,
                        'recipient_id' => $session['sender'],
                        'in_response_to' => $session['id'],
                        'type' => self::$step['4b'],
                        'remark' => null_if_empty($arr['comment']),
                    ]));

                    $this->sendEmail(
                        $emailInfo['recipient_email'],
                        $emailInfo['recipient_name'],
                        'HACCP Module Notification',
                        'Hi ' . $emailInfo['recipient_name'] . ', <br><br>
                            <b>Task</b> <br>
                            InterlinkIQ HACCP Module Returned for Review
                            <b>Description</b> <br>
                            ' . $arr['description'] . ' has been rejected by the approver. Please review it now. <br><br>
                            <b>Comment</b> <br>
                            ' . isEmpty($arr['comment']) ? '(None)' : $arr['comment'] . ' <br><br>
                            ' . $this->emailBtn($action) . '
                        ',
                        $emailInfo['enterprise_email'],
                        $emailInfo['enterprise_name']
                    );
                    $resultMsg = 'An email notification has been sent.';
                    break;
                case 'assign_drafter':
                    if ($session == null) {
                        throw new Exception('Session not found or is invalid.');
                    }

                    $this->updateVersionStatus(self::$step['4c']);
                    $logId = $this->createLog($description ?? 'Reassigned to drafter', self::$step['4c'], $user);

                    // send email back to the sender/drafter
                    $emailInfo = $this->prepEmailInfo($arr['drafter'], $arr['facility']);

                    // close the last session
                    $this->updateAction(self::paramBuilder(['status' => 'closed']), $session['id']);

                    // create new session/action
                    $action = $this->newAction(self::paramBuilder([
                        'version_id' => $this->version_id,
                        'log_id' => $logId,
                        'portal_user' => $user,
                        'recipient_id' => $arr['drafter'],
                        'in_response_to' => $session['id'],
                        'type' => self::$step['4c'],
                    ]));

                    $this->sendEmail(
                        $emailInfo['recipient_email'],
                        $emailInfo['recipient_name'],
                        'HACCP Module Notification',
                        'Hi ' . $emailInfo['recipient_name'] . ', <br><br>
                            <b>Task</b> <br>
                            InterlinkIQ HACCP Module Returned to Drafter
                            <b>Description</b> <br>
                            ' . $arr['description'] . ' has been reassigned to you. <br><br>
                            ' . $this->emailBtn($action) . '
                        ',
                        $emailInfo['enterprise_email'],
                        $emailInfo['enterprise_name']
                    );
                    $resultMsg = 'An email has been sent to the drafter.';
                    break;
                default:
                    // create new version

                    $prevVersionId = $this->version_id;
                    $this->newVersion(self::$step['1'], $arr);

                    $this->conn->execute("UPDATE tbl_fsp_version SET supersedes = ?, since = NULL WHERE id = ?", $prevVersionId, $this->version_id);

                    $this->createLog($description ?? 'Created new version', self::$step['1'], $user);
                    $resultMsg = 'A new version has been created.';
                    break;
            }

            $this->conn->commit();
            return $resultMsg;
        } catch (Exception $e) {
            $this->conn->rollback();
            exit($e->getMessage());
        }
    }

    public function newVersion($status, $data)
    {
        // creating new version....
        $this->conn->execute("INSERT INTO tbl_fsp_version (haccp_id, status) VALUE(?,?)", $this->id, $status);
        $versionId = $this->conn->lastInsertID();

        // assigning new version details
        $d = self::paramBuilder([
            'version_id' => $versionId,
            'diagram' => $data['diagram'] ?? null,
            'facility_id' => $data['facility'] ?? null,
            'products' => $data['products'] ?? '[]',
            'products_name' => !empty($data['products_name']) ? $data['products_name'] : null,
            'document_code' => !empty($data['document_code']) ? $data['document_code'] : null,
            'issue_date' => !empty($data['issue_date']) ? $data['issue_date'] : null,
        ]);

        $this->conn->execute("INSERT INTO tbl_fsp_version_details ({$d['columns']}) VALUE({$d['params']})", $d['values']);
        $this->details_id = $this->conn->lastInsertID();
        $this->version_id = $versionId;

        return $versionId;
    }

    public function updateVersionStatus($status)
    {
        $this->conn->execute("UPDATE tbl_fsp_version SET status = ? WHERE id = ?", $status, $this->version_id);
        return true;
    }

    public function updateCurrentVersion($data)
    {
        // updating the current version
        $d = self::paramBuilder([
            'version_id' => $this->version_id,
            'diagram' => $data['diagram'] ?? null,
            'facility_id' => $data['facility'] ?? null,
            'products' => $data['products'] ?? '[]',
            'products_name' => !empty($data['products_name']) ? $data['products_name'] : null,
            'document_code' => !empty($data['document_code']) ? $data['document_code'] : null,
            'issue_date' => !empty($data['issue_date']) ? $data['issue_date'] : null,
        ]);

        $this->conn->execute("UPDATE tbl_fsp_version_details SET {$d['params_set']} WHERE version_id = ?", [...$d['values'], $this->version_id]);
        $this->haccpComponents(json_decode($data['processes'], true));
    }

    // saving haccp proccesses
    public function haccpComponents($data)
    {
        if (!count($data)) return;

        $columns = '';
        $values = [];
        $params = [];

        foreach ($data as $k => $d) {
            $x = self::paramBuilder([
                'version_id' => $this->version_id,
                'id' => $d['id'],
                'label' => $d['label'],
                'process_step' => $d['process'],
                'hazard_analysis' => json_encode(html($d['hazardAnalysis'])),
                'ccp_determination' => json_encode(html($d['ccpDetermination'])),
                'clmca' => json_encode(html($d['clmca'])),
                'vrk' => json_encode(html($d['vrk'])),
            ]);

            $columns = $x['columns'];
            $params[] = $x['params'];
            array_push($values, ...$x['values']);
        }

        // delete existing records
        $this->conn->execute("DELETE FROM tbl_fsp_components WHERE version_id = ?", $this->version_id);

        // replace with new data
        $params = implode(',', array_map(function ($x) {
            return "($x)";
        }, $params));
        $this->conn->execute("INSERT INTO tbl_fsp_components ($columns) VALUES $params", $values);
    }

    public function updateDiagramImage($image)
    {
        $this->conn->execute("UPDATE tbl_fsp_version_details SET diagram_image = ? WHERE id = ?", $image, $this->details_id);
        return true;
    }

    public function createLog($description, $category, $portal_user)
    {
        $params = self::paramBuilder([
            'version_id' => $this->version_id,
            'portal_user' => $portal_user,
            'description' => $description,
            'category' => $category,
            'created_at' => date("Y-m-d H:i:s"),
        ]);

        $this->conn->execute("INSERT INTO tbl_fsp_logs ({$params['columns']}) VALUE( {$params['params']} )", $params['values']);
        return $this->conn->lastInsertID();
    }

    public function newAction($params)
    {
        $this->conn->execute("INSERT INTO tbl_fsp_actions ({$params['columns']}) VALUE({$params['params']})", $params['values']);
        $id = $this->conn->lastInsertID();
        return $id;
    }

    public function updateAction($params, $id)
    {
        $this->conn->execute("UPDATE tbl_fsp_actions SET {$params['params_set']} WHERE id = ?", $params['values'], $id);
    }

    public function getAction($hashId = null)
    {
        $action = [];

        if ($hashId == null) {
            // no session id is provided,
            // check for the latest action 
            $action = $this->conn->execute("SELECT * FROM tbl_fsp_actions WHERE version_id = ? AND status = ? ORDER BY created_at DESC LIMIT 1", $this->version_id, 'open')->fetchAssoc();
        } else {
            // session id or hashid is provided, check directly
            $action = $this->conn->execute("SELECT * FROM tbl_fsp_actions WHERE MD5(id) = ?", $hashId)->fetchAssoc();
        }
        return (count($action)) ? $action : null;
    }

    public function teamStructure()
    {
        $team = $this->conn->execute("SELECT * FROM tbl_fsp_team_roster WHERE user_id=? AND deleted_at IS NULL", $this->owner_id)->fetchAll();
        $teamRoster = [];

        foreach ($team as $t) {
            $members = [];
            $members[] = !isEmpty($t['primary_member']) ? $t['primary_member'] : 0;
            $members[] = !isEmpty($t['alternate_member']) ? $t['alternate_member'] : 0;
            $members = implode(',', $members);

            $employeeData = $this->conn->execute("SELECT ID,CONCAT(first_name, ' ', last_name) AS name,department_id,job_description_id FROM tbl_hr_employee WHERE ID in ($members)")->fetchAll();

            foreach ($employeeData as $ed) {
                if ($ed['ID'] == $t['primary_member']) {
                    $teamRoster[$ed['ID']] = [
                        'position' => $t['primary_title'],
                        'name' => $ed['name'],
                    ];
                } else if ($ed['ID'] == $t['alternate_member']) {
                    $teamRoster[$ed['ID']] = [
                        'position' => $t['alternate_title'],
                        'name' => $ed['name'],
                    ];
                }
            }
        }

        return $teamRoster;
    }

    public function getTeamPosition($member)
    {
        $team = $this->teamStructure();
        foreach ($team as $id => $m) {
            if ($member == $id) {
                return $m['position'] ?? 'No position';
            }
        }
        return 'Member not found.';
    }

    public function getSigns()
    {
        $team = $this->teamStructure();
        $struc = [];
        foreach ($team as $id => $t) {
            $data = $this->conn->execute("SELECT * FROM tbl_fsp_pfd_signs WHERE signee_id = ? AND version_id = ?", $id, $this->version_id)->fetchAssoc();
            $struc[] = array(
                'id' => $data['id'] ?? '',
                'signee_id' => $id,
                'name' => $t['name'],
                'date' => $data['date'] ?? null,
                'sign' => $data['sign'] ?? null,
                'position' => $t['position'],
            );
        }
        return $struc;
    }

    public function updateSigns($data, $user)
    {
        try {
            $this->conn->begin_transaction();

            foreach ($data as $k => $d) {
                $params = ['portal_user' => $user];

                if (!isEmpty($d['sign']))
                    $params['sign'] = $d['sign'];

                if (!isEmpty($d['date']))
                    $params['date'] = $d['date'];

                if (isset($d['id'])) {
                    // existing record
                    $p = self::paramBuilder($params);
                    $this->conn->execute("UPDATE tbl_fsp_pfd_signs SET {$p['params_set']} WHERE id = ?", [...$p['values'], $d['id']]);
                } else {
                    $params['version_id'] = $this->version_id;
                    $params['signee_id'] = $d['account'];
                    $p = self::paramBuilder($params);
                    $this->conn->execute("INSERT INTO tbl_fsp_pfd_signs ({$p['columns']}) VALUE({$p['params']})", $p['values']);
                }
            }

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollback();
            return send_response(['error' => $e->getMessage()], 500);
            exit();
        }
    }

    public function addTask($data, $portal_user)
    {
        try {
            $this->conn->begin_transaction();

            $params = self::paramBuilder([
                'portal_user' => $portal_user,
                'version_id' => $this->version_id,
                'assignee_id' => null_if_empty($data['assigned_to'] ?? null),
                'title' => null_if_empty($data['task_title']),
                'description' => null_if_empty($data['task_description']),
                'due_date' => null_if_empty($data['task_due']),
            ]);

            $this->conn->execute("INSERT INTO tbl_fsp_tasks ({$params['columns']}) VALUE({$params['params']})", $params['values']);
            $id = $this->conn->lastInsertID();
            $data = $this->conn->execute("SELECT *, (SELECT CONCAT(first_name, ' ', last_name) as assignee FROM tbl_hr_employee WHERE t.assignee_id IS NOT NULL AND ID = t.assignee_id) AS assignee_name FROM tbl_fsp_tasks t WHERE id = ?", $id)->fetchAssoc();

            // notify assignee
            if (isset($data['assignee_id'])) {
                $emailInfo = $this->prepEmailInfo($data['assignee_id'], $this->facility);
                $this->sendEmail(
                    $emailInfo['recipient_email'],
                    $emailInfo['recipient_name'],
                    'HACCP Module Task Notification',
                    'Hi ' . $emailInfo['recipient_name'] . ', <br><br>
                        <b>Task Title</b> <br>
                        ' . $data['title'] . ' <br><br>
                        <b>Description</b> <br>
                        ' . ($data['description'] ?? '(No description)') . ' <br><br>
                        <b>Due on</b> <br>
                        ' . ($data['due_date'] ?? '(None)') . ' <br><br>
                        ' . $this->emailBtn(null) . '
                    ',
                    $emailInfo['enterprise_email'],
                    $emailInfo['enterprise_name']
                );
            }

            $this->conn->commit();
            return $data;
        } catch (Exception $e) {
            $this->conn->rollback();
            send_response(['error' => $e->getMessage()], 500);
            exit();
        }
    }

    public function getAllTasks()
    {
        $data = $this->conn->execute("SELECT *, (SELECT CONCAT(first_name, ' ', last_name) as assignee FROM tbl_hr_employee WHERE t.assignee_id IS NOT NULL AND ID = t.assignee_id) AS assignee_name FROM tbl_fsp_tasks t WHERE version_id = ?", $this->version_id)->fetchAll();
        return $data;
    }

    public function getPostDocSigns($all = false)
    {
        $data = $this->conn->execute("SELECT developed_by, developed_at, developer_sign, reviewed_by, reviewed_at, reviewer_sign, approved_by, approved_at, approver_sign FROM tbl_fsp WHERE id = ?", $this->id)->fetchAssoc();

        if (!$all && $data['developed_by'] == 'Arnel Ryan') {
            unset($data['developed_by']);
            unset($data['developed_at']);
            unset($data['developer_sign']);
        }

        return $data;
    }

    public function updatePostSigns($arr)
    {
        try {
            $this->conn->begin_transaction();
            $q = [
                'reviewed_by' => empty($arr['reviewer_id']) ? null : $arr['reviewer_id'],
                'reviewed_at' => empty($arr['review_date']) ? null : $arr['review_date'],
                'approved_by' => empty($arr['approver_id']) ? null : $arr['approver_id'],
                'approved_at' => empty($arr['approve_date']) ? null : $arr['approve_date'],
            ];

            if (!empty($arr['developer_sign'])) {
                $q['developer_sign'] = $arr['developer_sign'];
            }

            if (!empty($arr['reviewer_sign'])) {
                $this->updateVersionStatus(self::$step['5']);
                $q['reviewer_sign'] = $arr['reviewer_sign'];
            }

            if (!empty($arr['approver_sign'])) {
                $this->updateVersionStatus(self::$step['6']);
                $q['approver_sign'] = $arr['approver_sign'];
            }

            $q = self::paramBuilder($q);

            if (!$this->conn->execute("UPDATE tbl_fsp SET {$q['params_set']} WHERE id = ?", [...$q['values'], $this->id])) {
                throw new Exception("Something went wrong.");
            }

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            http_response_code(500);
            $this->conn->rollback();
            exit($e->getMessage());
        }
    }

    public static function updateTaskStatus($taskId, $status)
    {
        global $conn;
        try {
            /**
             * @disregard P1009 Undefined type
             */
            $conn->execute("UPDATE tbl_fsp_tasks SET status = ? WHERE id = ?", $status, $taskId);

            /**
             * @disregard P1009 Undefined type
             */
            if ($conn->affectedRows()) {
                return true;
            }
            throw new Exception('Unable to complete this action.');
        } catch (Exception $e) {
            send_response(['error' => $e->getMessage()], 500);
            exit();
        }
    }

    public static function paramBuilder($arr)
    {
        $paramKeys = [];
        $paramValues = [];

        foreach ($arr as $k => $v) {
            $paramKeys[] = $k;
            $paramValues[] = $v;
        }

        return [
            'columns' => implode(',', $paramKeys),
            'params' => implode(',', array_map(function ($a) {
                return '?';
            }, $paramKeys)),
            'params_set' => implode(',', array_map(function ($a) {
                return $a . '=?';
            }, $paramKeys)),
            'values' => $paramValues,
        ];
    }

    public static function all($owner)
    {
        global $conn;
        /**
         * @disregard P1009 Undefined type
         */
        $records = $conn->execute("SELECT id FROM tbl_fsp WHERE user_id = ? AND deleted_at IS NULL", $owner)->fetchAll();

        $arr = [];
        foreach ($records as $r) {
            $arr[] = new self($r['id']);
        }

        return $arr;
    }

    private function prepEmailInfo($recipient, $facility)
    {
        $assignee = $this->conn->execute("SELECT email,first_name,last_name FROM tbl_hr_employee WHERE ID = ?", $recipient)->fetchAssoc();
        $facility = $this->conn->execute("SELECT facility_id, facility_category FROM tblFacilityDetails where users_entities = ? AND facility_id = ?", $this->owner_id, $facility)->fetchAssoc();
        $enterp = $this->conn->execute("SELECT email,first_name,last_name FROM tbl_user WHERE ID=?", $this->owner_id)->fetchAssoc();

        return [
            'recipient_name' => $assignee['first_name'] . ' ' . $assignee['last_name'],
            'recipient_email' => $assignee['email'],
            'firstname' => $assignee['first_name'],
            'lastname' => $assignee['last_name'],
            'facility_name' => $facility['facility_category'],
            'enterprise_name' => $enterp['first_name'] . ' ' . $enterp['last_name'],
            'enterprise_email' => $enterp['email'],
        ];
    }

    private function emailBtn($session, $text = 'View')
    {
        global $pageUrl;
        $id = hash('md5', $this->id);
        if ($session != null)
            $session = hash('md5', $session);

        return '<a href="' . $pageUrl . '?edit=' . $id . ($session != null ? '&session=' . $session : '') . '" target="_blank" style="font-weight: 600; padding: 10px 20px!important; text-decoration: none; color: #fff; background-color: #27a4b0; border-color: #208992; display: inline-block;">' . $text . '</a>';
    }
}
