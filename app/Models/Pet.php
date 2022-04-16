<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    use HasFactory;

    protected $table = 'pets';

    protected $fillable = [
        'name',
        'gender',
        'datebirth',
        'weight',
        'description',
        'image',
        'categories_id'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'categories_id', 'id');
    }

    public function gallery()
    {
        return $this->hasMany(Gallery::class);
    }

    public function setDateBirthAttribut($value)
    {
        $this->attributes['datebirth'] = Carbon::createFromDate('d/m/Y', $value)->format('Y-m-d');
    }
}
