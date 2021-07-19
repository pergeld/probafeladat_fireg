<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Control extends Model
{
    use HasFactory;

    protected $fillable = ['maintenance', 'date', 'description', 'appliance_id'];

    public function appliance()
    {
        return $this->belongsTo(Appliance::class);
    }
}
