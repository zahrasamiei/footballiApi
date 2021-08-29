<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Repository extends Model
{
    use HasFactory;

    protected $fillable = ["repId", "name", "username", "description", "language", "html_url"];
    public $timestamps = false;

    public function tags()
    {
        return $this->hasMany(Tag::class, "repId");
    }
}
