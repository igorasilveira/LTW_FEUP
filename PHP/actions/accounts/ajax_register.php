<?php
    include_once(__DIR__ . '/../../CommonInit.php');
    if( Session\isLoggedIn())
        AjaxReply\returnErrors(["already_logged_in"]);
    include_once(__DIR__ . '/../AjaxReply.php');
    include_once(__DIR__ . '/../../../database/UsersFacade.php');
    include_once(__DIR__ . '/../../../database/UsersHTMLDecorator.php');
    include_once(__DIR__ . '/../../Forms.php');
    if( ! Forms\checkFormKeyCorrect($_GET['form_key']))
        AjaxReply\returnError("bad_form_key");

    include_once(__DIR__ . '/../../Regex.php');
    include_once(__DIR__ . '/../../Captcha.php');
    if(! checkClientIPLogged())
        AjaxReply\returnError("not_valid_site_use");
    if(! checkNumberedCaptchaSuccess())
        AjaxReply\returnError("wrong_captcha"); 
    include_once(__DIR__ . '/../../Email.php');

    $username = $_GET['username'];
    $password = $_GET['password'];
    $confirmPassword = $_GET['confirm_password'];
    $name = $_GET['name'];
    $email = $_GET['email'];

    if($password === "")
        AjaxReply\returnError("empty_password_error");
    if(! Regex\checkStrongPassword($password))
        AjaxReply\returnError("password_doesnt_match_pattern");

    $error_list = [];
    if($password === $confirmPassword)
    {
        $usersDB = new UsersHTMLDecorator(new UsersFacade());

        if($usersDB->checkUsernameExists($username))
            array_push($error_list, "username_exists_error");

        if($email != "")
        {
            if($usersDB->checkEmailExists($email))
                array_push($error_list, "email_exists_error");
            if(! Email\checkValidFormat($email))
                array_push($error_list, "email_string_not_an_email");
            if(! Email\checkValid($email))
                array_push($error_list, "email_doesnt_exist");
        }

        if(count($error_list) == 0)
        {
            $isSuccessfulyRegistered = $usersDB->addUser($username, $password, $name, $email, 0); //HERE
            if($isSuccessfulyRegistered)
                Session\logIn($username);
            else
                array_push($error_list, "database_error");
        }
    }
    else
        $error_list = ["password_match_error"];

    if(count($error_list) > 0)
    {
        incrementCaptchaAttempts();
        if(shouldDisplayCaptcha())
            array_push($error_list, "should_display_captcha");
    }

    AjaxReply\returnErrors($error_list);
?>
