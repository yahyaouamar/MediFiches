<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormField extends Model
{
    // use HasFactory;
    protected $table = 'FormField';
    protected $primaryKey = 'name';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'label',
        'type',
        'order',
        'placeholder',
        'isTextArea',
        'isCustomField',
    ];

    public static function getFields()
    {
        return self::orderBy('order')->get();
    }

    public static function createField($data)
    {
        self::where('order', '>=', $data['order'])->increment('order');
        $data['isCustomField'] = 1;
        return self::create($data);
    }
    public static function moveFieldUp($name, $old_order, $data)
    {
        $form_field = self::find($name);
        if ($form_field) {
            self::whereBetween('order', [$data['order'], $old_order - 1])->increment('order');
            $form_field->update($data);
            return $form_field;
        }
        return null;
    }
    public static function moveFieldDown($name, $old_order, $data)
    {
        $form_field = self::find($name);
        if ($form_field) {
            self::whereBetween('order', [$data['order'], $old_order + 1])->decrement('order');
            $form_field->update($data);
            return $form_field;
        }
        return null;
    }

    public static function deleteField($name, $data)
    {
        $field = self::find($name);
        if ($field) {
            self::where('order', '>', $field->order)->decrement('order');
            $field->delete();
            return true;
        }
        return false;
    }
    
    public static function updateField($name, $data)
    {
        $field = self::find($name);
        if($field) 
        {
            $field->update($data);
            return true;
        }
        return false;
    }

}
