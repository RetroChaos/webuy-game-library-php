<?php

namespace app\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class System extends Model
{
    use HasFactory;

    protected $table = 'system';

    protected $fillable = [
        'name',
    ];

    public function games()
    {
        return $this->hasMany(Game::class);
    }
}
