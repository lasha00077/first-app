<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\PropertyType;

class PropertyType extends Model
{
    use HasFactory;
    protected $guarded = [];
}
