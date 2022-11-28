<?php

namespace App\Helpers;

use Illuminate\Http\Request;

class ProductFilter
{
    private $query;

    private $filters = ['productType', 'minCost', 'maxCost'];

    public function run(Request $request, $class)
    {
        $this->query = $class::query();

        foreach ($this->filters as $filter) {
            if ($request->$filter && $request->$filter !== 'All') {
                $this->$filter($request->$filter);
            }
        }

        return $this->query;
    }

    public function productType(string $productType): void
    {
        $this->query->where('product_type', '=', $productType);
    }

    public function minCost(string $minCost): void
    {
        $this->query->where('cost', '>=', $minCost);
    }

    public function maxCost(string $maxCost): void
    {
        $this->query->where('cost', '<=', $maxCost);
    }
}
