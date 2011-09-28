<?php

date_default_timezone_set('GMT');
$now=date("Y-m-d H:i:s");

#require "Mailer.php";

include('Mail.php');
include('Mail/mime.php');

#Mail_Mime package parameters
$params=array(
  #'eol'=>"\r\n",
  'eol'=>"\n",
  'delay_file_io'=>false,
  'head_encoding'=>"quoted-printable",
  'text_encoding'=>"quoted-printable",
  'html_encoding'=>"quoted-printable",
  'head_charset'=>"iso-8859-1",
  'text_charset'=>"iso-8859-1",
  'html_charset'=>"iso-8859-1",
);

Mail_Mime::Mail_Mime($params);

$mailRecipients=array(
  'user'=> array(
    'to'=>"duncanssmith@gmail.com",
    'fromname'=>"rs_dev.",
    'fromemail'=>"noreply@iting.co.uk",
    'cc'=>"",
    'bcc'=>"",
    'subject'=>"*** Subject: [" . $now ."] ***",
    'body'=>"*** Body ***",
    'attachment'=>"img/hand.jpg",
    'attachment_type'=>"image/jpeg"
  )
);

$m=new Mailer(
          $mailRecipients['user']['to'],
          $mailRecipients['user']['fromname'],
          $mailRecipients['user']['fromemail'],
          $mailRecipients['user']['cc'],
          $mailRecipients['user']['bcc'],
          $mailRecipients['user']['subject'],
          $mailRecipients['user']['body'],
          $mailRecipients['user']['attachment'],
          $mailRecipients['user']['attachment_type']
);

#print "Mailtest:[".$m->getMailDetails()."]\n";

#print $m->sendMailNow("mailtest");

echo "Calling sendMailWithAttachmentNow(\"mailtest\")\n";
print $m->sendMailWithAttachmentNow("mailtest");

#echo Mailer::hello();
#echo "Calling simplemail(); \n";
#echo Mailer::simplemail('duncanssmith@gmail.com');

?>
