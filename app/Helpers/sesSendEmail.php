<?php

namespace App\Helpers;

use Aws\Ses\SesClient;
use Illuminate\Support\Facades\Auth;

class sesSendEmail
{
    public function sesSendEmail(): void
    {
        $sesClient = new SesClient([
            'version' => 'latest',
            'region' => env('AWS_DEFAULT_REGION'),
            'endpoint' => env('AWS_ENDPOINT'),
        ]);

        $senderEmail = env('AWS_SES_EMAIL');
        $recipientEmails = [Auth::user()->email];
        $configurationSet = 'ConfigSet';

        $subject = 'Export catalog';
        $htmlBody = '<h1>Catalog products exporting in s3 and download in your pc.</h1>' .
            '<p>This email was sent with <a href="https://aws.amazon.com/ses/">' .
            'Amazon SES</a> using the <a href="https://aws.amazon.com/sdk-for-php/">' .
            'AWS SDK for PHP</a>.</p>';
        $plaintextBody = 'This email was send with Amazon SES using the AWS SDK for PHP.';
        $charSet = 'UTF-8';

        $sesClient->sendEmail([
            'Destination' => [
                'ToAddresses' => $recipientEmails,
            ],
            'ReplyToAddresses' => [$senderEmail],
            'Source' => $senderEmail,
            'Message' => [
                'Body' => [
                    'Html' => [
                        'Charset' => $charSet,
                        'Data' => $htmlBody,
                    ],
                    'Text' => [
                        'Charset' => $charSet,
                        'Data' => $plaintextBody,
                    ],
                ],
                'Subject' => [
                    'Charset' => $charSet,
                    'Data' => $subject,
                ],
            ],
            'ConfigurationSetName' => $configurationSet,
        ]);
    }
}
