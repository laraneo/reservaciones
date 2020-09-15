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

    'accepted'             => 'la :attribute doit être accepté.',
    'active_url'           => 'la :attribute n\'est pas une URL valide.',
    'after'                => 'la :attribute doit être une date après :date.',
    'after_or_equal'       => 'la :attribute doit être une date après ou égala à :date.',
    'alpha'                => 'la :attribute peut seulement contenir des lettres.',
    'alpha_dash'           => 'la :attribute ne peut contenir que des lettres, des chiffres et des tirets.',
    'alpha_num'            => 'la :attribute ne peut contenir que des lettres et des chiffres.',
    'array'                => 'la :attributedoit être un array.',
    'before'               => 'la :attributedoit être une date avant :date.',
    'before_or_equal'      => 'la :attribute doit être une date avant ou égala à :date.',
    'between'              => [
        'numeric' => 'la :attribute doit être entre :min et :max.',
        'file'    => 'la :attribute doit être entre :min et :max kilobytes.',
        'string'  => 'la :attribute doit être entre :min et :max personnages.',
        'array'   => 'la :attribute doit avoir entre :min et :max article.',
    ],
    'boolean'              => 'la :attribute la champ doit être vrai ou faux.',
    'confirmed'            => 'la :attribute la confirmation ne correspond pas.',
    'date'                 => 'la :attribute n\'est pas une date valide.',
    'date_format'          => 'la :attribute ne correspond pas au format :format.',
    'different'            => 'la :attribute et :other doit être différent.',
    'digits'               => 'la :attribute doit être :digits chiffres.',
    'digits_between'       => 'la :attribute Doit être entre :min et :max chiffres.',
    'dimensions'           => 'la :attribute a des dimensions d\'image incorrectes.',
    'distinct'             => 'la :attribute champ a une valeur en double.',
    'email'                => 'la :attribute doit être une adresse e-mail valide.',
    'exists'               => 'la choisi :attribute est invalide.',
    'file'                 => 'la :attribute doit être un fichier.',
    'filled'               => 'la :attribute le champ doit avoir une valeur.',
    'image'                => 'la :attribute doit être une image.',
    'in'                   => 'la choisi :attribute est invalide.',
    'in_array'             => 'la :attribute champ n\'existe pas dans :other.',
    'integer'              => 'la :attribute doit être un entier.',
    'ip'                   => 'la :attribute doit être une adresse IP valide.',
    'ipv4'                 => 'la :attribute doit être une adresse IPv4 valide.',
    'ipv6'                 => 'la :attribute doit être une adresse IPv6 valide.',
    'json'                 => 'la :attribute doit être une JSON valide.',
    'max'                  => [
        'numeric' => 'la :attribute ne peut pas être supérieur à :max.',
        'file'    => 'la :attribute ne peut pas être supérieur à :max kilobytes.',
        'string'  => 'la :attribute ne peut pas être supérieur à :max personnages.',
        'array'   => 'la :attribute ne peut pas avoir plus de :max articles.',
    ],
    'mimes'                => 'la :attribute doit être une fila de type: :values.',
    'mimetypes'            => 'la :attribute doit être une fila de type: :values.',
    'min'                  => [
        'numeric' => 'la :attribute doit être au moins :min.',
        'file'    => 'la :attribute doit être au moins :min kilobytes.',
        'string'  => 'la :attribute doit être au moins :min personnages.',
        'array'   => 'la :attribute ne peut pas avoir plus de :min articles.',
    ],
    'not_in'               => 'la choisi :attribute est invalide.',
    'not_regex'            => 'la :attribute le format est invalide.',
    'numeric'              => 'la :attribute doit être un nombre.',
    'present'              => 'la :attribute le champ doit être présent.',
    'regex'                => 'la :attribute le format est invalide.',
    'required'             => 'la :attribute champ requis.',
    'required_if'          => 'la :attribute le champ est requis quand :other est :value.',
    'required_unless'      => 'la :attribute champ est requis à moins :other est dans :values.',
    'required_with'        => 'la :attribute champ est requis lorsque :values est présent.',
    'required_with_all'    => 'la :attribute champ est requis lorsque :values est présent.',
    'required_without'     => 'la :attribute champ est requis lorsque :values n\'est pas présent.',
    'required_without_all' => 'la :attribute ce champ est requis lorsqu\'aucune :values n\'est présente.',
    'same'                 => 'la :attribute est :other doit correspondre.',
    'size'                 => [
        'numeric' => 'la :attribute doit être :size.',
        'file'    => 'la :attribute doit être :size kilobytes.',
        'string'  => 'la :attribute doit être :size personnages.',
        'array'   => 'la :attribute doit contenir :size articles.',
    ],
    'string'               => 'la :attribute doit être une chaîne.',
    'timezone'             => 'la :attribute doit être une zone valide.',
    'unique'               => 'la :attribute a déjà été pris.',
    'uploaded'             => 'la :attribute n\'a pas réussi à télécharger.',
    'url'                  => 'la :attribute le format est invalide.',

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
    | la following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [

        'email' => 'email',
        'first_name' => 'prénom',
        'last_name' => 'nom de famille',
        'phone_number' => 'numéro de téléphone',
        'role_id' => 'identifiant de rôle',
        'password' => 'mot de passe',
        'password_confirmation' => 'confirmation mot de passe',
        'photo_id' => 'photo',
        'title' => 'titre',
        'description' => 'la description',
        'price' => 'prix',
        'category_id' => 'catégorie',
        'addon_id' => 'Ajouter',
        'booking_id' => 'numéro de réservation',
        'type' => 'type',
        'duration' => 'durée',
        'file' => 'fichier',

    ],

];
