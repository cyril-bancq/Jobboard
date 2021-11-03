<?php

namespace App\Validators;

use App\Table\UserTable;

class UserValidator extends AbstractValidator{

    public function __construct(array $data, UserTable $table, ?int $adsID = null)
    {
        parent::__construct($data);
        $this->validator->rule('lengthBetween', ['name', 'first_name', 'email', 'address', 'postal_code', 'city', 'phone', 'birthdate', 'cv', 'website', 'description'], 5, 500);
        $this->validator->rule('integer', 'postal_code');
        $this->validator->rule(function ($field, $value) use ($table, $adsID) {
            return !$table->exists($field, $value, $adsID);
        }, 'email', 'This email is already use');
    }
}