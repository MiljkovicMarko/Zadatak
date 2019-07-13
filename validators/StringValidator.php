<?php
    namespace App\Validators;

    use \App\Core\Validator;

    class StringValidator implements Validator {
        // private $isEmail;
        private $minLength;
        private $maxLength;

        public function __construct() {
            $this->minLength = 0;
            $this->maxLength = 255;
            $this->isEmail = false;
        }

        // public function &setEmail() : StringValidator {
        //     $this->isEmail = true;
        //     return $this;
        // }

        public function &setMinLength(int $length) : StringValidator {
            $this->minLength = max(0, $length);
            return $this;
        }

        public function &setMaxLength(int $length) : StringValidator {
            $this->maxLength = max(1, $length);
            return $this;
        }

        public function isValid(string $value): bool {
            // $pattern = '/^';

            // if ($this->isEmail === true) {
            //     $pattern .= '[0-9]{4}\-[0-9]{2}\-[0-9]{2}';
            // }

            // $pattern .= '$/';

            // return \boolval(\preg_match($pattern, $value));

            $len = strlen($value);
            return $this->minLength <= $len && $len <= $this->maxLength;
        }
    }
