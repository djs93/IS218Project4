<?php
require('model/database.php');
require('model/accounts_db.php');
require('model/questions_db.php');

$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
    if ($action == NULL) {
        $action = 'display_login';
    }
}

switch ($action) {
    case 'display_login':{
        include('views/login.php');
        break;
    }

    case 'display_login_errored': {
        echo("Displaying errored");
        $hasLogonError = true;
        include('views/login.php');
        break;
    }

    //This is the 'login' case in the project outline
    case 'validate_login':{
        $email = filter_input(INPUT_POST, 'email', FILTER_DEFAULT);
        $password = filter_input(INPUT_POST, 'password', FILTER_DEFAULT);

        $error = "";
        $hasEmailError = false;
        $hasPasswordError = false;

        if(empty($email)){
            $error .= "Email is empty.<br>";
            $hasEmailError = true;
        }
        if(strpos($email, '@')===false){
            $error .= "Email must include @!<br>";
            $hasEmailError = true;
        }

        if(empty($password)){
            $error .= "Password is empty.<br>";
            $hasPasswordError = true;
        }
        //if(strlen($password)<8){
            //$error .= "Password must be at least 8 characters!<br>";
            //$hasPasswordError = true;
        //}
        if($hasEmailError == true || $hasPasswordError == true){
            if(!empty($email)){
                header("Location: .?action=display_login_errored&email=$email");
            }
            else{
                header('Location: .?action=display_login_errored');
            }
        } else {
            $userId = validate_login($email, $password);
            if($userId==false){
                header("Location: .?action=display_login_errored&email=$email");
            }
            else {
                header("Location: .?action=display_questions&userId=$userId");
            }
        }
        break;
    }

    case 'display_registration':{
        include('views/register.php');
        break;
    }

    case 'display_registration_filled':{
        $email = filter_input(INPUT_GET, 'email', FILTER_DEFAULT);
        include('views/register.php');
        break;
    }

    case 'display_registration_errored':{
        $email = filter_input(INPUT_GET, 'email', FILTER_DEFAULT);
        $fname = filter_input(INPUT_GET, 'fname', FILTER_DEFAULT);
        $lname = filter_input(INPUT_GET, 'lname', FILTER_DEFAULT);
        $bday = filter_input(INPUT_GET, 'bday', FILTER_DEFAULT);
        $emailError = filter_input(INPUT_GET, 'emailError', FILTER_DEFAULT);
        $passwordError = filter_input(INPUT_GET, 'passwordError', FILTER_DEFAULT);
        $fnameError = filter_input(INPUT_GET, 'fnameError', FILTER_DEFAULT);
        $lnameError = filter_input(INPUT_GET, 'lnameError', FILTER_DEFAULT);
        $bdayError = filter_input(INPUT_GET, 'bdayError', FILTER_DEFAULT);
        $invalidRegFields = true;
        include('views/register.php');
        break;
    }

    case 'display_registration_already_exists':{
        $email = filter_input(INPUT_GET, 'email', FILTER_DEFAULT);
        $fname = filter_input(INPUT_GET, 'fname', FILTER_DEFAULT);
        $lname = filter_input(INPUT_GET, 'lname', FILTER_DEFAULT);
        $bday = filter_input(INPUT_GET, 'bday', FILTER_DEFAULT);
        $emailExistsAlready = true;
        include('views/register.php');
        break;
    }

    //This is the 'register' case in the project outline
    case 'verify_registration':{
        $email = filter_input(INPUT_POST, 'email', FILTER_DEFAULT);
        $password = filter_input(INPUT_POST, 'password', FILTER_DEFAULT);
        $fname = filter_input(INPUT_POST, 'fname', FILTER_DEFAULT);
        $lname = filter_input(INPUT_POST, 'lname', FILTER_DEFAULT);
        $bday = filter_input(INPUT_POST, 'bday', FILTER_DEFAULT);

        $emailError = "";
        $passwordError = "";
        $fnameError = "";
        $lnameError = "";
        $bdayError = "";
        $hasEmailError = false;
        $hasPasswordError = false;
        $hasFnameError = false;
        $hasLnameError = false;
        $hasBdayError = false;

        if(empty($email)){
            $emailError .= "Email is empty.<br>";
            $hasEmailError = true;
        }
        else if(strpos($email, '@')===false){
            $emailError .= "Email must include @!<br>";
            $hasEmailError = true;
        }

        if(empty($password)){
            $passwordError .= "Password is empty.<br>";
            $hasPasswordError = true;
        }
        else if(strlen($password)<8){
            $passwordError .= "Password must be at least 8 characters!<br>";
            $hasPasswordError = true;
        }

        if(empty($fname)){
            $fnameError .= "First name is empty.<br>";
            $hasFnameError = true;
        }

        if(empty($lname)){
            $lnameError .= "Last name is empty.<br>";
            $hasLnameError = true;
        }

        if(empty($bday)){
            $bdayError .= "Birthday is empty.<br>";
            $hasBdayError = true;
        }

        if($hasEmailError == true || $hasPasswordError == true || $hasFnameError == true || $hasLnameError == true || $hasBdayError == true){
            $loc = "Location: .?action=display_registration_errored";
            if(!empty($email)){
                $loc .= "&email=$email";
            }
            if(!empty($fname)){
                $loc .= "&fname=$fname";
            }
            if(!empty($lname)){
                $loc .= "&lname=$lname";
            }
            if(!empty($bday)){
                $loc .= "&bday=$bday";
            }

            if(!empty($hasEmailError)){
                $loc .= "&emailError=$emailError";
            }
            if(!empty($hasPasswordError)){
                $loc .= "&passwordError=$passwordError";
            }
            if(!empty($hasFnameError)){
                $loc .= "&fnameError=$fnameError";
            }
            if(!empty($hasLnameError)){
                $loc .= "&lnameError=$lnameError";
            }
            if(!empty($hasBdayError)){
                $loc .= "&bdayError=$bdayError";
            }
            header($loc);
        } else {
            $userValid = check_registered($email);
            if($userValid==true){
                header("Location: .?action=display_registration_already_exists&email=$email&fname=$fname&lname=$lname&bday=$bday");
            }
            else {
                $userId = add_user($email, $fname, $lname, $bday, $password);
                if($userId == false){
                    $error = "Unknown error while adding user";
                    include('errors/error.php');
                }
                header("Location: .?action=display_questions&userId=$userId");
            }
        }

        break;
    }

    case 'display_questions':{
        $userId = filter_input(INPUT_GET, 'userId');
        if($userId == NULL || $userId < 0){
            header('Location: .?action=display_login');
        } else{
            $questions = get_users_questions($userId);
            include('views/display_questions.php');
        }
        break;
    }

    //This is the 'display_new_question' case in the project outline
    case 'display_question_form':{
        $userId = filter_input(INPUT_GET, 'userId');
        if(empty($userId) || $userId<0){
            $userId = filter_input(INPUT_POST, 'userId');
        }
        if($userId == NULL || $userId <0){
            header('Location: .?action=display_login');
        } else{
            include('views/new_question.php');
        }
        break;
    }

    case 'display_question_form_errored':{
        $userId = filter_input(INPUT_POST, 'userId');
        if(empty($userId) || $userId<0){
            $userId = filter_input(INPUT_GET, 'userId');
        }
        $nameError = filter_input(INPUT_GET, 'nameError');
        $bodyError = filter_input(INPUT_GET, 'bodyError');
        $skillsError = filter_input(INPUT_GET, 'skillsError');
        if($userId == NULL || $userId <0){
            header('Location: .?action=display_login');
        } else{
            include('views/new_question.php');
        }
        break;
    }

    //This is the 'create_new_question' case in the project outline
    case 'submit_question':{
        $userId = filter_input(INPUT_POST, 'userId');
        $title = filter_input(INPUT_POST, 'name', FILTER_DEFAULT);
        $body = filter_input(INPUT_POST, 'body', FILTER_DEFAULT);
        $skills = filter_input(INPUT_POST, 'skills', FILTER_DEFAULT);
        $skillsArray = explode(",", $skills);

        $nameError = "";
        $bodyError = "";
        $skillsError = "";

        $hasNameError = "";
        $hasBodyError = "";
        $hasSkillsError = "";

        if(empty($title)){
            $nameError .= "Question cannot be empty.";
            $hasNameError = true;
        }
        else if(strlen($title)<3){
            $nameError .= "Question name must be at least 3 characters!";
            $hasNameError = true;
        }

        if(strlen($body)===0){
            $bodyError .= "Question Body cannot be empty.";
            $hasBodyError = true;
        }
        else if(strlen($body)>=500){
            $bodyError .= "Question body must be less than 500 characters!";
            $hasBodyError = true;
        }

        if(count($skillsArray)<2){
            $skillsError .= "Must enter at least 2 skills!";
            $hasSkillsError = true;
        }
        if($hasNameError || $hasBodyError || $hasSkillsError){
            $loc = "Location: .?action=display_question_form_errored&userId=$userId";
            if($hasNameError){
                $loc .= "&nameError=$nameError";
            }
            if($hasBodyError){
                $loc .= "&bodyError=$bodyError";
            }
            if($hasSkillsError){
                $loc .= "&skillsError=$skillsError";
            }
            header($loc);
        } else{
            create_question($title, $body, $skills, $userId);
            header("Location: .?action=display_questions&userId=$userId");
        }
        break;
    }

    case 'display_edit_question':{
        $userId = filter_input(INPUT_POST, 'userId');
        if(empty($userId) || $userId<0){
            $userId = filter_input(INPUT_GET, 'userId');
        }
        $questionId = filter_input(INPUT_POST, 'questionId');
        $question = get_question($questionId);
        $qtitle = $question['title'];
        $body = $question['body'];
        $skills = $question['skills'];
        if($userId == NULL || $userId <0){
            header('Location: .?action=display_login');
        } else{
            include('views/edit_question.php');
        }
        break;
    }

    case 'edit_question':{
        $userId = filter_input(INPUT_POST, 'userId');
        $questionID = filter_input(INPUT_POST, 'questionId');
        $qtitle = filter_input(INPUT_POST, 'name', FILTER_DEFAULT);
        $body = filter_input(INPUT_POST, 'body', FILTER_DEFAULT);
        $skills = filter_input(INPUT_POST, 'skills', FILTER_DEFAULT);
        $skillsArray = explode(",", $skills);

        $nameError = "";
        $bodyError = "";
        $skillsError = "";

        $hasNameError = "";
        $hasBodyError = "";
        $hasSkillsError = "";

        if(empty($qtitle)){
            $nameError .= "Question cannot be empty.";
            $hasNameError = true;
        }
        else if(strlen($qtitle)<3){
            $nameError .= "Question name must be at least 3 characters!";
            $hasNameError = true;
        }

        if(strlen($body)===0){
            $bodyError .= "Question Body cannot be empty.";
            $hasBodyError = true;
        }
        else if(strlen($body)>=500){
            $bodyError .= "Question body must be less than 500 characters!";
            $hasBodyError = true;
        }

        if(count($skillsArray)<2){
            $skillsError .= "Must enter at least 2 skills!";
            $hasSkillsError = true;
        }
        if($hasNameError || $hasBodyError || $hasSkillsError){
            $loc = "Location: .?action=display_edit_question_form_errored&userId=$userId&name=$qtitle&body=$body&skills=$skills";
            if($hasNameError){
                $loc .= "&nameError=$nameError";
            }
            if($hasBodyError){
                $loc .= "&bodyError=$bodyError";
            }
            if($hasSkillsError){
                $loc .= "&skillsError=$skillsError";
            }
            header($loc);
        } else{
            edit_question($questionID, $qtitle, $body, $skills);
            header("Location: .?action=display_questions&userId=$userId");
        }
        break;
    }

    case 'display_edit_question_form_errored':{
        $userId = filter_input(INPUT_POST, 'userId');
        if(empty($userId) || $userId<0){
            $userId = filter_input(INPUT_GET, 'userId');
        }
        $nameError = filter_input(INPUT_GET, 'nameError');
        $bodyError = filter_input(INPUT_GET, 'bodyError');
        $skillsError = filter_input(INPUT_GET, 'skillsError');

        $qtitle = filter_input(INPUT_GET, 'name', FILTER_DEFAULT);
        $body = filter_input(INPUT_GET, 'body', FILTER_DEFAULT);
        $skills = filter_input(INPUT_GET, 'skills', FILTER_DEFAULT);
        $skillsArray = explode(",", $skills);
        if($userId == NULL || $userId <0){
            header('Location: .?action=display_login');
        } else{
            include('views/edit_question.php');
        }
        break;
    }

    case 'delete_question':{
        $userId = filter_input(INPUT_POST, 'userId');
        $questionID = filter_input(INPUT_POST, 'questionID');
        delete_question($questionID);
        header("Location: .?action=display_questions&userId=$userId");
        break;
    }

    case 'logout':{
        // remove all session variables
        session_unset();

        // destroy the session
        session_destroy();

        header('Location: .?action=display_login');
    }

    default: {
        $error = 'Unknown Action '.$action;
        include('errors/error.php');
    }
}