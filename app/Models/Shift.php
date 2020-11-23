<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    use HasFactory;

    public function gd(){
        return $this->belongsTo(Gd::class);
    }

    public function security(){
        return $this->belongsTo(Security::class);
    }

    public function site(){
        return $this->belongsTo(Site::class);
    }
}
