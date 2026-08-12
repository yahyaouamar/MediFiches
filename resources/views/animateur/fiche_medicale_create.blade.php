<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Créez une fiche médicale') }}
        </h2>
    </x-slot>

    <div style="background-image: url('{{ asset('images/medi-banner.png') }}'); background-size: cover; background-position: center; height: 100vh; position: relative; background-attachment: fixed; margin: 0;">
        <div class="container" style="padding-top: 5rem;">
            <form action="{{ route('create_record') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="bg-white p-4">
                            <x-validation-errors class="mb-4" />

                            @php
                            $halfCount = (count($formFields) / 2)+1;
                            @endphp

                            @if($errors->has('national_number'))
                            <div class="alert alert-danger">
                                {{ $errors->first('national_number') }}
                            </div>
                            @endif
                            @foreach($formFields as $index => $field)
                            @if($index < $halfCount) <div class="mb-3">
                                <x-label for="{{ $field['name'] }}" value="{{ __($field['label']) }}" />
                                @if($field['name'] === 'national_number')
                                <x-input id="{{ $field['name'] }}" class="block mt-1 w-full" type="{{ $field['type'] }}" name="{{ $field['name'] }}" :value="old(''.$field['name'])" required autofocus autocomplete="{{ $field['name'] }}" placeholder="{{ __($field['placeholder'] ?? '') }}" oninput="updateBirthDate()" />
                                @elseif($field['type'] === 'checkbox')
                                <x-input id="{{ $field['name'] }}" class="block mt-1" type="{{ $field['type'] }}" name="{{ $field['name'] }}" value="1" />
                                @elseif($field['isTextArea'])
                                <textarea id="{{ $field['name'] }}" class="block mt-1 w-full" type="{{ $field['type'] }}" name="{{ $field['name'] }}" :value="old(''.$field['name'])">{{old(''.$field['name'])}}</textarea>
                                @else
                                <x-input id="{{ $field['name'] }}" class="block mt-1 w-full" type="{{ $field['type'] }}" name="{{ $field['name'] }}" :value="old(''.$field['name'])" required autofocus autocomplete="{{ $field['name'] }}" placeholder="{{ __($field['placeholder'] ?? '') }}" />
                                @endif

                        </div>
                        @endif
                        @endforeach
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="bg-white p-4">
                        <!-- Additional field for parent's phone -->
                        @foreach($formFields as $index => $field)
                        @if($index >= $halfCount)
                        <div class="mb-3">
                            <x-label for="{{ $field['name'] }}" value="{{ __($field['label']) }}" />
                            @if($field['name'] === 'national_number')
                            <x-input id="{{ $field['name'] }}" class="block mt-1 w-full" type="{{ $field['type'] }}" name="{{ $field['name'] }}" :value="old(''.$field['name'])" required autofocus autocomplete="{{ $field['name'] }}" placeholder="{{ __($field['placeholder'] ?? '') }}" oninput="updateBirthDate()" />
                            @elseif($field['type'] === 'checkbox')
                            <x-input id="{{ $field['name'] }}" class="block mt-1" type="{{ $field['type'] }}" name="{{ $field['name'] }}" value="1" />
                            @elseif($field['isTextArea'])
                            <textarea id="{{ $field['name'] }}" class="block mt-1 w-full" type="{{ $field['type'] }}" name="{{ $field['name'] }}" :value="old(''.$field['name'], Auth::user()->email)">{{ old(''.$field['name']) }}</textarea>
                            @else
                            <x-input id="{{ $field['name'] }}" class="block mt-1 w-full" type="{{ $field['type'] }}" name="{{ $field['name'] }}" :value="old(''.$field['name'])" autofocus autocomplete="{{ $field['name'] }}" placeholder="{{ __($field['placeholder'] ?? '') }}" />
                            @endif
                        </div>
                        @endif
                        @endforeach
                        <button class="btn btn-outline-primary" type="submit">{{ __('Envoyer') }}</button>
                    </div>
                </div>
        </div>
        </form>
    </div>
    </div>
    <script>
        function updateBirthDate() {
            var nationalNumber = document.getElementById('national_number').value;
            if (nationalNumber.length >= 6) {
                var yearPrefix = (nationalNumber.substring(0, 1) === '0' || nationalNumber.substring(0, 1) === '1') ? '20' : '19';
                var year = nationalNumber.substring(0, 2);
                var month = nationalNumber.substring(2, 4);
                var day = nationalNumber.substring(4, 6);
                var birthDate = `${yearPrefix}${year}-${month}-${day}`;
                document.getElementById('birth_date').value = birthDate;
            }
        }
    </script>

</x-app-layout>