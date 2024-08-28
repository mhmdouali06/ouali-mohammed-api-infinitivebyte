<?php

return [
    'accepted'             => 'يجب قبول :attribute.',
    'active_url'           => ':attribute ليس عنوان URL صحيح.',
    'after'                => 'يجب أن يكون :attribute تاريخًا بعد :date.',
    'after_or_equal'       => 'يجب أن يكون :attribute تاريخًا بعد أو يساوي :date.',
    'alpha'                => ':attribute يجب أن يحتوي فقط على حروف.',
    'alpha_dash'           => ':attribute يمكن أن يحتوي فقط على أحرف، أرقام، شرطات وتسطير.',
    'alpha_num'            => ':attribute يمكن أن يحتوي فقط على أحرف وأرقام.',
    'array'                => ':attribute يجب أن يكون مصفوفة.',
    'before'               => 'يجب أن يكون :attribute تاريخًا قبل :date.',
    'before_or_equal'      => 'يجب أن يكون :attribute تاريخًا قبل أو يساوي :date.',
    'between'              => [
        'numeric' => 'يجب أن يكون :attribute بين :min و :max.',
        'file'    => 'يجب أن يكون :attribute بين :min و :max كيلوبايت.',
        'string'  => 'يجب أن يكون :attribute بين :min و :max أحرف.',
        'array'   => 'يجب أن تحتوي :attribute على بين :min و :max عناصر.',
    ],
    'boolean'              => 'حقل :attribute يجب أن يكون صحيحًا أو خطأ.',
    'confirmed'            => 'تأكيد :attribute غير متطابق.',
    'date'                 => ':attribute ليس تاريخًا صحيحًا.',
    'date_equals'          => 'يجب أن يكون :attribute تاريخًا يساوي :date.',
    'date_format'          => ':attribute لا يتطابق مع التنسيق :format.',
    'different'            => 'يجب أن يكون :attribute و :other مختلفين.',
    'digits'               => 'يجب أن يكون :attribute :digits أرقام.',
    'digits_between'       => 'يجب أن يكون :attribute بين :min و :max أرقام.',
    'dimensions'           => ':attribute يحتوي على أبعاد صورة غير صالحة.',
    'distinct'             => 'حقل :attribute يحتوي على قيمة مكررة.',
    'email'                => 'يجب أن يكون :attribute عنوان بريد إلكتروني صحيح.',
    'ends_with'            => 'يجب أن ينتهي :attribute بإحدى القيم التالية : :values.',
    'exists'               => ':attribute المختار غير صحيح.',
    'file'                 => 'يجب أن يكون :attribute ملفًا.',
    'filled'               => 'يجب أن يحتوي حقل :attribute على قيمة.',
    'gt'                   => [
        'numeric' => 'يجب أن يكون :attribute أكبر من :value.',
        'file'    => 'يجب أن يكون :attribute أكبر من :value كيلوبايت.',
        'string'  => 'يجب أن يكون :attribute أكبر من :value أحرف.',
        'array'   => 'يجب أن يحتوي :attribute على أكثر من :value عناصر.',
    ],
    'gte'                  => [
        'numeric' => 'يجب أن يكون :attribute أكبر من أو يساوي :value.',
        'file'    => 'يجب أن يكون :attribute أكبر من أو يساوي :value كيلوبايت.',
        'string'  => 'يجب أن يكون :attribute أكبر من أو يساوي :value أحرف.',
        'array'   => 'يجب أن يحتوي :attribute على :value عناصر أو أكثر.',
    ],
    'image'                => 'يجب أن يكون :attribute صورة.',
    'in'                   => ':attribute المختار غير صحيح.',
    'in_array'             => 'حقل :attribute غير موجود في :other.',
    'integer'              => 'يجب أن يكون :attribute عدد صحيح.',
    'ip'                   => 'يجب أن يكون :attribute عنوان IP صحيح.',
    'ipv4'                 => 'يجب أن يكون :attribute عنوان IPv4 صحيح.',
    'ipv6'                 => 'يجب أن يكون :attribute عنوان IPv6 صحيح.',
    'json'                 => 'يجب أن يكون :attribute سلسلة JSON صحيحة.',
    'lt'                   => [
        'numeric' => 'يجب أن يكون :attribute أقل من :value.',
        'file'    => 'يجب أن يكون :attribute أقل من :value كيلوبايت.',
        'string'  => 'يجب أن يكون :attribute أقل من :value أحرف.',
        'array'   => 'يجب أن يحتوي :attribute على أقل من :value عناصر.',
    ],
    'lte'                  => [
        'numeric' => 'يجب أن يكون :attribute أقل من أو يساوي :value.',
        'file'    => 'يجب أن يكون :attribute أقل من أو يساوي :value كيلوبايت.',
        'string'  => 'يجب أن يكون :attribute أقل من أو يساوي :value أحرف.',
        'array'   => 'يجب أن يحتوي :attribute على :value عناصر أو أقل.',
    ],
    'max'                  => [
        'numeric' => 'يجب ألا يكون :attribute أكبر من :max.',
        'file'    => 'يجب ألا يكون :attribute أكبر من :max كيلوبايت.',
        'string'  => 'يجب ألا يكون :attribute أكبر من :max أحرف.',
        'array'   => 'يجب ألا يحتوي :attribute على أكثر من :max عناصر.',
    ],
    'mimes'                => 'يجب أن يكون :attribute ملفًا من نوع : :values.',
    'mimetypes'            => 'يجب أن يكون :attribute ملفًا من نوع : :values.',
    'min'                  => [
        'numeric' => 'يجب أن يكون :attribute على الأقل :min.',
        'file'    => 'يجب أن يكون :attribute على الأقل :min كيلوبايت.',
        'string'  => 'يجب أن يكون :attribute على الأقل :min أحرف.',
        'array'   => 'يجب أن يحتوي :attribute على الأقل على :min عناصر.',
    ],
    'not_in'               => ':attribute المختار غير صحيح.',
    'not_regex'            => 'تنسيق :attribute غير صحيح.',
    'numeric'              => 'يجب أن يكون :attribute عدد.',
    'password'             => 'كلمة المرور غير صحيحة.',
    'present'              => 'يجب أن يكون حقل :attribute موجودًا.',
    'regex'                => 'تنسيق :attribute غير صحيح.',
    'required'             => 'حقل :attribute مطلوب.',
    'required_if'          => 'حقل :attribute مطلوب عندما يكون :other هو :value.',
    'required_unless'      => 'حقل :attribute مطلوب ما لم يكن :other في :values.',
    'required_with'        => 'حقل :attribute مطلوب عندما يكون :values موجودًا.',
    'required_with_all'    => 'حقل :attribute مطلوب عندما تكون :values موجودة.',
    'required_without'     => 'حقل :attribute مطلوب عندما يكون :values غير موجود.',
    'required_without_all' => 'حقل :attribute مطلوب عندما لا تكون أي من :values موجودة.',
    'same'                 => 'يجب أن يتطابق :attribute و :other.',
    'size'                 => [
        'numeric' => 'يجب أن يكون :attribute :size.',
        'file'    => 'يجب أن يكون :attribute :size كيلوبايت.',
        'string'  => 'يجب أن يكون :attribute :size أحرف.',
        'array'   => 'يجب أن يحتوي :attribute على :size عناصر.',
    ],
    'starts_with'          => 'يجب أن يبدأ :attribute بإحدى القيم التالية : :values.',
    'string'               => 'يجب أن يكون :attribute سلسلة نصية.',
    'timezone'             => 'يجب أن يكون :attribute منطقة زمنية صحيحة.',
    'unique'               => ':attribute تم أخذه بالفعل.',
    'uploaded'             => 'فشل تحميل :attribute.',
    'url'                  => 'تنسيق :attribute غير صحيح.',
    'uuid'                 => 'يجب أن يكون :attribute UUID صحيح.',

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
            'rule-name' => 'رسالة مخصصة',
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
