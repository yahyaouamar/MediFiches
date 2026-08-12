<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormRule extends Model
{
    // use HasFactory;
    protected $table = 'FormRule';

    public static function getRules()
    {
        // Retrieve all field rules
        $formRules = self::all();

        $rules = [];

        foreach ($formRules as $formRule) {
            $field_name = $formRule->field_name;
            $validation_rules = json_decode($formRule->validation_rules, true);
        
            $rules[$field_name] = $validation_rules;
        }

        return $rules;
    }
}
