<?php

//Retrieve form data. 
//GET - user submitted data using AJAX
//POST - in case user does not support javascript, we'll use POST instead
$name = isset($_GET['name']) ? $_GET['name'] : $_POST['name'];
$email = isset($_GET['email']) ? $_GET['email'] : $_POST['email'];
$comment = isset($_GET['message']) ? $_GET['message'] : $_POST['message']; 

ini_set('sendmail_from', $email);
$sendmail_path = '/usr/sbin/sendmail -t -i -f mail_php@bsboisconcept.com';

//ini_set('sendmail_path', $email);
//$sendmail_path = "/usr/sbin/sendmail -t -i";

//flag to indicate which method it uses. If POST set it to 1

if ($_POST) $post=1;
$errors=[];

//Simple server side validation for POST data, of course, you should validate the email
if (!$name) $errors[count($errors)] = 'Prénom obligatoire.';
if (!$email) $errors[count($errors)] = 'Email obligatoire'; 
if (!$comment) $errors[count($errors)] = 'Message obligatoire'; 

//if the errors array is empty, send the mail
if (!$errors) {

	//recipient - replace your email here
	//$to = 'bs.bois.concept@gmail.com';
	$to = 'ahmed.benamrouche@gmail.com';	
	//sender - from the form
	//$from = $name . ' <' . $email . '>';
	//$from = $name . ' <' . $email . '>';
	$from = $email;
	
	//subject and the html message
	$subject = 'Message de ' . $name;	
	$message = 'Prénom: ' . $name . '<br/><br/>
		       Email: ' . $email . '<br/><br/>		
		       Message: ' . nl2br($comment) . '<br/>';

	//send the mail


	$result = sendmail($to, $subject, $message, $from);
	
	//if POST was used, display the message straight away
	if ($_POST) {
		echo '<br> Result ' . $result;
		echo '<br> to ' . $to;
		echo '<br> From ' . $from;
		echo '<br> subject ' . $subject;
		echo '<br> Message ' . $message;
		echo '<br> ' . phpinfo();
		if ($result) echo 'Merci ! Nous avons biem reçu votre message.';
		else echo 'Désolé, une erreur est survenue. envoyez nous votre projet à bs.bois.concept@gmail.com';
		
	//else if GET was used, return the boolean value so that 
	//ajax script can react accordingly
	//1 means success, 0 means failed
	} else {
		echo $result;	
	}

//if the errors array has values
} else {
	//display the errors message
	for ($i=0; $i<count($errors); $i++) echo $errors[$i] . '<br/>';
	echo '<a href="index.html">Back</a>';
	exit;
}


//Simple mail function with HTML header
function sendmail($to, $subject, $message, $from) {
	$headers = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
	$headers .= 'To: ' . $to . "\r\n";
	$headers .= 'From: ' . $from . "\r\n";

	echo $headers;
	
	$result =  mail('ahmed.benamrouche@gmail.com', 'My Subject', 'djwdnsjnd');
	//mail($to,$subject,$message,$headers);
	//$result = window.open('mailto:' . $to . '?subject=' . $subject . '&body=' . $message);
	;
	if ($result) return 1;
	else return 0;
}

?>