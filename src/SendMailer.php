<?php

namespace easymail;

/**
 * TODO: move this to System Parameters or Mail (if there is one) Plugin.
 * create an interface, for the methods of this class, use system to get Mailer.
 */

/**
 * (new SendMailer())->mail('Subject', 'message')->to('nickblackwell82@gmail.com')->from('nickblackwell82@gmail.com')->send();
 */

class SendMailer  implements Mailer{

	protected $subject;
	protected $message;
	protected $type;
	protected $to;
	protected $from;
	protected $fromName;

	protected $sent = false;

	public function __construct() {

	}

	public function mail($subject, $message, $type = 'html') {

		$this->subject = $subject;
		$this->message = $message;
		$this->type = $type;

		return $this;

	}

	public function to($arrayOrString) {

		if (is_string($arrayOrString)) {
			$this->to = $arrayOrString;
		} elseif (is_array($arrayOrString)) {

			$this->to = implode(', ', array_filter($arrayOrString, function ($e) {
				$email = trim($e);
				if (empty($email)) {
					return false;
				}
				return true;
			}));

		} else {
			throw new Exception('Expected array or string to($email)');
		}

		return $this;
	}
	public function from($address, $name = null) {

		$this->from = $address;
		$this->fromName = $name ? $name : $address;

		return $this;
	}

	public function send() {

		if ($this->sent) {
			throw new Exception('Already sent');
		}

		if ($this->type != 'html') {
			throw new Exception('Must be html');
		}

		$headers = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: ' . $this->fromName . ' <' . $this->from . '>' . "\r\n";

		$result = mail($this->to, $this->subject, $this->message, $headers);

		$this->sent = true;

		if(!$result){
			throw new Exception(error_get_last());
		}

		return $result;

	}

}
