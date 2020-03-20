# Yoti PHP Sandbox SDK

This repository contains the tools you need to test your Yoti integration.

## Installing the Sandbox

Add the Yoti SDK dependency:

```console
$ composer require yoti/yoti-php-sdk-sandbox
```

## Configuration

* `CLIENT_SDK_ID` is the SDK identifier generated by Yoti Hub in the Key tab when you create your app.

* `/path/to/your-pem-file.pem` is the path to the application pem file. It can be downloaded only once from the Keys tab in your Yoti Hub.

Please do not open the pem file as this might corrupt the key and you will need to create a new application.

## Profile Token Creation

```php
<?php
use Yoti\Sandbox\Profile\SandboxClient;
use Yoti\Sandbox\Profile\Request\TokenRequestBuilder;
use Yoti\Sandbox\Profile\Request\Attribute\SandboxAgeVerification;

try {
    $sandboxClient = new SandboxClient('CLIENT_SDK_ID', '/path/to/your-pem-file.pem');

    $ageVerification = SandboxAgeVerification::forAgeOver(
        18,
        new \DateTime('1980-01-01')
    );

    $tokenRequest = (new TokenRequestBuilder())
        ->setRememberMeId('some remember me ID')
        ->setGivenNames('some given names')
        ->setFamilyName('some family name')
        ->setFullName('some full name')
        ->setDateOfBirth(new \DateTime('1980-01-01'))
        ->setAgeVerification($ageVerification)
        ->setGender('some gender')
        ->setPhoneNumber('some phone number')
        ->setNationality('some nationality')
        ->setStructuredPostalAddress(json_encode([
            'building_number' => 1,
            'address_line1' => 'some address',
        ]))
        ->setBase64Selfie('some base64 encoded selfie')
        ->setEmailAddress('some@email')
        ->setDocumentDetailsWithString('PASSPORT USA 1234abc')
        ->build();

    $token = $sandboxClient->setupSharingProfile($tokenRequest)->getToken();

    $client = new \Yoti\YotiClient('CLIENT_SDK_ID', '/path/to/your-pem-file.pem', [
        'api.url' => 'https://api.yoti.com/sandbox/v1'
    ]);
    $activityDetails = $client->getActivityDetails($token);

} catch(Exception $e) {
    // Handle unhappy path
}
```
