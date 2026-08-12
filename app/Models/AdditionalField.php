<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AdditionalField extends Model
{
    protected $table = 'additional_field';
    protected $primaryKey = ['medical_card', 'field_name'];
    public $incrementing  = false;
    protected $fillable = [
        'medical_card',
        'field_name',
        'field_value',
    ];

    public static function getFields($medical_card)
    {
        $fields = DB::table('additional_field')
            ->where('medical_card', $medical_card)
            ->get(['field_name', 'field_value']);

        return $fields;
    }
    public static function getField($medical_card, $field_name)
    {
        return  self::where('medical_card', $medical_card)
            ->where('field_name', $field_name)->first(['field_name', 'field_value']);
    }

    public static function insert($data)
    {
        return self::create($data);
    }

    public static function deleteField($medical_card, $field_name)
    {
        $field = self::where('medical_card', $medical_card)
            ::where('field_name', $field_name)->first();

        if ($field) {
            $field->delete();
            return true;
        }
        return false;
    }
    public static function deleteAll($medical_card)
    {
        $fields = self::getFields($medical_card);
        foreach ($fields as $field) {
            $field->delete();
        }
    }
    public static function updateField($medical_card, $field_name, $data)
    {
        $field = self::getField($medical_card, $field_name);
        if($field == null) 
        {
            $field = self::insert($data);
        }
        $field->update($data);
        return true;
    }

    /**
     * Set the keys for a save update query.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function setKeysForSaveQuery($query)
    {
        $keys = $this->getKeyName();
        if (!is_array($keys)) {
            return parent::setKeysForSaveQuery($query);
        }

        foreach ($keys as $keyName) {
            $query->where($keyName, '=', $this->getKeyForSaveQuery($keyName));
        }

        return $query;
    }

    /**
     * Get the primary key value for a save query.
     *
     * @param mixed $keyName
     * @return mixed
     */
    protected function getKeyForSaveQuery($keyName = null)
    {
        if (is_null($keyName)) {
            $keyName = $this->getKeyName();
        }

        if (isset($this->original[$keyName])) {
            return $this->original[$keyName];
        }

        return $this->getAttribute($keyName);
    }
}
