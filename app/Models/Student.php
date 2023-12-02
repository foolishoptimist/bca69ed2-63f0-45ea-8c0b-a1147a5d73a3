<?php

namespace App\Models;

use App\Models\JsonModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends JsonModel
{
    use HasFactory;

    protected $fillable = [
        'firstName',
        'lastName',
        'yearLevel'
    ];

    /**
     * Return path to model data
     */
    public static function getJsonDataPath() {
        return 'database/data/students.json';
    }

    public function getName() {
        return $this->firstName . ' '. $this->lastName;
    }

    /**
     * Generate Diagnostic Report
     */
    public function diagnosticReport() {
        $output = "";
        return $output;
    }

    /**
     * Generate Progress Report
     */
    public function progressReport() {
        $output = '';
        return $output;
    }

    /**
     * Generate Feedback Report
     */
    public function feedbackReport() {
        $output = "";
        return $output;
    }
}
