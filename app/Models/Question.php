<?php

namespace App\Models;

use App\Models\JsonModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Question extends JsonModel
{
    use HasFactory;

    protected $fillable = [
        'stem',
        'type',
        'strand',
        'config',
    ];

    /**
     * Return path to model data
     */
    public static function getJsonDataPath() {
        return 'database/data/questions.json';
    }

}
