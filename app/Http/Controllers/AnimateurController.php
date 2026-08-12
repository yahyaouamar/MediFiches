<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Testing;
use App\Forms\RecordForm;
use App\Models\Children;
use App\Models\FormField;
use App\Models\FormRule;
use Illuminate\Support\Facades\Validator;

class AnimateurController extends Controller
{
    protected $form_fields;
    protected $form_rules;

    public function __construct()
    {
        $this->form_fields = FormField::getFields()->toArray();
        $this->form_rules = FormRule::getRules();
    }

    public function viewAnimateur(Request $request){
        return view('viewAnimateur');
    }
    public function customFormView(Request $request){
        $default_order = sizeof($this->form_fields) + 1;
        $types = [
            'text',
            'tel',
            'number',
            'checkbox',
            'radio',
            'date',
            'textarea'
        ];
        $fields = $this->form_fields;
        // print_r($fields);
        return view('customFields', compact('default_order', 'types', 'fields'));
    }

    public function addCustomField(Request $request)
    {
        $validator = $request->validate([
            'name' => ['required','string', 'max:50', 'unique:FormField'],
            'label' => ['required', 'string', 'max:50'],
            'type' => ['required', 'string'],
            'order' => ['required', 'integer'],
        ]);
        FormField::createField($validator);
        return redirect()->route('custom_form_view');
    }

    public function changeFieldOrder(Request $request)
    {
        $data = $request->all();
        $name = $request->all()['name'];
        $new_order = $request->all()['order'];
        $default_new_order = sizeof($this->form_fields) + 1;
        if($new_order > 0 && $new_order < $default_new_order)
        {
            if($data['order'] - $data['old_order'] < 0)
            {
                FormField::moveFieldUp($name, $data['old_order'], $data);
            }
            else{
                FormField::moveFieldDown($name, $data['old_order'], $data);
            }
        }
        return redirect()->route('custom_form_view');
    }
    
    public function deleteCustomField(Request $request)
    {
        $data = $request->all();
        FormField::deleteField($data['name'], $data);
        return redirect()->route('custom_form_view');
    }

    public function editCustomField(Request $request)
    {
        $validator = $request->validate([
            'name' => ['required','string', 'max:50', 'unique:FormField'],
            'label' => ['required', 'string', 'max:50'],
            'type' => ['required', 'string'],
            'order' => ['required', 'integer'],
        ]);
        $data = $validator;
        FormField::updateField($data['name'], $data);
        return redirect()->route('custom_form_view');
    }

    public function createAnimateur(Request $request){
        $validator = $request->validate([
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'last_name' => ['required', 'string', 'max:255'],
            'first_name' => ['required', 'string', 'max:255'],
        ]);
    
        // If validation fails, it will automatically redirect back with errors.
        User::createAnimateur($validator);
        return redirect()->route('view_Animateur');
    }

}