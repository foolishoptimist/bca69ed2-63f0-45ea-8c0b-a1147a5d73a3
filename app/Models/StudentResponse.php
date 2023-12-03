<?php

namespace App\Models;

use App\Models\JsonModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;

class StudentResponse extends JsonModel
{
    use HasFactory;

    protected $fillable = [
        'assessmentId',
        'assigned',
        'started',
        'completed',
        'studentId',
        'studentYearLevel',
        'responses',
        'results',
    ];

    /**
     * Override all function to return static data
     */
    public static function all($columns = []) {
        $jsonData = json_decode(file_get_contents(base_path(self::getJsonDataPath())), true);
        return collect($jsonData)->map(function($data) {
            $obj = new (static::class);
            $obj->id = $data['id'];
            $data['studentId'] = $data['student']['id'];
            $data['studentYearLevel'] = $data['student']['yearLevel'];
            $obj->fill(Arr::except($data, ['id', 'student']));
            return $obj;
        });
    }

    /**
     * Return path to model data
     */
    public static function getJsonDataPath() {
        return 'database/data/student-responses.json';
    }

    public function getCompletionDate($format = 'Y-m-d H:i:s') {
        return Carbon::parse(str_replace('/', '-', $this->completed))->format($format);
    }
}
