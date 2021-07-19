<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appliance extends Model
{
    use HasFactory;

    protected $fillable = ['site', 'location', 'type', 'serial_number', 'production_date', 'description'];

    public function controls()
    {
        return $this->hasMany(Control::class);
    }
}
