<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use phpDocumentor\Reflection\Types\Self_;

/**
 * @property int $id
 * @property string $code
 * @property int $count
 * @property int $used
 * @property int $price
 * @property int $percent
 * @property Carbon $valid_from
 * @property Carbon $valid_to
 * @property bool $is_active
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Discount extends Eloquent
{
    protected $guarded = ['id'];

    protected $casts = [
        'count' => 'int',
        'used' => 'int',
        'valid_from' => 'date',
        'valid_to' => 'date',
        'price' => 'int',
        'percent' => 'int',
        'is_active' => 'bool',
    ];

    protected $appends = [
        'remain',
        'hasExpired'
    ];

    public function getRemainAttribute()
    {
        return $this->getAttribute('count') == -1  ? PHP_INT_MAX : max($this->count -  $this->used, 0 );
    }

    public function getHasExpiredAttribute()
    {
        return (
                $this->getAttribute('count') == -1 or
                max($this->count -  $this->used , 0 ) > 0
            ) and (
                $this->valid_from == null or
                now()->startOfDay()->gte($this->valid_from->startOfDay())
            ) and (
                $this->valid_to == null or
                now()->startOfDay()->lte($this->valid_to->startOfDay())
            ) and $this->is_active;
    }

    public static function generateRandomCode($length = 10)
    {
        do {
            $code = substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
        } while ( self::query()->where('code' , $code)->count() > 0 );
        return $code;
    }

    public function convertPrice($first_price)
    {
        $price = $first_price - $this->price;
        $price = ceil($price * ( 100 - $this->percent) / 100);
        $price = max($price , 0 );
        return min($price , $first_price);
    }

}
