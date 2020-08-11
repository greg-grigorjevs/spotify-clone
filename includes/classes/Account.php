<?php
    class Account {
        private $errorsArray;
        private $con;

        public function __construct($con) {
            $this->con = $con;
            $this->errorsArray = array();
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
                //STOPPED AT 18 3:24
                return insertUserDetails($un, $fn, $ln, $em, $pw);
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

        private function insertUserDetails($un, $fn, $ln, $em, $pw) {
            $encryptedPw = md5($pw);
            $profilePic = "assets/images/profile-pics/head_emerald.png";
        }

        private function validateUsername($un) {
            if (strlen($un) > 25 || strlen($un) < 5) {
                array_push($this->errorsArray, Constants::$usernameCharacters);
                return;
            }

            //TODO: check if user exists
        }
      
        private function validateFirstName($fn) {
            if (strlen($fn) < 2 || strlen($fn) > 25) {
                array_push($this->errorsArray, Constants::$firstNameCharacters);
                return;
            }
        }
      
        private function validateLastName($ln) {
            if (strlen($ln) < 2 || strlen($ln) > 25) {
                array_push($this->errorsArray, Constants::$lastNameCharacters);
                return;
            }
        }
      
        private function validateEmails($em, $em2) {
            if ($em != $em2) {
                array_push($this->errorsArray, Constants::$emailsDoNotMatch);
                return;
            }

            if (!filter_var($em, FILTER_VALIDATE_EMAIL)) {
                array_push($this->errorsArray, Constants::$emailInvalid);
                return;
            }

            //TODO: Check that email has not been already used
        }
      
        private function validatePasswords($pw, $pw2) {
            if ($pw != $pw2) {
                array_push($this->errorsArray, Constants::$passwordsDoNotMatch);
                return;
            }

            if (preg_match('/[^A-Za-z0-9]', $pw)) {
                array_push($this->errorsArray, Constants::$passwordNotAlphanumeric);
                return;
            }

            if (strlen($pw) < 5 || strlen($pw) > 25) {
                array_push($this->errorsArray, Constants::$passwordCharacters);
                return;
            }
        }
    }
?>