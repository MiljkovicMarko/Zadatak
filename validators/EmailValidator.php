<?php
    namespace App\Validators;

    use \App\Core\Validator;

    class EmailValidator implements Validator {
        public function isValid(string $value): bool {
            $len = strlen($value);
            return $len>2 && $len<255 && \filter_var($value, FILTER_VALIDATE_EMAIL);
        }
    }
