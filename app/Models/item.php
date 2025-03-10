<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class item extends Model
{
    /**
     * モデルに関連付けるテーブル
     *
     * @var string
     */
    protected $table = 'item';

    protected $fillable = [
        'title',
        'category',
        'price',
        'detail',
    ];
}
