<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class JsonModel extends Model
{

    protected $keyType = "string";

    /**
     * Override all function to return static data
     */
    public static function all($columns = []) {
        $jsonData = json_decode(file_get_contents(base_path(self::getJsonDataPath())), true);
        return collect($jsonData)->map(function($data) {
            $obj = new (static::class);
            $obj->id = $data['id'];
            $obj->fill(Arr::except($data, ['id']));
            return $obj;
        });
    }

    /**
     * Override where Eloquent function
     */
    public static function where($key, $value) {
        return static::all()->where($key, $value);
    }

    /**
     * Return single item by id
     */
    public static function findById($id) {
        $all = static::all()->keyBy('id');
        return $all[$id] ?? null;
    }
}
