<?php

require dirname(__DIR__).'/vendor/autoload.php';

$to='some@add.ress';
$from='another@add.ress';



(new easymail\SendmailMailer())
	->mail('The Subject', 'The <b>Message</b>')
	->to($to)
	->from($from)
	->send();