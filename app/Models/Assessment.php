<?php

namespace App\Models;

use App\Models\JsonModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Assessment extends JsonModel
{
    use HasFactory;

    protected $fillable = [
        'name',
        'questions',
    ];

    /**
     * Return path to model data
     */
    public static function getJsonDataPath() {
        return 'database/data/assessments.json';
    }

}
