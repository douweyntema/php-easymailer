<?php

namespace easymail;

class SMTPMailer implements Mailer{

	protected $mail;

	protected $sent = false;

	public function __construct($user, $pass, $host, $port = 587) {

		
		$mail = new \PHPMailer(true);

//$mail->SMTPDebug = 3;                               // Enable verbose debug output

		$mail->isSMTP(); // Set mailer to use SMTP
		$mail->Host = $host; // Specify main and backup SMTP servers
		$mail->SMTPAuth = true; // Enable SMTP authentication
		$mail->Username = $user; // SMTP username
		$mail->Password = $pass; // SMTP password
		$mail->SMTPSecure = 'tls'; // Enable TLS encryption, `ssl` also accepted
		$mail->Port = (int) $port; // TCP port to connect to

		$this->mail = $mail;

		// $mail->addReplyTo('info@example.com', 'Information');
		// $mail->addCC('cc@example.com');
		// $mail->addBCC('bcc@example.com');

		//$mail->addAttachment('/var/tmp/file.tar.gz'); // Add attachments
		//$mail->addAttachment('/tmp/image.jpg', 'new.jpg'); // Optional name

		return $this;
	}

	public function mail($subject, $message, $type = 'html') {

		$this->mail->isHTML(true); // Set email format to HTML
		$this->mail->Subject = $subject;
		$this->mail->Body = $message;
		//$this->mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

		return $this;

	}

	public function to($arrayOrString) {

		if (is_string($arrayOrString)) {
			$this->mail->addAddress($arrayOrString); // Name is optional
		} elseif (is_array($arrayOrString)) {

			foreach (array_filter($arrayOrString, function ($e) {
				$email = trim($e);
				if (empty($email)) {
					return false;
				}
				return true;
			}) as $address) {

				$this->mail->addAddress($address);

			}

		} else {
			throw new \Exception('Expected array or string to($email)');
		}

		return $this;
	}
	public function from($address, $name = null) {

		$this->mail->setFrom($address, $name ? $name : $address);
		$this->mail->addReplyTo($address, $name ? $name : $address);

		return $this;
	}

	public function send() {

		if ($this->sent) {
			throw new \Exception('Already sent');
		}

		$result = $this->mail->send();

		$this->sent = true;

		return $result;

	}

}