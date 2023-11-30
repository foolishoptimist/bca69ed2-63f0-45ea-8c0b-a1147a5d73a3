<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $keyType = "string";
    protected $fillable = [
        'id',
        'firstName',
        'lastName',
        'yearLevel'
    ];

    /**
     * Override all function to return static data
     */
    public static function all($columns = []) {
        $studentsData = json_decode(file_get_contents(base_path('database/data/students.json')), true);
        return collect($studentsData)->map(function($data) { return new Student($data); });
    }

    /**
     * Function to filter data and return subset
     */
    public static function where($key, $value) {
        return self::all()->filter(function($model) use ($key, $value) {
            return $model->getAttribute($key) == $value;
        });
    }

    /**
     * Override all function to return static data
     */
    public static function findById($id) {
        return self::where('id', $id)->first();
    }
}
