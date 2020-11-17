<?php
namespace Mabehiry\Sms\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SmsSetting extends Model
{
    use SoftDeletes;

    protected $casts = [
        'parameters' => 'array'
    ];

}
