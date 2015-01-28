# Headzoo Nexmo
Library for communicating with the Nexmo SMS API.


[![Build Status](https://travis-ci.org/headzoo/nexmo.svg?branch=master)](https://travis-ci.org/headzoo/nexmo)
[![Latest Stable Version](https://poser.pugx.org/headzoo/nexmo/v/stable.svg)](https://packagist.org/packages/headzoo/nexmo)
[![License](https://poser.pugx.org/headzoo/nexmo/license.svg)](https://packagist.org/packages/headzoo/nexmo)


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

$nexmo_api_key = "n3xm0rocks";
$nexmo_api_secret = "12ab34cd";
$from = "12015555555";
$sms = Sms::factory($nexmo_api_key, $nexmo_api_secret, $from);

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
