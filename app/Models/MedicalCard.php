<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MedicalCard extends Model
{
    protected $table = 'medical_card';
    
    protected $primaryKey = 'national_number';

    protected $fillable = [
        'national_number',
        'first_name',
        'last_name',
        'can_participate',
        'doctor',
        'tetanos_protected',
        'allergies',
        'medecins',
        'birth_date',
        'additional_infos',
        'street',
        'no',
        'mail_box',
        'postal_code',
        'city',
        'tetanos_update',
        'phone_number_doctor',
        'emergency_contact_parent'
    ];

    protected $casts = [
        'can_participate' => 'boolean',
        'tetanos_protected' => 'boolean',
    ];

    public static function createMedicalCard($data)
    {
        if (self::where('national_number', $data['national_number'])->exists()) {
            // Vous pouvez personnaliser ce message d'erreur
            throw new \Exception("Un enregistrement avec le numéro de registre national donné existe déjà.");
        }
        $medicalCard = new self;
        $medicalCard->national_number = $data['national_number'];
        $medicalCard->fill($data);

        // emergency contact of parent and doctor
        $medicalCard->emergency_contact_parent = $data['emergency_contact_parent'];
        // $medicalCard->emergency_contact_doctor = $data['emergency_contact_doctor'];

        $medicalCard->save();
        return $medicalCard;
        //return self::create($data);
    }

    public static function updateMedicalCard($id, $data)
    {
        $medicalCard = self::find($id);
        if ($medicalCard) {
            $medicalCard->update($data);
            return $medicalCard;
        }
        return null;
    }

    public static function deleteMedicalCard($id)
    {
        $medicalCard = self::find($id);
        if ($medicalCard) {
            $medicalCard->delete();
            return true;
        }
        return false;
    }

    public static function getAllMedicalCards()
    {
        $data = DB::table('medical_card as Mc')->join('parental_link as pt','pt.national_number','=','Mc.national_number')->get();
        return $data;
    }

    public static function getMedicalCardById($id)
    {
        return self::find($id);
    }

    public static function getUserEmail($email)
    {
        $data = DB::table('medical_card as Mc')->join('parental_link as pt', 'pt.national_number', '=', 'Mc.national_number')->where('parent_1', $email)->orWhere('parent_2', $email)->get();
        return $data;
    }

    public static function filterByGroup($group){
        $data = DB::table('medical_card as Mc')->join('parental_link as pt','pt.national_number','=','Mc.national_number')->where('group',$group)->get();
        return $data;
    }

    public static function getAllergies(){
        $data = DB::table('medical_card as Mc')->join('parental_link as pt','pt.national_number','=','Mc.national_number')->whereNotNull('allergies')->get();
        return $data;
    }

    public static function filterByGroupAndAllergies($group){
        $data = DB::table('medical_card as Mc')->join('parental_link as pt','pt.national_number','=','Mc.national_number')->where('group',$group)->whereNotNull('allergies')->get();
        return $data;
    }
}
