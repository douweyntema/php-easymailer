<?php

namespace easymail;

interface Mailer{

	public function mail($subject, $message, $type = 'html');
	public function to($arrayOrString);
	public function from($address, $name = null);
	public function send();

}