<?php


namespace App\Casts;


use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class Price implements CastsAttributes
{

    public function get($model, string $key, $value, array $attributes)
    {
        return number_format((float)$value, 2);
    }

    public function set($model, string $key, $value, array $attributes)
    {
        // TODO: Implement set() method.
        return $value;
    }
}
