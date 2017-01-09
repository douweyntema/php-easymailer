# php-easymailer
Abstracts the actual mail implementation sendmail, phpmailer, mailgun api, etc and just provide a simple interface


Using Mailgun API

```php

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

```


Using SMTP, (mailgun in this case)
```php

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


```


Using Sendmail
```php

require dirname(__DIR__).'/vendor/autoload.php';

$to='some@add.ress';
$from='another@add.ress';

(new easymail\SendMailer($username, $password, $host, $port))
	->mail('The Subject', 'The <b>Message</b>')
	->to($to)
	->from($from)
	->send();


```
