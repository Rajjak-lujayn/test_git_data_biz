<?php
phpinfo();
exit;
// The message
ini_set("mail.log", "/tmp/mail.log");
ini_set("mail.add_x_header", TRUE);
ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1); 
// Send
 //$result = mail('panditnitesh223@gmail.com', 'My Subject', $message);
//  $to = 'panditnitesh223@gmail.com';
// $subject = 'the subject';
// $message = 'hello';
// $headers = 'From:nitesh.pandit.lujayninfoways@gmail.com' . "\r\n" .
//     'Reply-To: webmaster@example.com' . "\r\n" .
//     'X-Mailer: PHP/' . phpversion();

//     $result =mail($to, $subject, $message, $headers);
$to_email = 'panditnitesh223@gmail.com';
$subject = 'Testing PHP Mail';
$message = 'This mail is sent using the PHP mail function';
$header = "From: nitesh.pandit.lujayninfoways@gmail.com\r\n";
$header.= "MIME-Version: 1.0\r\n";
$header.= "Content-Type: text/html; charset=ISO-8859-1\r\n";
$header.= "X-Priority: 1\r\n";
echo $to_email;
$result=mail($to_email,$subject,$message,$header);
print_r($result);
if($result){
    echo "mail sent";
}else{
    echo "somthing wrong";
}
?>