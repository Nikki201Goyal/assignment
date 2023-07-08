<?php

namespace App\DB\ArrayGenerators;

use App\DB\ArrayGenerators\ArrayGenerator;
use App\DB\Models\Products\Product;

class ProductAG extends ArrayGenerator
{
    private Product $product;

    public function __construct(Product $product)
    {
            parent::__construct();
            $this->product = $product;
    }

    public function addBasicDetails(): static
    {
        return  $this->appendData([
            'id' => $this->product->id,
            'createdAt' => $this->product->createdAt,
            'updatedAt' => $this->product->updatedAt,
            'name' => $this->product->name,
            'description' => $this->product->description,
            'price' => $this->product->price,
        ]);
    }

    public function addVariantDetails(): static
    {
        $data = [];

        foreach ($this->product->productVariant as $key => $variant) {
            $data['productVariant'] = $variant;
        }
        return $this->appendData($data);

    }



}
