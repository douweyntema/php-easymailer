<?php
/**
 *  this is a wrapper that can be used to attach a logging method or some logic specific to some framework etc.
 *  ie:
 *
    getMailer(){
     
       //return new easymail\SMTPMailer($username, $password, $host, $port);

		return new easymail\EventMailer(
				new easymail\SMTPMailer($username, $password, $host, $port),
				function($mailData){
				
						//system specific logic (may log mail event)

				});
    }
 *    
 */


namespace easymail;

/**
 * @SuppressWarnings("short");
 */
class EventMailer{
	

	protected $mailerInstance = false;
	protected $onMailedCallbackFn = false;

	protected $subject;
	protected $message;
	protected $type;


	protected $to;
	protected $from;
	protected $fromName;

	public function __construct(Mailer $mailerInstance, \Closure $onMailedCallbackFn) {
		$this->mailerInstance=$mailerInstance;
		$this->onMailedCallbackFn=$onMailedCallbackFn;
	}

	public function mail($subject, $message, $type = 'html') {
		
		$this->subject=$subject;
		$this->message=$message;
		$this->type=$type;

		$this->mailerInstance->mail($subject, $message, $type);
		return $this;

	}

	/**
	 * @SuppressWarnings("short");
	 */
	public function to($arrayOrString) {

		$this->to=$arrayOrString;

		$this->mailerInstance->to($arrayOrString);
		return $this;
	}
	public function from($address, $name = null) {

		$this->from=$address;
		$this->fromName=$name;

		$this->mailerInstance->from($address, $name);
		return $this;
	}

	public function send() {

		$mailerResponse = $this->mailerInstance->send();

		$onMailedCallbackFn=$this->onMailedCallbackFn;
		$onMailedCallbackFn(array(

			'subject'=>$this->subject,
			'message' =>$this->message,
			'type' =>$this->type,
			'to' =>$this->to,
			'from' =>$this->from,
			'fromName' =>$this->fromName,
			'response'=>$mailerResponse

		));

		return $mailerResponse;

	}





}