<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Setting extends Model
{
    use HasFactory, SoftDeletes;

    protected $keyType = 'string';
    protected $primaryKey = 'setting_id';
    protected $table = 'setting';
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $guarded = ['setting_id'];
}
