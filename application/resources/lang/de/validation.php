<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Das following language lines contain Das default error messages used by
    | Das validator class. Some of Dasse rules have multiple versions such
    | as Das size rules. Feel free to tweak each of Dasse messages here.
    |
    */

    'accepted'             => 'Das :attribute muss akzeptiert werden.',
    'active_url'           => 'Das :attribute ist keine gültige URL.',
    'after'                => 'Das :attribute muss ein Datum danach sein :date.',
    'after_or_equal'       => 'Das :attribute muss ein Datum nach oder gleich sein :date.',
    'alpha'                => 'Das :attribute darf nur Buchstaben enthalten.',
    'alpha_dash'           => 'Das :attribute darf nur Buchstaben, Zahlen und Bindestriche enthalten.',
    'alpha_num'            => 'Das :attribute darf nur Buchstaben und Zahlen enthalten.',
    'array'                => 'Das :attribute muss ein Array sein.',
    'before'               => 'Das :attribute muss ein Datum vorher sein :date.',
    'before_or_equal'      => 'Das :attribute muss ein Datum vor oder gleich sein :date.',
    'between'              => [
        'numeric' => 'Das :attribute muss dazwischen sein :min und :max.',
        'file'    => 'Das :attribute muss dazwischen sein :min und :max kilobytes.',
        'string'  => 'Das :attribute muss dazwischen sein :min und :max figuren.',
        'array'   => 'Das :attribute muss dazwischen sein :min and :max artikel.',
    ],
    'boolean'              => 'Das :attribute feld muss wahr oder falsch sein.',
    'confirmed'            => 'Das :attribute bestätigung stimmt nicht überein.',
    'date'                 => 'Das :attribute ist kein gültiges Datum.',
    'date_format'          => 'Das :attribute stimmt nicht mit dem Format überein :format.',
    'different'            => 'Das :attribute und :other muss anders sein.',
    'digits'               => 'Das :attribute muss sein :digits ziffern.',
    'digits_between'       => 'Das :attribute muss dazwischen sein :min und :max ziffern.',
    'dimensions'           => 'Das :attribute hat ungültige Bildmaße.',
    'distinct'             => 'Das :attribute feld hat einen doppelten Wert.',
    'email'                => 'Das :attribute muss eine gültige E-Mail-Adresse sein.',
    'exists'               => 'Das ausgewählt :attribute ist ungültig.',
    'file'                 => 'Das :attribute muss eine Datei sein.',
    'filled'               => 'Das :attribute feld muss einen Wert haben.',
    'image'                => 'Das :attribute muss ein Bild sein.',
    'in'                   => 'Das ausgewählt :attribute ist ungültig.',
    'in_array'             => 'Das :attribute feld existiert nicht in :other.',
    'integer'              => 'Das :attribute muss eine ganze Zahl sein.',
    'ip'                   => 'Das :attribute muss eine gültige IP-Adresse sein.',
    'ipv4'                 => 'Das :attribute muss eine gültige IPv4-Adresse sein.',
    'ipv6'                 => 'Das :attribute muss eine gültige IPv6-Adresse sein.',
    'json'                 => 'Das :attribute muss eine gültige JSON-Zeichenfolge sein.',
    'max'                  => [
        'numeric' => 'Das :attribute darf nicht größer sein als :max.',
        'file'    => 'Das :attribute darf nicht größer sein als :max kilobytes.',
        'string'  => 'Das :attribute darf nicht größer sein als :max figuren.',
        'array'   => 'Das :attribute darf nicht mehr als haben :max artikel.',
    ],
    'mimes'                => 'Das :attribute muss eine Datei vom Typ sein: :values.',
    'mimetypes'            => 'Das :attribute Muss eine Datei vom Typ sein: :values.',
    'min'                  => [
        'numeric' => 'Das :attribute muss mindestens :min.',
        'file'    => 'Das :attribute muss mindestens :min kilobytes.',
        'string'  => 'Das :attribute muss mindestens :min figuren.',
        'array'   => 'Das :attribute muss mindestens haben :min artikel.',
    ],
    'not_in'               => 'Das ausgewählt :attribute ist ungültig.',
    'not_regex'            => 'Das :attribute format ist ungültig.',
    'numeric'              => 'Das :attribute muss eine Nummer sein.',
    'present'              => 'Das :attribute feld muss vorhanden sein.',
    'regex'                => 'Das :attribute format ist ungültig.',
    'required'             => 'Das :attribute feld ist erforderlich.',
    'required_if'          => 'Das :attribute feld ist erforderlich, wenn :other ist :value.',
    'required_unless'      => 'Das :attribute feld ist erforderlich, es sei denn :other ist in :values.',
    'required_with'        => 'Das :attribute feld ist erforderlich, wenn :values ist anwesend.',
    'required_with_all'    => 'Das :attribute feld ist erforderlich, wenn :values ist anwesendist nicht hier.',
    'required_without'     => 'Das :attribute feld ist erforderlich, wenn :values ist nicht hier.',
    'required_without_all' => 'Das :attribute Feld ist erforderlich, wenn keiner von :values sind anwesend.',
    'same'                 => 'Das :attribute undmuss passen :other .',
    'size'                 => [
        'numeric' => 'Das :attribute muss sein :size.',
        'file'    => 'Das :attribute muss sein :size kilobytes.',
        'string'  => 'Das :attribute muss sein :size figuren.',
        'array'   => 'Das :attribute muss enthalten :size artikel.',
    ],
    'string'               => 'Das :attribute muss eine Zeichenfolge sein.',
    'timezone'             => 'Das :attribute muss eine gültige Zone sein.',
    'unique'               => 'Das :attribute wurde bereits genommen.',
    'uploaded'             => 'Das :attribute konnte nicht hochgeladen werden.',
    'url'                  => 'Das :attribute format ist ungültig.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using Das
    | convention "attribute.rule" to name Das lines. This makes it quick to
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
    | Das following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [
        'email' => 'email',
        'first_name' => 'vorname',
        'last_name' => 'familienname, nachname',
        'phone_number' => 'telefonnummer',
        'role_id' => 'rollen id',
        'password' => 'passwort',
        'password_confirmation' => 'passwort bestätigung',
        'photo_id' => 'bild',
        'title' => 'titel',
        'description' => 'beschreibung',
        'price' => 'preis',
        'category_id' => 'kategorie',
        'addon_id' => 'erweiterung',
        'booking_id' => 'Buchungs-ID',
        'type' => 'art',
        'duration' => 'dauer',
        'file' => 'datei',
    ],

];
