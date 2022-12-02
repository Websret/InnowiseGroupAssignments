<?php

namespace App\Http\Controllers;

use App\Models\Files;
use App\Models\Product;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CsvToS3Controller extends Controller
{
    public function export()
    {
        $products = Product::with('type')->get();

        $filename = 'catalog-' . Auth::user()->id . '-'.date('Y_m_d'). '.csv';
        $filepath = public_path('storage/' . $filename);
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

        Storage::disk('s3')->putFileAs('bucket', $filepath, $filename, 'public');
        Storage::disk('s3')->response('images/', $filepath);
        return Storage::disk('public')->download($filename);
    }
}
