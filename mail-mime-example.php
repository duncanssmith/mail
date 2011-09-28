<?php

include('Mail.php');
include('Mail/mime.php');

$text = 'Text version of email';
$html = '<html><body>HTML version of email</body></html>';
$file = '~duncansmith/Sites/mail/Mailer.php';
$crlf = "\n";
$headers['From']='duncan@iting.com';
$headers['To']='duncanssmith@gmail.com';
$headers['Subject'] = 'Test mime message - Subject';

$mime = new Mail_mime(array('eol' => $crlf));

$mime->setTXTBody($text);
$mime->setHTMLBody($html);
$mime->addAttachment($file, 'text/plain');

// do not ever try to call these lines in reverse order
// when using versions older than 1.6.0
//$body = $mime->get();
// or in 1.6.0 and newer
$body = $mime->getMessageBody();

#echo "\nHEADERS BEFORE+++++\n\n";
#var_dump($headers);
#$headers = $mime->txtHeaders($headers);
#echo "\nHEADERS AFTER+++++\n\n";
#var_dump($headers);
#print_r($headers);

$mail =& Mail::factory('mail');
$ret = $mail->send('duncanssmith@gmail.com', $headers, $body);
#var_dump($ret);
#print_r($ret);
#var_dump($mail);
?> 

