<?php

namespace App\Http\Requests\Products;

use App\Http\Requests\BaseRequest;

class ProductRequest extends BaseRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'id' => ['required', 'int', 'distinct'],
            'name' => ['required', 'string'],
            'description' => ['required', 'string'],
            'price' => ['required', 'string'],
            'productVariant' => ['required', 'array', 'min:1'],
            'productVariant.*.name' => ['required', 'string'],
            'productVariant.*.stockCount' => ['required', 'numeric'],
            'productVariant.*.additionalCount' => ['required', 'int'],
            'productVariant.*.SKU' => ['required', 'string'],
        ];
    }

 //todo could write message here
}
