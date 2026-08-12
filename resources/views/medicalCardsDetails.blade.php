<x-app-layout>
    <div class="postition-relative">
        <div class="container mt-5 position-absolute bg-white" id="consult">
            @foreach ($data as $row)
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="pb-3">Fiche médicale <strong> {{ $row->last_name . ' ' . $row->first_name }}</strong>
                </h3>
                <form method="POST" action="{{ route('generate-pdf') }}" class="ms-auto">

                    <input type="text" name="national_number" value="{{ $row->national_number }}" hidden>
                    @csrf
                    <button type="submit" class="btn" style="background: none; border: none;"
                        title="Télécharger en PDF">
                        <img src="{{ asset('images/down.png') }}" alt="Générer PDF" style="height: 40px;">
                    </button>
                </form>
                @if (Auth::user()->role == 'Parent')
                <x-button class="edit">Modifier</x-button>
                <div class="editMode" id="editActions">
                    <x-button>Annuler</x-button>
                </div>
                @endif
            </div>
            <x-validation-errors class="mb-4" />
            <ul class="list-group list-group-flush edit">
                @foreach ($fields as $field)
                <li class="list-group-item">
                    <strong>{{ $field['label'] }} : </strong>
                    @if(isset($row->{$field['name']}))
                        @if ($row->{$field['name']} == 0)
                        non
                        @elseif ($row->{$field['name']} == 1)
                        oui
                        @else
                        {{ $row->{$field['name']} }}
                        @endif
                    @else
                        Non specifie
                    @endif
                </li>
                @endforeach
                <li class="list-group-item d-flex justify-content-between">
                    <span class="groupName">
                        <strong>Nom du Groupe: </strong>
                        @if ($parent_infos[0]->group)
                            {{ $parent_infos[0]->group }}
                        @else
                            Aucun groupe assigné
                        @endif
                    </span>
                    @if (Auth::user()->role == 'Animator')
                    <div class="editGroupMode" hidden>
                        <form action="{{ route('add_group') }}" method="post" class="editGroupForm">
                            @csrf
                            <input type="hidden" name="national_number" value="{{ $row->national_number }}">
                            <input type="hidden" name="originalName" value="{{ $parent_infos[0]->group }}">
                            <select name="newName">
                                @foreach ($groups as $group)
                                    <option value="{{ $group->name }}">{{ $group->name }}</option>
                                @endforeach
                            </select>
                            <x-button type="button" class="save">Sauvegarder</x-button>
                            <x-button type="button" class="cancel">Annuler</x-button>
                        </form>
                    </div>
                    <div class="editGroup">
                            <input type="hidden" name="originalName" value="{{ $parent_infos[0]->group }}">
                            <x-button type="button" class="editBtn">Modifier le groupe</x-button>
                    </div>
                    @endif
                </li>
            </ul>
            <ul class="list-group list-group-flush editMode">
                <form action="{{ route('edit_record') }}" method="post" id="editRecordForm">
                        @csrf
                        @foreach ($fields as $field)
                            <x-label for="{{ $field['name'] }}" value="{{ __($field['label']) }}" />
                            @if ($field['name'] === 'national_number')
                            <x-input id="{{ $field['name'] }}" class="block mt-1 w-full"
                                    type="{{ $field['type'] }}" name="{{ $field['name'] }}"
                                    autofocus autocomplete="{{ $field['name'] }}"
                                    placeholder="{{ __($field['placeholder'] ?? '') }}"
                                    value="{{ $row->{$field['name']} }}" readonly/>
                            
                            @elseif ($field['type'] === 'checkbox')
                                <x-input name="{{ $field['name'] }}" type="hidden" value="0"/>
                                @if (isset($row->{$field['name']}) && $row->{$field['name']})
                                    <x-input id="{{ $field['name'] }}" class="block mt-1" type="{{ $field['type'] }}"
                                        name="{{ $field['name'] }}" checked value="1" />
                                @else
                                    <x-input id="{{ $field['name'] }}" class="block mt-1" type="{{ $field['type'] }}"
                                        name="{{ $field['name'] }}" value="1" />
                                @endif
                            @elseif($field['isTextArea'])
                                <textarea id="{{ $field['name'] }}" class="block mt-1 w-full" type="{{ $field['type'] }}" name="{{ $field['name'] }}"
                                    :value="old(''.$field['name'])">{{ isset($row->{$field['name']}) ? $row->{$field['name']} : '' }}</textarea>
                            @elseif(isset($row->{$field['name']}))
                                <x-input id="{{ $field['name'] }}" class="block mt-1 w-full"
                                    type="{{ $field['type'] }}" name="{{ $field['name'] }}" :value="old('' . $field['name'])"
                                    autofocus autocomplete="{{ $field['name'] }}"
                                    placeholder="{{ __($field['placeholder'] ?? '') }}"
                                    value="{{ $row->{$field['name']} }}" 
                                    />
                            @else
                            <x-input id="{{ $field['name'] }}" class="block mt-1 w-full"
                                    type="{{ $field['type'] }}" name="{{ $field['name'] }}" :value="old('' . $field['name'])"
                                    autofocus autocomplete="{{ $field['name'] }}"
                                    placeholder="{{ __($field['placeholder'] ?? '') }}"
                                    />
                            @endif
                        @endforeach
                        <x-button type="submit" id="editSubmit">Sauvegarder</x-button>
                    </form>
                </ul>
            @endforeach
            
        </div>

    </div>

    <style>
        .editMode {
            display: none;
        }
    </style>

    <script>
        $(document).ready(() => {
            $('#editSubmit').appendTo('#editActions')
            $("button.edit").on('click', () => {
                $('.edit').toggle()
                $('.editMode').toggle()
                console.log("EditMode entered");
            })
            $(".editMode button").on('click', () => {
                $('.edit').toggle()
                $('.editMode').toggle()
                console.log("EditMode exited");
            })

            $('#editSubmit').on('click', () => {
                $('#editRecordForm').submit()
            })
            $(".editBtn").on('click', function () {
            const listItem = $(this).closest('li');
            listItem.find('.groupName').hide();
            listItem.find('.editGroupMode').removeAttr('hidden');
            listItem.find('.editGroup').attr('hidden', 'hidden');
        });

        $(".cancel").on('click', function () {
            const listItem = $(this).closest('li');
            listItem.find('.groupName').show();
            listItem.find('.editGroupMode').attr('hidden', 'hidden');
            listItem.find('.editGroup').removeAttr('hidden');
        });

        $(".save").on('click', function () {
            const form = $(this).closest('form');
            form.submit();
        });
        })
    </script>
</x-app-layout>