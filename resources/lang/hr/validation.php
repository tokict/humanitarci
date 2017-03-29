<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */
    'without_spaces' => ':attribute ne smije sadržavati razmake',
    'accepted'             => ':attribute mora biti prihvaćen.',
    'active_url'           => ':attribute nije ispravan URL.',
    'after'                => ':attribute mora biti nakon :date.',
    'alpha'                => ':attribute može sadržavati isključivo slova.',
    'alpha_dash'           => ':attribute može sadržavati isključivo slova, brojke, i minuse.',
    'alpha_num'            => ':attribute može sadržavati isključivo slova i brojke.',
    'array'                => ':attribute mmora biti arraz.',
    'before'               => ':attribute mora biti prije :date.',
    'between'              => [
        'numeric' => ':attribute mora biti između :min i :max.',
        'file'    => ':attribute mora biti između :min i :max kilobajta.',
        'string'  => ':attribute mora biti između :min i :max znakova.',
        'array'   => ':attribute je morao biti između :min i :max stavki.',
    ],
    'boolean'              => ':attribute mora biti da ili ne.',
    'confirmed'            => 'Potvrda nije točna.',
    'date'                 => ':attribute nije važeći datum.',
    'date_format'          => ':attribute ne odgovara formatu :format.',
    'different'            => ':attribute i :other moraju biti različiti.',
    'digits'               => ':attribute mora biti :digits brojka.',
    'digits_between'       => ':attribute mora biti između :min i :max znakova.',
    'distinct'             => ':attribute polje je duplicirano.',
    'email'                => ':attribute mora biti važeća email adresa.',
    'exists'               => 'odabrani/a :attribute je nevažeći.',
    'filled'               => ':attribute je obavezan.',
    'image'                => ':attribute mora biti slika.',
    'in'                   => 'odabrani/a :attribute je nevažeći.',
    'in_array'             => ':attribute field does not exist in :other.',
    'integer'              => ':attribute must be an integer.',
    'ip'                   => ':attribute must be a valid IP address.',
    'json'                 => ':attribute must be a valid JSON string.',
    'max'                  => [
        'numeric' => ':attribute ne smije biti veći od :max.',
        'file'    => ':attribute ne smije imati više od  :max kilobajta.',
        'string'  => ':attribute ne smije imati viđe od :max znakova.',
        'array'   => ':attribute ne smije imati više od :max stavki.',
    ],
    'mimes'                => ':attribute mora biti zapis tipa: :values.',
    'min'                  => [
        'numeric' => ':attribute mora biti najmanje :min.',
        'file'    => ':attribute mora imati najmanje :min kilobajta.',
        'string'  => ':attribute mora imati najmanje :min znakova.',
        'array'   => ':attribute mora imati najmanje :min stavki.',
    ],
    'not_in'               => 'odabrani/a :attribute je nevažeći.',
    'numeric'              => ':attribute mora biti brojka.',
    'present'              => ':attribute mora biti prisutan.',
    'regex'                => ':attribute format je nevažeći.',
    'required'             => 'Polje :attribute je obavezno.',
    'required_if'          => 'Polje :attribute je obavezno kada :other je :value.',
    'required_unless'      => 'Polje :attribute je obavezno osim kada :other je neki od :values.',
    'required_with'        => 'Polje :attribute je obavezno kada :values je prisutno.',
    'required_with_all'    => 'Polje :attribute je obavezno kada  :values je prisutno.',
    'required_without'     => 'Polje :attribute je obavezno :values nije prisutno.',
    'required_without_all' => 'Polje :attribute je obavezno kada nema nijednog nijedan od :values.',
    'same'                 => 'Polje :attribute i :other moraju biti identični.',
    'size'                 => [
        'numeric' => ':attribute mora biti :size.',
        'file'    => ':attribute mora biti :size kilobytes.',
        'string'  => ':attribute mora biti :size characters.',
        'array'   => ':attribute mora sadržavati :size items.',
    ],
    'string'               => ':attribute mora biti riječ.',
    'timezone'             => ':attribute mora biti ispravna zona.',
    'unique'               => ':attribute je zauzeto.',
    'url'                  => ':attribute format je nevažeći.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],

];
