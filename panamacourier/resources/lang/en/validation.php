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
    'accepted'             => 'You have to accept this.',                                             /*TRADUCIDO*/
    'active_url'           => 'The URL is invalid.',                               /*TRADUCIDO*/
    'after'                => 'Enter a date after typing in the From field.',                         /*TRADUCIDO*/
      'alpha'              => 'This field should contain only letters',                           /*TRADUCIDO*/
    'alpha_dash'           => 'This field can only contain letters, numbers and dashes',       /*TRADUCIDO*/
    'alpha_num'            => 'This field can only contain letters and numbers',                /*TRADUCIDO*/
    'array'                => 'This field requires array type format, example [a, b, c]',      /*TRADUCIDO*/
    'before'               => 'Please indicate an earlier date: date',                               /*TRADUCIDO*/
    'between'              => [
        'numeric' => 'The value must be between :min y :max.',                                  /*TRADUCIDO*/
        'file'    => 'The weight of the file must be between :min y :max kilobytes.',             /*TRADUCIDO*/
        'string'  => 'This field accept betwen :min y :max characters.',                         /*TRADUCIDO*/
        'array'   => 'This field accept betwen :min y :max items.',                                 /*TRADUCIDO*/
    ],
    'boolean'              => 'This field only supports true and false',                       /*TRADUCIDO*/
    'confirmed'            => 'Passwords do not match.',                                  /*TRADUCIDO*/
    'date'                 => 'Please indicate a valid date',                                        /*TRADUCIDO*/
    'date_format'          => 'The content entered in this field does not match the following format :format.',  /*TRADUCIDO*/
    'different'            => 'The value indicated and the value :other must be different',          /*TRADUCIDO*/
    'digits'               => 'This field must be between :digits digitos.',                      /*TRADUCIDO*/
    'digits_between'       => 'This field must be between :min y :max digitos.',            /*TRADUCIDO*/
    'dimensions'           => 'the content haven\'t valid dimensions',             /*TRADUCIDO*/
    'distinct'             => 'This field contains duplicated values',                              /*TRADUCIDO*/
    'email'                => 'Please provide a valid email address.',                   /*TRADUCIDO*/
    'exists'               => 'No match was found for the indicated data',                  /*TRADUCIDO*/
    'filled'               => 'This field is required.',                                       /*TRADUCIDO*/
    'image'                => 'Only images allowed',                                       /*TRADUCIDO*/
    'in'                   => 'The selection you have made is not valid',               /*TRADUCIDO*/
    'in_array'             => 'The information does not exist in :other.',                            /*TRADUCIDO*/
    'integer'              => 'Please provide an integer value.',                                  /*TRADUCIDO*/
    'ip'                   => 'Please provide a valid IP address',                           /*TRADUCIDO*/
    'json'                 => 'You must indicate your information in a valid JSON format',         /*TRADUCIDO*/
    'max'                  => [
        'numeric' => 'The value can\'t be greater than :max.',                                   /*TRADUCIDO*/
        'file'    => 'File size can not exceed :max kilobytes.',               /*TRADUCIDO*/
        'string'  => 'The field admits a maximum of :max characters.',                           /*TRADUCIDO*/
        'array'   => 'A maximum of :max items.',                                 /*TRADUCIDO*/
    ],
    'mimes'                => 'The file must have a format type :values.',              /*TRADUCIDO*/
    'min'                  => [
        'numeric' => 'It is required at least :min.',                                          /*TRADUCIDO*/
        'file'    => 'It is required at least :min kilobytes.',                                /*TRADUCIDO*/
        'string'  => 'It is required at least :min characters.',                      /*TRADUCIDO*/
        'array'   => 'It is required at least :min items.',                                        /*TRADUCIDO*/
    ],
    'not_in'               => 'Your selection is invalid',                                       /*TRADUCIDO*/
    'numeric'              => 'You must provide a number',                                         /*TRADUCIDO*/
    'present'              => 'Please, pay atention to this field ',                                /*TRADUCIDO*/
    'regex'                => 'The format indicated is invalid',                                /*TRADUCIDO*/
    'required'             => 'This field is required.',                                       /*TRADUCIDO*/
    'required_if'          => 'This field is required when :other is :value.',               /*TRADUCIDO*/
    'required_unless'      => 'This field is required, a menos que :other sea :values.',       /*TRADUCIDO*/
    'required_with'        => 'This field is required when :values is indicated',            /*TRADUCIDO*/
    'required_with_all'    => 'This field is required when :values is indicated',            /*TRADUCIDO*/
    'required_without'     => 'This field is required when :values isn\'t indicated',         /*TRADUCIDO*/
    'required_without_all' => 'This field is required when not indicated :values',       /*TRADUCIDO*/
    'same'                 => 'Este campo y :other must match',                            /*TRADUCIDO*/
    'size'                 => [
        'numeric' => 'Must have a size :size.',                                             /*TRADUCIDO*/
        'file'    => 'File size can not exceed :size kilobytes.',                        /*TRADUCIDO*/
        'string'  => 'The field admits a maximum of :size characters.',                 /*TRADUCIDO*/
        'array'   => 'A maximum of :size items.',                                           /*TRADUCIDO*/
    ],
    'string'               => 'You must enter a string',                  /*TRADUCIDO*/
    'timezone'             => 'The indicated area is not valid',                                  /*TRADUCIDO*/
    'unique'               => 'A record already exists for this data',                      /*TRADUCIDO*/
    'url'                  => 'You have entered an invalid format',                                /*TRADUCIDO*/
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
