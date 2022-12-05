<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Aws\Exception\AwsException;
use Aws\Ses\SesClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Aws\S3\S3Client;

class CsvToS3Controller extends Controller
{
    public function export(): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        $filename = 'catalog-' . Auth::user()->id . '-' . date('Y_m_d') . '.csv';
        $filepath = public_path('storage/' . $filename);

        $this->fillFile($filepath);

        $this->s3saveInBucket($filename, $filepath);
//        $this->verifyEmail();
        $this->sesSendEmail();
        return Storage::disk('public')->download($filename);
    }

    private function fillFile(string $filepath): void
    {
        $products = Product::with('type')->get();

        $fp = fopen($filepath, 'w');

        foreach ($products as $fields) {
            fputcsv($fp, [
                $fields->name,
                $fields->manufacture,
                $fields->release_date,
                $fields->cost,
                $fields->description,
                $fields->type->type_name,
            ]);
        }

        fclose($fp);
    }

    private function s3saveInBucket(string $filename, string $filepath): void
    {
        $s3client = new S3Client([
            'version' => 'latest',
            'region' => env('AWS_DEFAULT_REGION'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT'),
            'endpoint' => env('AWS_ENDPOINT'),
        ]);

        $s3client->putObject([
            'Bucket' => 'bucket',
            'Key' => $filename,
            'CopySource' => $filepath,
        ]);
    }

    private function sesSendEmail(): void
    {
        $sesClient = new SesClient([
            'version' => 'latest',
            'region' => env('AWS_DEFAULT_REGION'),
            'endpoint' => env('AWS_ENDPOINT'),
        ]);

        $senderEmail = 'task20-4@localhost.com';
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

    private function verifyEmail(): void
    {
        $SesClient = new SesClient([
            'version' => 'latest',
            'region' => env('AWS_DEFAULT_REGION'),
            'endpoint' => env('AWS_ENDPOINT'),
        ]);

        $email = 'task20-4@localhost.com';

        $SesClient->verifyEmailIdentity([
            'EmailAddress' => $email,
        ]);
    }
}
