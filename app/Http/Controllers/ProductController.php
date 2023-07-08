<?php

namespace App\Http\Controllers;
use App\DB\Models\Products\embedded\ProductVariant;
use App\DB\Models\Products\Product;
use App\Http\Requests\Products\ProductRequest;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ProductController
{
    public function store(Request $request)
    {
        $product = new Product();
        $product->id = $request->get('id');
        $product->name = $request->get('name');
        $product->description = $request->get('description');
        $product->price = $request->get('price');

        $productVariant = new ProductVariant();
        $productVariant->name = $request->get('name');
        $productVariant->stockCount = $request->get('stockCount');
        $productVariant->additionalCount = $request->get('additionalCount');
        $productVariant->SKU = $request->get('SKU');

        $product->productVariant()->associate($productVariant);
        $product->save();

        return response()->json('product stored successfully');
    }


    public function index(Request $request)
    {
        $perPage = (int)$request->get('perPage', 50);
        $page = (int)$request->get('page', 1);


        $query = Product::query();

        $query->orderBy('createdAt', 'DESC');

        if ($request->get('productName')) {
            $query->where('name', $request->get('productName'));
        }

        if ($request->get('description')) {
            $query->where('description', $request->get('description'));
        }

        if ($request->get('variantName')) {
            $query->where('ProductVariant.name', $request->get('variantName'));
        }

        $result = $query->paginate(perPage: $perPage, page: $page);

        $products = $result->items();
        $paginator = $this->createPaginatorArray($result);


        $productData = collect($products)->map(function (Product $product) {
            return $product->arrayGenerator()
                ->addBasicDetails()
               ->addVariantDetails()
                ->getData();
        });

        return response()->json([
            'products' => $productData,
            'paginator' => $paginator
        ]);
    }

    public function update(Request $request)
    {
        $productId = $request->route('productId');

        $product = Product::findById($productId);

        if (!$product) {
            throw new HttpException(400, 'No product found');
        }

        $product->id = $request->get('id');
        $product->name = $request->get('name');
        $product->description = $request->get('description');
        $product->price = $request->get('price');

        // Update the existing product variant if provided
        $productVariant = $product->productVariant->first();
        if ($productVariant) {
            $productVariant->name = $request->get('variant.name');
            $productVariant->stockCount = $request->get('variant.stockCount');
            $productVariant->additionalCount = $request->get('variant.additionalCount');
            $productVariant->SKU = $request->get('variant.SKU');
            $productVariant->save();
        }

        $product->save();

        return response()->json('Product updated successfully');
    }


    public function delete(Request $request)
    {
        $productId = (int)$request->route('productId');

        $product = Product::findById($productId);

        if (!$product) {
            throw new HttpException(400, 'No product found');
        }

        $product->delete();

        return response()->json('Product deleted successfully');
    }


    public function createPaginatorArray(LengthAwarePaginator $paginator): array
    {
        $paginationDetails = [
            'currentPage' => $paginator->currentPage(),
            'perPage' => $paginator->perPage(),
            'total' => $paginator->total(),
            'totalPages' => ceil($paginator->total() / $paginator->perPage()),
            'currentUrl' => request()->fullUrl(),
            'prevUrl' => null,
            'prevPage' => null,
            'nextUrl' => null,
            'nextPage' => null,
        ];

        if ($paginator->currentPage() > 1) {
            $query = request()->query();
            $query['page'] = $paginator->currentPage() - 1;
            $paginationDetails['prevUrl'] = request()->url() . '?' . http_build_query($query);
            $paginationDetails['prevPage'] = $paginator->currentPage() - 1;
        }

        if (($paginator->currentPage() * $paginator->perPage()) < $paginator->total()) {
            $query = request()->query();
            $query['page'] = isset($query['page']) ? ++$query['page'] : 2;
            $paginationDetails['nextUrl'] = request()->url() . '?' . http_build_query($query);
            $paginationDetails['nextPage'] = $paginator->currentPage() + 1;
        }

        return $paginationDetails;
    }

}
