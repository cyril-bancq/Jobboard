<?php

namespace App\Validators;

use App\Table\PostTable;

class PostValidator extends AbstractValidator{

    public function __construct(array $data, PostTable $table, ?int $adsID = null)
    {
        parent::__construct($data);
        $this->validator->rule('required', ['title', 'description', 'contract', 'date', 'salary', 'hour', 'duration']);
        $this->validator->rule('lengthBetween', ['title', 'description', 'contract'], 5, 500);
        $this->validator->rule('integer', ['salary', 'hour']);
        $this->validator->rule(function ($field, $value) use ($table, $adsID) {
            return !$table->exists($field, $value, $adsID);
        }, 'title', 'This title is already use');
    }
}