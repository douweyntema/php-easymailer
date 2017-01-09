<?php 

require dirname(__DIR__).'/vendor/autoload.php';

$apiKey='key-XXXXXXXXXXXXXXXXXXXXX';
$domain='yourdomain.com';


$to='some@add.ress';
$from='another@add.ress';



(new easymail\MailgunMailer($domain, $apiKey))
	->mail('The Subject', 'The <b>Message</b>')
	->to($to)
	->from($from)
	->send();