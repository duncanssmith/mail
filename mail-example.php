<?php
include('Mail.php');

$recipients = 'duncanssmith@gmail.com';

$headers['From']    = 'duncan@iting.com';
$headers['To']      = 'duncanssmith@gmail.com';
$headers['Subject'] = 'Test message - Subject';

$body = 'Test message - Body';

$params['sendmail_path'] = '/usr/sbin/sendmail';

// Create the mail object using the Mail::factory method
$mail_object =& Mail::factory('sendmail', $params);

$mail_object->send($recipients, $headers, $body);
?> 
