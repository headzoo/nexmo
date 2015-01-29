# Headzoo Nexmo
Library for communicating with the Nexmo SMS API.


[![Build Status](https://travis-ci.org/headzoo/nexmo.svg?branch=master)](https://travis-ci.org/headzoo/nexmo)
[![Latest Stable Version](https://poser.pugx.org/headzoo/nexmo/v/stable.svg)](https://packagist.org/packages/headzoo/nexmo)
[![License](https://poser.pugx.org/headzoo/nexmo/license.svg)](https://packagist.org/packages/headzoo/nexmo)


### Overview
[Nexmo](https://www.nexmo.com) is an inexpensive provider of voice and text (SMS) services based in the UK. This library is used to communicate with their API for the purpose of sending text messages to mobile devices.


### Installing via Composer

The recommended way to install headzoo/nexmo is through
[Composer](http://getcomposer.org).

```bash
# Install Composer
curl -sS https://getcomposer.org/installer | php
```

Add headzoo/nexmo to your composer.json:

```javascript
"require": {
	"headzoo/nexmo": "dev-master"
}
```

Or run the Composer command to install the latest stable version of headzoo/nexmo:

```bash
composer require headzoo/nexmo
```

After installing, you need to require Composer's autoloader:

```php
require 'vendor/autoload.php';
```

### Usage
```php
use Headzoo\Nexmo\Sms;
use Headzoo\Nexmo\Exception\Exception;


// Start by creating an instance of Sms. You must have a Nexmo API key and secret, which you can find
// on the Nexmo dashboard. https://dashboard.nexmo.com/private/dashboard
// You also provide the "from" number or name. Each text you sent with the Sms instance will be sent
// from that number.
$nexmo_api_key = "n3xm0rocks";
$nexmo_api_secret = "12ab34cd";
$from = "12015555555";
$sms = Sms::factory($nexmo_api_key, $nexmo_api_secret, $from);


// To send a text message you pass the number you are sending to, in international format, along with
// the message to send. A Response instance is returned from which you can gather the details of the
// sent message. Keep in mind Nexmo may break up your text into several messages depending on
// the size of the sent message, and the Response will contain multiple Message instances.
try {
	$to = "19295555555";
	$message = "Hello, World!";
	$response = $sms->text($to, $message);
	foreach($response as $message) {
		echo "Message ID: " . $message->getId();
		echo "Message price: " . $message->getPrice();
		echo "Remaining balance: " . $message->getBalance();
	}
} catch (Exception $e) {
	echo $e->getMessage();
}
```
