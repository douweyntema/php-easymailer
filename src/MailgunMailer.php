<?php 

namespace easymail;

class MailgunMailer implements Mailer{

	protected $apiUrl='https://api.mailgun.net/v3/';
	protected $domain;
	protected $apiKey;
	

	protected $subject;
	protected $message;
	protected $type;
	protected $to;
	protected $from;
	protected $fromName;

	protected $sent = false;

	public function __construct($domain, $apiKey){

		$this->domain=$domain;
		$this->apiKey=$apiKey;


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
			throw new \Exception('Already sent');
		}

		if ($this->type != 'html') {
			throw new \Exception('Must be html');
		}

		$result=$this->_request($this->apiUrl.$this->domain.'/messages', array(
			'to'=>$this->to,
			'from'=>$this->from,
			'subject'=>$this->subject,
			'html'=>$this->message

		));

		$json=json_decode($result);

		if(empty($json)){
			throw new \Exception($result);
		}

		return $result;

	}



	protected function _request($url, $fields=array()){

		//echo $url;

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $url);

		curl_setopt($ch, CURLOPT_USERPWD, "api:" . $this->apiKey);

		if(count($fields)){

			print_r($fields);
			
			curl_setopt($ch, CURLOPT_POST, count($fields));
			curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
		}
		//curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); //required for xtracta file upload, (api call is redirected to an upload page)


		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$result = curl_exec($ch);

		curl_close($ch);

		return $result;

	}


}