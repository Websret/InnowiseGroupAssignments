<?php

namespace App\Helpers;

use Aws\Ses\SesClient;

class sesVerifyEmail
{
    public static function verifyEmail(): void
    {
        $SesClient = new SesClient([
            'version' => 'latest',
            'region' => env('AWS_DEFAULT_REGION'),
            'endpoint' => env('AWS_ENDPOINT'),
        ]);

        $SesClient->verifyEmailIdentity([
            'EmailAddress' => env('AWS_SES_EMAIL'),
        ]);
    }
}
