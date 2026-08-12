<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FormFieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $formFields = [
            ['name' => 'national_number', 'label' => 'No. de registre nationale', 'type' => 'text'],
            ['name' => 'last_name', 'label' => 'Nom', 'type' => 'text'],
            ['name' => 'first_name', 'label' => 'Prénom', 'type' => 'text'],
            ['name' => 'emergency_contact_parent', 'label' => 'Numéro de téléphone du parent', 'type' => 'tel', 'placeholder' => 'Entrez le numéro du parent...'],
            ['name' => 'birth_date', 'label' => 'Date de naissance', 'type' => 'date'],
            ['name' => 'can_participate', 'label' => 'Peut participer', 'type' => 'checkbox'],
            ['name' => 'doctor', 'label' => 'Médecin traitant', 'type' => 'text', 'placeholder' => 'Entrez le médecin...'],
            ['name' => 'phone_number_doctor', 'label' => 'Numéro de téléphone', 'type' => 'tel', 'placeholder' => 'Entrez le numéro du médecin...'],
            ['name' => 'tetanos_protected', 'label' => 'Vaccin du tétanos fait ?', 'type' => 'checkbox'],
            ['name' => 'tetanos_update', 'label' => 'Date de dernier rappel', 'type' => 'date'],
            ['name' => 'medecins', 'label' => 'Médicaments', 'type' => 'text', 'placeholder' => 'Entrez le(s) médicament(s)...', 'isTextArea' => true],
            ['name' => 'allergies', 'label' => 'Allergies', 'type' => 'text', 'placeholder' => 'Entrez les allergies...', 'isTextArea' => true],
            ['name' => 'street', 'label' => 'Rue', 'type' => 'text', 'placeholder' => 'Entrez votre rue'],
            ['name' => 'no', 'label' => 'Numéro', 'type' => 'text', 'placeholder' => 'Entrez votre numéro'],
            ['name' => 'mail_box', 'label' => 'Boite Postale', 'type' => 'text', 'placeholder' => 'Entrez votre numéro de boite'],
            ['name' => 'postal_code', 'label' => 'Code Postal', 'type' => 'number', 'placeholder' => 'Entrez votre code postal'],
            ['name' => 'city', 'label' => 'Ville', 'type' => 'text', 'placeholder' => 'Entrez votre ville'],
            ['name' => 'additional_infos', 'label' => 'Informations additionnelles', 'type' => 'textarea', 'placeholder' => 'Entrez des informations supplémentaires', 'isTextArea' => true],
        ];

        foreach ($formFields as $index => $field) {
            $field['order'] = $index + 1;
            DB::table('FormField')->insert($field);
        }
    }
}
