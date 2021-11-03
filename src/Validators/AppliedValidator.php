<?php

namespace App\Validators;

class AppliedValidator extends AbstractValidator{

    public function __construct(array $data)
    {
        parent::__construct($data);
        $this->validator->rule('lengthBetween', 'motivation_people', 5, 500);
    }
}