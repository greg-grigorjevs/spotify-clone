<?php

       

    function sanitizeFormUsername($inputText) {
        $inputText = strip_tags($inputText);
        $inputText = str_replace(" ","", $inputText);
        return $inputText;
    }

    function sanitizeFormPassword($inputText) {
        $inputText = strip_tags($inputText);
        return $inputText;
    }

    function sanitizeFormInput($inputText) {
        $inputText = strip_tags($inputText);
        $inputText = str_replace(" ", "", $inputText);
        $inputText = ucfirst(strtolower($inputText)) ;
        return $inputText;
    }


    if(isset($_POST['registerButton'])) {
        $username = sanitizeFormUsername($_POST['registerUsername']);
        $firstName = sanitizeFormInput($_POST['firstName']);
        $lastName = sanitizeFormInput($_POST['lastName']);
        $email = sanitizeFormInput($_POST['email']);
        $email2 = sanitizeFormInput($_POST['email2']);
        $password = sanitizeFormPassword($_POST['registerPassword']);
        $password2 = sanitizeFormPassword($_POST['registerPassword2']);

        $wasSuccessful = $account->register($username, $firstName, $lastName, $email, $email2, $password, $password2);

        if ($wasSuccessful) {
            header("Location: index.php");
        }

    }

?>