<?php

namespace App\Helpers;

use Aws\S3\S3Client;

class S3Aws
{
    public static function s3saveInBucket(string $filename, string $filepath): void
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
}
