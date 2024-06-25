<php
    $e = $_GET['email'];
    
    <!--// https://www.codexworld.com/verify-email-address-check-if-real-exists-domain-php/-->

    <!--// Include library file-->
    <!--require_once 'VerifyEmail.class.php'; -->

    <!--// Initialize library class-->
    <!--$mail = new VerifyEmail();-->

    <!--// Set the timeout value on stream-->
    <!--$mail->setStreamTimeoutWait(20);-->

    <!--// Set debug output mode-->
    <!--$mail->Debug= TRUE; -->
    <!--$mail->Debugoutput= 'html'; -->

    <!--// Set email address for SMTP request-->
    <!--$mail->setEmailFrom('from@email.com');-->

    <!--// Email to check-->
    <!--$email = $e; -->

    <!--// Check if email is valid and exist-->
    <!--if($mail->check($email)){ -->
    <!--    echo 'Email &lt;'.$email.'&gt; is exist!'; -->
    <!--}elseif(verifyEmail::validate($email)){ -->
    <!--    echo 'Email &lt;'.$email.'&gt; is valid, but not exist!'; -->
    <!--}else{ -->
    <!--    echo 'Email &lt;'.$email.'&gt; is not valid and not exist!'; -->
    <!--} -->




    // =========================================================
    
    
    
    
    // inspired by a note at http://php.net/manual/en/function.getmxrr.php
    // further inspiration from https://github.com/webdigi/SMTP-Based-Email-Validation
    function validateEmail($email)
    {
     $emailValid = false;
     $domain = extractFullyQualifiedDomainFromEmail($email);
     $mxHost = findPreferredMxHostForDomain($domain);
     if ($mxHost) {
         //    echo $mxHost . "<br>";
         $mxSocket = @fsockopen($mxHost, 25, $errno, $errstr, 2);
         if ($mxSocket) {
             $response = "";
             // say HELO to mailserver
             $response .= sendCommand($mxSocket, "EHLO mx1.validemail.com");
             // initialize sending mail
             $response .= sendCommand($mxSocket, "MAIL FROM:<info@validemail.com>");
             // try recipient address, will return 250 when ok..
             $rcptText = sendCommand($mxSocket, "RCPT TO:<" . $email . ">");
             $response .= $rcptText;
             if (substr($rcptText, 0, 3) == "250") {
             $emailValid = true;
             }
             // quit mail server connection
             sendCommand($mxSocket, "QUIT");
             fclose($mxSocket);
         }
     }
     return $emailValid;
    }
    function extractFullyQualifiedDomainFromEmail($email)
    {
     $mailSegments = explode("@", $email);
     $domain = $mailSegments[1];
     // http://stackoverflow.com/q/14065946/131929
     // fully qualified domain names should end with a '.', DNS resolution may otherwise take a very long time
     if (substr($domain, -1) != ".") {
     return $domain . ".";
     }
     return $domain;
    }
    function findPreferredMxHostForDomain($domain)
    {
     $mxRecordsAvailable = getmxrr($domain, $mxRecords, $mxWeight);
     if ($mxRecordsAvailable) {
         // copy mx records and weight into array $mxHosts
         $mxHosts = array();
         for ($i = 0; $i < count($mxRecords); $i++) {
         $mxHosts[$mxRecords[$i]] = $mxWeight[$i];
         }
         asort($mxHosts, SORT_NUMERIC);
         reset($mxHosts);
         return array_keys($mxHosts)[0];
     } else {
        return null;
     }
    }
    function sendCommand($mxSocket, $command)
    {
     //  print htmlspecialchars($command) . "<br>";
     fwrite($mxSocket, $command . "\r\n");
     $response = "";
     stream_set_timeout($mxSocket, 1);
     // Wait at most 10 * timeout for the server to respond.
     // In most cases the response arrives within timeout time and, therefore, there's no need to wait any longer in such
     // cases (i.e. keep timeout short). However, there are cases when a server is slow to respond and that for-loop will
     // give it some slack. See http://stackoverflow.com/q/36961265/131929 for the whole story.
     for ($i = 0; $i < 10; $i++) {
     while ($line = fgets($mxSocket)) {
     $response .= $line;
     }
     // Only continue the for-loop if the server hasn't sent anything yet.
     if ($response != "") {
     break;
     }
     }
     //  print nl2br($response);
     return $response;
    }


    var_dump(validateEmail($e));
?>