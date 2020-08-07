<?php
    class Account {
        private $errorArray;

        public function __construct() {
            $this->errorArray = array();
        }

        public function register($un, $fn, $ln, $em, $em2, $pw, $pw2) {

            // validation
            $this->validateUsername($un);
            $this->validateFirstName($fn);
            $this->validateLastName($ln);
            $this->validateEmails($em, $em2);
            $this->validatePasswords($pw, $pw2);

            if (empty($this->errorsArray) == true) {
                // Insert account into db
                return true;
            } else {
                return false;
            }
        }

        public function getError($error) {
            if (!in_array($error, $this->errorsArray)) {
                $error = "";
            }
            return "<span class='errorMessage'>$error</span>";
        }

        private function validateUsername($un) {
            if (strlen($un) > 25 || strlen($un) < 5) {
                array_push($this->errorArray, "Username must be between 5 and 25 characters");
                return;
            }

            //TODO: check if user exists
        }
      
        private function validateFirstName($fn) {
            if (strlen($fn) < 2 || strlen($fn) > 25) {
                array_push($this->errorArray, "First Name must be between 2 and 25 characters");
                return;
            }
        }
      
        private function validateLastName($ln) {
            if (strlen($ln) < 2 || strlen($ln) > 25) {
                array_push($this->errorArray, "Last Name must be between 2 and 25 characters");
                return;
            }
        }
      
        private function validateEmails($em, $em2) {
            if ($em != $em2) {
                array_push($this->errorArray, "Emails do not match");
                return;
            }

            if (!filter_var($em, FILTER_VALIDATE_EMAIL)) {
                array_push($this->errorArray, "Plese enter a valid email");
                return;
            }

            //TODO: Check that email has not been already used
        }
      
        private function validatePasswords($pw1, $pw2) {
            if ($pw != $pw2) {
                arary_push($this->errorArray, "Passwords do not match");
                return;
            }

            if (preg_match('/[^A-Za-z0-9]', $pw)) {
                array_push($this->errorArray, "Password can only contain letters and numbers");
                return;
            }

            if (strlen($pw) < 5 || strlen($pw) > 25) {
                array_push($this->errorArray, "Password must be between 5 and 25 characters");
                return;
            }
        }
    }
?>