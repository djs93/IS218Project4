<?php

function validate_login($email, $password){
    global $db;
    $query = 'SELECT * FROM accounts WHERE email = :email AND password = :password';
    $statement = $db->prepare($query);
    $statement->bindValue(':email', $email);
    $statement->bindValue(':password', $password);
    $statement->execute();
    $user = $statement->fetch();
    $statement->closeCursor();

    if (count($user)>0){
        return $user['id'];
    } else {
        return false;
    }
}

//"Creating a user" function
function add_user($email, $fname, $lname, $birthday, $password){
    global $db;
    $query = 'INSERT INTO `accounts` (`email`, `fname`, `lname`, `birthday`, `password`) 
                        VALUES(:email, :fname, :lname, :bday, :password)';
    $statement = $db->prepare($query);
    $statement->bindValue(':email', $email);
    $statement->bindValue(':fname', $fname);
    $statement->bindValue(':lname', $lname);
    $statement->bindValue(':bday', $birthday);
    $statement->bindValue(':password', $password);
    $statement->execute();
    $statement->closeCursor();

    $query = 'SELECT * FROM accounts WHERE email = :email AND password = :password';
    $statement = $db->prepare($query);
    $statement->bindValue(':email', $email);
    $statement->bindValue(':password', $password);
    $statement->execute();
    $user = $statement->fetch();
    $statement->closeCursor();

    if (count($user)>0){
        return $user['id'];
    } else {
        return false;
    }
}

function check_registered($email){
    global $db;
    $query = 'SELECT * FROM accounts WHERE email = :email';
    $statement = $db->prepare($query);
    $statement->bindValue(':email', $email);
    $statement->execute();
    $account = $statement->fetch();
    $statement->closeCursor();

    if (empty($account)){
        return false;
    } else {
        return true;
    }
}

//"Getting a user" function
function get_user_info($userId){
    global $db;
    $query = 'SELECT * FROM accounts WHERE id = :id';
    $statement = $db->prepare($query);
    $statement->bindValue(':id', $userId);
    $statement->execute();
    $account = $statement->fetch();
    $statement->closeCursor();

    return $account;
}