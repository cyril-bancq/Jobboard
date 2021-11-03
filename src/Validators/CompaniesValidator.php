<?php

namespace App\Validators;

use App\Table\CompaniesTable;

class CompaniesValidator extends AbstractValidator{

    public function __construct(array $data, CompaniesTable $table, ?int $adsID = null)
    {
        parent::__construct($data);
        $this->validator->rule('lengthBetween', ['name', 'activities', 'address', 'postal_code', 'city', 'siret', 'password', 'website', 'phone', 'email', 'contact_name'], 5, 500);
        $this->validator->rule('integer', ['postal_code', 'siret', 'number_employes']);
        $this->validator->rule(function ($field, $value) use ($table, $adsID) {
            return !$table->exists($field, $value, $adsID);
        }, 'name', 'This name is already use');
    }
}