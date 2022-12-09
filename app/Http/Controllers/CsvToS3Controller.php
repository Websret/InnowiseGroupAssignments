<?php

namespace App\Http\Controllers;

use App\Helpers\sesSendEmail;
use App\Helpers\sesVerifyEmail;
use App\Jobs\SendFileJob;
use App\Models\Product;
use App\Helpers\S3Aws;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use VladimirYuldashev\LaravelQueueRabbitMQ\Queue\Connectors\RabbitMQConnector;

class CsvToS3Controller extends Controller
{
    public function export(): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        $filename = 'catalog-' . Auth::user()->id . '-' . date('Y_m_d') . '.csv';
        $filepath = public_path('storage/' . $filename);

        $this->fillFile($filepath);

        dispatch(new SendFileJob(Auth::user(),$filename, $filepath));

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
}
