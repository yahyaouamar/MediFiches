<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
class FormRuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $validationRules = [
            'national_number'           => ['required', 'string', 'regex:/^[0-9]{11}$/', 'max:11'   ],
            'last_name'                 => ['required', 'string', 'max:255'                         ],
            'first_name'                => ['required', 'string', 'max:255'                         ],
            'birth_date'                => ['required', 'date'                                      ],
            'can_participate'           => ['boolean'                                               ],
            'doctor'                    => ['string', 'max:255'                                     ],
            'tetanos_protected'         => ['boolean','requires_tetanos_update'                     ],
            'medecins'                  => ['nullable', 'string'                                    ],
            'phone_number_doctor'       => ['string', 'max:10'                                      ],
            'emergency_contact_parent'  => ['string', 'max:10'                                      ],
            'allergies'                 => ['nullable', 'string'                                    ],
            'street'                    => ['required', 'string', 'max:255'                         ],
            'no'                        => ['required', 'string', 'max:4'                           ],
            'mail_box'                  => ['nullable', 'string', 'max:4'                           ],
            'postal_code'               => ['required', 'integer'                                   ],
            'city'                      => ['required', 'string', 'max:255'                         ],
            'additional_infos'          => ['nullable', 'string'                                    ],
            'tetanos_update'            => ['nullable','date','requires_tetanos_protected'          ],
        ];

        foreach ($validationRules as $field => $rules) {
            DB::table('FormRule')->insert([
                'field_name'        => $field,
                'validation_rules'  => json_encode($rules),
            ]);
        }
    }
}
