<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\MedicalCard;
use App\Models\AdditionalField;
use App\Models\FormField;
use App\Models\FormRule;
use App\Models\Testing;
use App\Forms\RecordForm;
use App\Models\Children;
use App\Models\Group;
use App\Models\Parental_Link;
use Illuminate\Support\Facades\Validator;

class MedicalController extends Controller
{

    protected $form_fields;
    protected $form_rules;

    public function __construct()
    {
        $this->form_fields = FormField::getFields()->toArray();
        $this->form_rules = FormRule::getRules();
    }

    public function getDbRecords()
    {
        $user = Auth::user();
        $userEmail = $user->email;
        $data = [];
        // Retrieve records from the medical_cards table where the email matches
        if ($user->role == 'Animator') {
            $data = MedicalCard::getAllMedicalCards();
        } else {
            $data = MedicalCard::getUserEmail($userEmail);
        }
        $nbFiches = $data->count();

        $groups = Group::allGroups();
        $chosenGroup = "allGroup";
        $allergies = false;
        // $data = DB::table('medical_card')->where('email', $userEmail)->get();
        return view('medicalCards', compact('data', 'nbFiches','groups','chosenGroup', 'allergies'));
    }

    public function getCardDetails($id)
    {

        $data = DB::table('medical_card')
            ->where('national_number', $id)
            ->get();

        $parent_infos = DB::table('parental_link')
            ->join('medical_card', 'parental_link.national_number', '=', 'medical_card.national_number')
            ->where('parental_link.national_number', $id)
            ->get();
        $fields = RecordForm::getFormFields();

        $additional_fields = AdditionalField::getFields($id)->pluck('field_value', 'field_name')->all();;

        $fields = $this->form_fields;

        $mergedata = (object) array_merge((array)$data[0], $additional_fields);

        $data[0] = $mergedata;

        $groups = Group::allGroups();
        return view('medicalCardsDetails', compact('data', 'parent_infos', 'fields', 'groups'));

    }

    public function createRecord(Request $request)
    {
        $validator = Validator::make($request->all(), $this->form_rules);

        // Check if the validation fails
        if ($validator->fails()) {
            // Redirect back with validation errors
            return redirect()->back()->withErrors($validator)->withInput();
        }
        try {
            $request_data = $request->all();
            $custom_data = [];
            MedicalCard::createMedicalCard($request_data);

            foreach ($this->form_fields as $field) {
                if ($field['isCustomField']) {
                    AdditionalField::insert([
                        'medical_card' => $request_data['national_number'],
                        'field_name' => $field['name'],
                        'field_value' => $request_data[$field['name']],
                    ]);
                }
            }
        } catch (\Exception $e) {
            // Gestion de l'exception si le numéro national existe déjà
            return redirect()->back()->withErrors(['national_number' => $e->getMessage()])->withInput();
        }
        // If validation passes, proceed with your logic
        $data = $request->all();

        // Emergency contact of parent and doctor
        $data['emergency_contact_parent'] = $request->input('emergency_contact_parent');

        $child_data = [
            'national_number' => $data['national_number'],
            'parent_1' => Auth::user()->email,
        ];

        Parental_Link::createChild($child_data);

        return redirect('fiches');
    }

    public function deleteRecord(Request $request)
    {
        $data = $request->all();
        MedicalCard::deleteMedicalCard($data['national_number']);
        return redirect('fiches');
    }

    public function getRecordEditPage($id)
    {
        $data = MedicalCard::getMedicalCardById($id);
    }

    public function editRecord(Request $request)
    {
        $validator = Validator::make($request->all(), $this->form_rules);

        // Check if the validation fails
        if ($validator->fails()) {

            // Redirect back with validation errors
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // If validation passes, proceed with your logic
        $data = $request->all();
        MedicalCard::updateMedicalCard($data['national_number'], $data);
        foreach ($this->form_fields as $field) {
            if ($field['isCustomField']) {
                AdditionalField::updateField(
                    $data['national_number'],
                    $field['name'],
                    [
                        'medical_card'  => $data['national_number'],
                        'field_name'    => $field['name'], 
                        'field_value'   => $data[$field['name']]
                    ],
                );
            }
        }
        return redirect('fiches/details/' . $data['national_number']);
    }

    public function display_form()
    {
        $formFields = $this->form_fields;
        return view("animateur/fiche_medicale_create", compact('formFields'));
    }
    
    public function addGroup(Request $request){
    $originalName = $request->input('originalName');
    $newName = $request->input('newName');
    $national_number = $request->input('national_number');
    var_dump($originalName, $newName, $national_number);

    Parental_Link::updateGroupNameChild($originalName, $newName,$national_number);

    return redirect('fiches/details/' . $request->input('national_number'));
    }

    public function filterGroup(Request $request){
        $chosenGroup = $request->input('group');
        $allergies = $request->input('allergies');
        if($chosenGroup == "allGroups") {
            if($allergies) {
                return redirect()->route("filter_allergies");
            } else {
                return redirect()->route("records");
            }
        }
        $user = Auth::user();
        $userEmail = $user->email;
        $data;
        if($allergies) {
            $data = MedicalCard::filterByGroupAndAllergies($chosenGroup);
        } else {
            $data = MedicalCard::filterByGroup($chosenGroup);
        }
        $nbFiches = $data->count();
        $groups = Group::allGroups();
        // $data = DB::table('medical_card')->where('email', $userEmail)->get();
        return view('medicalCards', compact('data', 'nbFiches','groups','chosenGroup', 'allergies'));
    }

    public function filterAllergies(){
        $chosenGroup = "allGroups";
        $user = Auth::user();
        $userEmail = $user->email;
        $data = MedicalCard::getAllergies();
        $nbFiches = $data->count();
        $groups = Group::allGroups();
        $allergies = true;
        return view('medicalCards', compact('data', 'nbFiches','groups', 'chosenGroup', 'allergies'));
    }
}
