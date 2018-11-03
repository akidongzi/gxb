<?php
/**
 * Created by PhpStorm.
 * User: lindowx
 * Date: 2018/10/30
 * Time: 15:46
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    const TYPE_COUNTRY  = 1;
    const TYPE_STATE    = 2;
    const TYPE_CITY     = 3;
    const TYPE_REGION   = 4;

    public $timestamps = false;
}