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

    'accepted'             => 'Il :attribute deve essere accettato.',
    'active_url'           => 'Il :attribute non è un URL valido.',
    'after'                => 'Il :attribute deve essere una data dopo :date.',
    'after_or_equal'       => 'Il :attribute deve essere una data successiva o uguale a :date.',
    'alpha'                => 'Il :attribute può contenere solo lettere.',
    'alpha_dash'           => 'Il :attribute può contenere solo lettere, numeri e trattini.',
    'alpha_num'            => 'Il :attribute può contenere solo lettere e numeri.',
    'array'                => 'Il :attribute deve essere una matrice.',
    'before'               => 'Il :attribute deve essere una data prima :date.',
    'before_or_equal'      => 'Il :attribute deve essere una data prima o uguale a :date.',
    'between'              => [
        'numeric' => 'Il :attribute deve essere tra :min e :max.',
        'file'    => 'Il :attribute deve essere tra :min e :max kilobytes.',
        'string'  => 'Il :attribute deve essere tra :min e :max personaggi.',
        'array'   => 'Il :attribute deve avere tra :min e :max elementi.',
    ],
    'boolean'              => 'Il :attribute campo deve essere vero o falso.',
    'confirmed'            => 'Il :attribute la conferma non corrisponde.',
    'date'                 => 'Il :attribute non è una data valida.',
    'date_format'          => 'Il :attribute non corrisponde al formato :format.',
    'different'            => 'Il :attribute e :other deve essere diverso.',
    'digits'               => 'Il :attribute deve essere :digits cifre.',
    'digits_between'       => 'Il :attribute deve essere tra :min e :max cifre.',
    'dimensions'           => 'Il :attribute ha dimensioni di immagine non valide.',
    'distinct'             => 'Il :attribute campo ha un valore doppio.',
    'email'                => 'Il :attribute deve essere un indirizzo email valido.',
    'exists'               => 'Il selezionato :attribute è invalido.',
    'file'                 => 'Il :attribute deve essere un file.',
    'filled'               => 'Il :attribute campo deve avere un valore.',
    'image'                => 'Il :attribute deve essere un\'immagine.',
    'in'                   => 'Il selezionato :attribute è invalido.',
    'in_array'             => 'Il :attribute campo non esiste in :other.',
    'integer'              => 'Il :attribute deve essere un numero intero.',
    'ip'                   => 'Il :attribute deve essere un indirizzo IP valido.',
    'ipv4'                 => 'Il :attribute deve essere un indirizzo IPv4 valido.',
    'ipv6'                 => 'Il :attribute deve essere un indirizzo IPv6 valido.',
    'json'                 => 'Il :attribute deve essere una stringa JSON valida.',
    'max'                  => [
        'numeric' => 'Il :attribute non può essere maggiore di :max.',
        'file'    => 'Il :attribute non può essere maggiore di :max kilobytes.',
        'string'  => 'Il :attribute non può essere maggiore di :max personaggi.',
        'array'   => 'Il :attribute potrebbe non avere più di :max elementi.',
    ],
    'mimes'                => 'Il :attribute deve essere un file di tipo: :values.',
    'mimetypes'            => 'Il :attribute deve essere un file di tipo: :values.',
    'min'                  => [
        'numeric' => 'Il :attribute deve essere almeno :min.',
        'file'    => 'Il :attribute deve essere almeno :min kilobytes.',
        'string'  => 'Il :attribute deve essere almeno :min personaggi.',
        'array'   => 'Il :attribute deve avere almeno :min elemento.',
    ],
    'not_in'               => 'Il selezionato :attribute è invalido.',
    'not_regex'            => 'Il :attribute formato non è valido.',
    'numeric'              => 'Il :attribute deve essere un numero.',
    'present'              => 'Il :attribute campo deve essere presente.',
    'regex'                => 'Il :attribute formato non è valido.',
    'required'             => 'Il :attribute campo è obbligatiorio.',
    'required_if'          => 'Il :attribute campo è richiesto quando :other è :value.',
    'required_unless'      => 'Il :attribute campo è richiesto a meno che :other è in :values.',
    'required_with'        => 'Il :attribute campo è richiesto quando :values è presente.',
    'required_with_all'    => 'Il :attribute campo è richiesto quando :values è presente.',
    'required_without'     => 'Il :attribute campo è richiesto quando :values non è presente.',
    'required_without_all' => 'Il :attribute campo è richiesto quando nessuno di :values sono presenti.',
    'same'                 => 'Il :attribute e :other deve combaciare.',
    'size'                 => [
        'numeric' => 'Il :attribute deve essere :size.',
        'file'    => 'Il :attribute deve essere :size kilobytes.',
        'string'  => 'Il :attribute deve essere :size personaggi.',
        'array'   => 'Il :attribute deve contenere :size elemente.',
    ],
    'string'               => 'Il :attribute deve essere una stringa.',
    'timezone'             => 'Il :attribute deve essere una zona valida.',
    'unique'               => 'Il :attribute è già stato preso.',
    'uploaded'             => 'Il :attribute non è riuscito a caricare.',
    'url'                  => 'Il :attribute formato non è valido.',

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

    'attributes' => [
        'email' => 'e-mail',
        'first_name' => 'nome di battesimo',
        'last_name' => 'cognome',
        'phone_number' => 'numero di telefono',
        'role_id' => 'ruolo id',
        'password' => 'password',
        'password_confirmation' => 'conferma password',
        'photo_id' => 'foto',
        'title' => 'titolo',
        'description' => 'descrizione',
        'price' => 'prezzo',
        'category_id' => 'categoria',
        'addon_id' => 'aggiungi su',
        'booking_id' => 'ID di prenotazione',
        'type' => 'genere',
        'duration' => 'durata',
        'file' => 'file',
    ],

];
