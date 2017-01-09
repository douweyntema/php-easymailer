<?php


require dirname(__DIR__).'/vendor/autoload.php';

$username='XXXXXXXX';
$password='XXXXXXXX';
$host='smtp.mailgun.org';
$port='587';

$to='some@add.ress';
$from='another@add.ress';



(new easymail\PHPMailerMailer($username, $password, $host, $port))
	->mail('The Subject', 'The <b>Message</b>')
	->to($to)
	->from($from)
	->send();


	(new easymail\SendMailer())
	->mail('The Subject', 'The <b>Message</b>')
	->to($to)
	->from($from)
	->send();