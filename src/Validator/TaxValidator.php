<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class TaxValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        /* @var App\Validator\Tax $constraint */

        if (null === $value || '' === $value) {
            return;
        }

        //length of Tax Number
        $length = strlen($value);

        //Country code recuperation
        $country = substr($value, 0, 2);

        //numerical number recuperation
        $code = substr($value, 3, $length);

        //verification of Tax Number validity
        if(!($country=='DE' && $length==11 && is_numeric($code))&&!($country=='IT' && $length==13 && is_numeric($code))&&!($country=='GR' && $length==11 && is_numeric($code))){
            // TODO: implement the validation here
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $value)
                ->addViolation();
        }

    }
}
