<?php
namespace App\DB\Models\Products;

use App\DB\ArrayGenerators\ArrayGenerator;
use App\DB\ArrayGenerators\ProductAG;
use App\DB\EloquentRepositories\ProductER;
use App\DB\Models\Model;
use App\DB\Models\Products\embedded\ProductVariant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Relations\EmbedsMany;

/**
 * @property ?string $_id
 * @property ?string $id
 * @property ?string $name
 * @property ?int $price
 * @property ?string $description
 * @property ProductVariant $productVariant
 */
class Product extends Model{

    use HasFactory;
    protected $collection = 'products';

    /**
     * @return EmbedsMany
     */
    public function ProductVariant(): EmbedsMany
    {
        return $this->embedsMany(ProductVariant::class);
    }

    /**
     * @return ProductER
     */
    public static function repository(): ProductER
    {
        return new ProductER;
    }

    /**
     * Find a product by its ID.
     *
     * @param string $id
     * @return Product|null
     */
    public static function findById(int $id): ?Product
    {
        return self::where('id', $id)->first();
    }


    public function arrayGenerator(): ArrayGenerator
    {
        return new ProductAG($this);
    }
}
