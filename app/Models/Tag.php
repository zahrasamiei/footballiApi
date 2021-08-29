<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = ["name", "repId"];
    public $timestamps = false;

    public function repository()
    {
        return $this->belongsTo(Repository::class, "repId");
    }
}
