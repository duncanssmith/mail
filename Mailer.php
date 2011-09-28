<?php

class Mailer
{

  protected $to;
  protected $fromename;
  protected $fromemail;
  protected $cc;
  protected $bcc;
  protected $subject;
  protected $body;
  protected $attachment;
  protected $attachment_type;
   
  function __construct( $to
                       ,$fromname
                       ,$fromemail
                       ,$cc
                       ,$bcc
                       ,$subject
                       ,$body
                       ,$attachment
                       ,$attachment_type){
    $this->to = $to;
    $this->fromname = $fromname;
    $this->fromemail = $fromemail;
    $this->cc = $cc;
    $this->bcc = $bcc;
    $this->subject = $subject;
    $this->body = $body;
    $this->attachment = $attachment;
    $this->attachment_type = $attachment_type;
  }

  function getMailDetails(){
    return "TO: {$this->to} <br/>".
           "FROMNAME: {$this->fromname} <br/>".
           "FROMEMAIL: {$this->fromemail} <br/>".
           "CC: {$this->cc} <br/>".
           "BCC: {$this->bcc} <br/>".
           "SUBJECT: {$this->subject} <br/>".
           "BODY: {$this->body}<br/>".
           "ATTACHMENT: {(ATTACHMENT HERE) $this->attachment} <br/>".  
           "ATTACHMENT TYPE: {$this->attachment_type} <br/><br/>"; 
  }

  function sendMailWithAttachmentNow($sender){
     $message="";
     $mime_boundary="";
     $random_hash = md5(date('r', time()));

     $headers="From: $this->fromname <$this->fromemail>";
     $headers .= "\ncc: " . $this->cc;
     $headers .= "\nbcc: " . $this->bcc;

     #$headers = $this->from;
     # Do attachment stuff here 
     $filetype = $this->attachment_type; 
     if(strlen($this->attachment)){
       $fh = fopen($this->attachment, 'rb');
       $filedata = fread($fh, filesize($this->attachment));
       fclose($fh);

       $mime_boundary = "==Multipart_Boundary_x{$random_hash}x";

       $headers .= "\nMIME-Version: 1.0\n" .
         "Content-Type: multipart/mixed;\n" .
         " boundary=\"{$mime_boundary}\"";

         #$message = "This is a multi-part message in MIME format.\n\n" .
       $message .= "\n\n" .
         "--{$mime_boundary}\n" .
         "Content-Type: text/html; charset=\"iso-8859-1\"\n" .
         "Content-Transfer-Encoding: 7bit\n\n" . $this->body;

       $filedata = chunk_split(base64_encode($filedata));
       $message .= "--{$mime_boundary}\n" .
         "Content-Type: {$filetype};\n" .
         " name=\"{$this->attachment}\"\n" .
         "Content-Disposition: attachment;\n" .
         " filename=\"{$this->attachment}\"\n" .
         "Content-Transfer-Encoding: base64\n\n" .
       $filedata . "\n\n" .
       "--{$mime_boundary}--\n";
      
       #echo "<pre>";
       #print_r($message);
       #echo "</pre>";
       #echo "<pre>";
       #print_r($filedata);
       #echo "</pre>";
    }

    # ATTACH THE ATTACHMENT TO THE MESSAGE BODY!!!
    $body = $this->body . "\n\n" . $message;

    #echo "<pre>HEADERS START :".$headers."</pre>";
    #echo "<pre>MESSAGE STARTS :".$message."</pre>";

    $ret = @mail($this->to, 
                 $this->subject, 
                 $message, 
                 $headers);
    #            "From: $this->from");

    $msg=sprintf("\n%s mail sent?: [%s]\n",$sender, ($ret? "Yes":"No"));

    return $msg; 
  }

  function sendMailNow($sender){
    $headers="From: $this->fromname <$this->fromemail>";
    $headers .= "\ncc: " . $this->cc;
    $headers .= "\nbcc: " . $this->bcc;

    $ret = @mail($this->to, 
                 $this->subject, 
                 $this->body, 
                 $headers);

    $msg=sprintf("\n%s mail sent?: [%s]\n",$sender, ($ret? "Yes":"No"));

    return $msg; 
  }
 
  static public function hello(){
    $x = "\nHello\n";
    return $x;
  }

  static public function simplemail($sender){
    $fromname= $sender= 'Duncan Smith';
    $fromemail='duncanssmith@gmail.com';
    $headers="From: $fromname <$fromemail>";
    $headers .= "\ncc: " . 'duncanssmith@gmail.com';
    $headers .= "\nbcc: " . 'duncanssmith@gmail.com';

    $to = 'duncanssmith@gmail.com';
    $subject = '+++ subject +++';
    $body = '*** body ***';

    $ret = @mail($to,$subject,$body,$headers);
                
  
    $msg = sprintf("\n%s mail sent with simplemail()?: [%s]\n",$sender, ($ret? "Yes":"No"));

    return $msg; 
}

}
