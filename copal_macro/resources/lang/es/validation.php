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
    'accepted'             => 'Debe aceptar esto.',                                             /*TRADUCIDO*/
    'active_url'           => 'Esta dirección URL no es valida.',                               /*TRADUCIDO*/
    'after'                => 'Indique una fecha posterior a la tipeada en el campo Desde.',                         /*TRADUCIDO*/
    'alpha'                => 'Este campo debe contener solo letras',                           /*TRADUCIDO*/
    'alpha_dash'           => 'Este campo solo puede contener letras, números y guiones',       /*TRADUCIDO*/
    'alpha_num'            => 'Este campo solo puede contener letras y números',                /*TRADUCIDO*/
    'array'                => 'Este campo requiere formato tipo arreglo, ejemplo [a,b,c]',      /*TRADUCIDO*/
    'before'               => 'Indique una fecha anterior :date',                               /*TRADUCIDO*/
    'between'              => [
        'numeric' => 'El valor debe estar entre :min y :max.',                                  /*TRADUCIDO*/
        'file'    => 'El peso del archivo debe estar entre :min y :max kilobytes.',             /*TRADUCIDO*/
        'string'  => 'Este campo admite entre :min y :max caracteres.',                         /*TRADUCIDO*/
        'array'   => 'Esta permitido entre :min y :max items.',                                 /*TRADUCIDO*/
    ],
    'boolean'              => 'Este campo solo admite verdadero y falso',                       /*TRADUCIDO*/
    'confirmed'            => 'Las contraseñas no coinciden.',                                  /*TRADUCIDO*/
    'date'                 => 'Indique un fecha valida',                                        /*TRADUCIDO*/
    'date_format'          => 'El contenido introducido en este campo no coincide con el siguiente formato :format.',  /*TRADUCIDO*/
    'different'            => 'El valor indicado y el de :other deben ser diferentes',          /*TRADUCIDO*/
    'digits'               => 'Este campo debe contener :digits digitos.',                      /*TRADUCIDO*/
    'digits_between'       => 'Este campo debe contener entre :min y :max digitos.',            /*TRADUCIDO*/
    'dimensions'           => 'El contenido indicado no posee dimensiones validas',             /*TRADUCIDO*/
    'distinct'             => 'El campo posee valores duplicados',                              /*TRADUCIDO*/
    'email'                => 'Debe indicar una direccion de correo valida.',                   /*TRADUCIDO*/
    'exists'               => 'No se encontro coincidencia para el dato indicado',                  /*TRADUCIDO*/
    'filled'               => 'Este campo es requerido.',                                       /*TRADUCIDO*/
    'image'                => 'Solo se admiten imagenes',                                       /*TRADUCIDO*/
    'in'                   => 'La selección que usted ha realizado no es valida',               /*TRADUCIDO*/
    'in_array'             => 'La informacion no existe en :other.',                            /*TRADUCIDO*/
    'integer'              => 'Debe indicar un valor entero.',                                  /*TRADUCIDO*/
    'ip'                   => 'Debe indicar una direccion IP valida',                           /*TRADUCIDO*/
    'json'                 => 'Debe indicar su informacion con un formato JSON valido',         /*TRADUCIDO*/
    'max'                  => [
        'numeric' => 'El valor no puede ser mayor que :max.',                                   /*TRADUCIDO*/
        'file'    => 'El tamaño del archivo no puede exceder de :max kilobytes.',               /*TRADUCIDO*/
        'string'  => 'El campo admite un maximo de :max caracteres.',                           /*TRADUCIDO*/
        'array'   => 'Esta permitido un maximo de :max items.',                                 /*TRADUCIDO*/
    ],
    'mimes'                => 'El archivo debe tener un formato de typo :values.',              /*TRADUCIDO*/
    'min'                  => [
        'numeric' => 'Se requiere por lo menos :min.',                                          /*TRADUCIDO*/
        'file'    => 'Se admiten por los menos :min kilobytes.',                                /*TRADUCIDO*/
        'string'  => 'Este campo debe contener al menos :min caracteres.',                      /*TRADUCIDO*/
        'array'   => 'Debe indcar al menos :min items.',                                        /*TRADUCIDO*/
    ],
    'not_in'               => 'Su seleccion es invalida',                                       /*TRADUCIDO*/
    'numeric'              => 'Debe indicar un numero',                                         /*TRADUCIDO*/
    'present'              => 'Debe tomar en cuenta este campo',                                /*TRADUCIDO*/
    'regex'                => 'El formato indicado es invalido',                                /*TRADUCIDO*/
    'required'             => 'Este campo es requerido.',                                       /*TRADUCIDO*/
    'required_if'          => 'Este campo es requerido cuando :other es :value.',               /*TRADUCIDO*/
    'required_unless'      => 'Este campo es requerido, a menos que :other sea :values.',       /*TRADUCIDO*/
    'required_with'        => 'Este campo es requerido cuando :values sea indicado',            /*TRADUCIDO*/
    'required_with_all'    => 'Este campo es requerido cuando :values sea indicado',            /*TRADUCIDO*/
    'required_without'     => 'Este campo es requerido cuando :values no sea indicado',         /*TRADUCIDO*/
    'required_without_all' => 'este campo es requerido cuando no sean indicados :values',       /*TRADUCIDO*/
    'same'                 => 'Este campo y :other deben coincidir',                            /*TRADUCIDO*/
    'size'                 => [
        'numeric' => 'Debe tener un tamaño :size.',                                             /*TRADUCIDO*/
        'file'    => 'El archivo debe tener tamaño de :size kilobytes.',                        /*TRADUCIDO*/
        'string'  => 'La informaion debe tener un tamaño de :size caracteres.',                 /*TRADUCIDO*/
        'array'   => 'Se deben indicar :size items.',                                           /*TRADUCIDO*/
    ],
    'string'               => 'Debe indicar un string (cadena de caracteres)',                  /*TRADUCIDO*/
    'timezone'             => 'La zona indicada no es valida',                                  /*TRADUCIDO*/
    'unique'               => 'Ya existe un registro para este dato',                      /*TRADUCIDO*/
    'url'                  => 'Ha indicado un formato invalido',                                /*TRADUCIDO*/
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
