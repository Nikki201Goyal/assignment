<?php

namespace App\DB\Models;

use Illuminate\Support\Arr;
use Jenssegers\Mongodb\Eloquent\Model;

class BaseModel extends Model
{
    protected $connection = 'mongodb';

    protected $guarded = [];

    const CREATED_AT = 'createdAt';

    const UPDATED_AT = 'updatedAt';

//    public function unsetAttribute($key): static
//    {
//        if(isset($this->attributes[$key])) {
//            unset($this->attributes[$key]);
//        }
//
//        return $this;
//    }
//
//    public function setAttribute($key, $value)
//    {
//        if(is_null($value)) {
//            return $this->unsetAttribute($key);
//        }
//
//        return parent::setAttribute($key, $value);
//    }

    /**
     * Set a given attribute on the model.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return $this
     */
    public function setAttribute($key, $value)
    {
        if ($value === null) {
            unset($this->attributes[$key]);
        }

        return parent::setAttribute($key, $value);
    }
}
