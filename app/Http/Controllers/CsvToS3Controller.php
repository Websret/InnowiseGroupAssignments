<?php

namespace App\Http\Controllers;

use App\Models\Product;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CsvToS3Controller extends Controller
{
    public function export()
    {
        $products = Product::with('type')->get();

        $filename = public_path('storage/catalog-' . Auth::user()->name . '-'.date('Y_m_d'). '.csv');
        $fp = fopen($filename, 'w');

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

        return Storage::disk('public')->download('catalog-Test-2022_11_30.csv');
    }
}
