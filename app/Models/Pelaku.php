<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;

class Pelaku extends Model implements Authenticatable
{
    use HasFactory, SoftDeletes, AuthenticatableTrait;

    protected $keyType = 'string';
    protected $primaryKey = 'pelaku_id';
    protected $table = 'pelaku';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $guarded = ['pelaku_id'];
}
