<?php
class AccountsDB {
    public static function validate_login($email, $password){
        $db = Database::getDB();
        $query = 'SELECT * FROM accounts WHERE email = :email AND password = :password';
        $statement = $db->prepare($query);
        $statement->bindValue(':email', $email);
        $statement->bindValue(':password', $password);
        $statement->execute();
        $user = $statement->fetch();
        $statement->closeCursor();

        if (!empty($user)){
            return new Account($user['id'],$user['email'],$user['fname'],$user['lname'], $user['birthday'],
                $user['password']);
        } else {
            return false;
        }
    }

    public static function add_user($email, $fname, $lname, $birthday, $password){
        $db = Database::getDB();
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

        if (!empty($user)){
            return new Account($user['id'],$user['email'],$user['fname'],$user['lname'], $user['birthday'],
                $user['password']);
        } else {
            return false;
        }
    }

    public static function check_registered($email){
        $db = Database::getDB();
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

    public static function get_user_info($userId){
        $db = Database::getDB();
        $query = 'SELECT * FROM accounts WHERE id = :id';
        $statement = $db->prepare($query);
        $statement->bindValue(':id', $userId);
        $statement->execute();
        $account = $statement->fetch();
        $statement->closeCursor();

        if (!empty($user)){
            $user_account = new Account($account['id'],$account['email'],$account['fname'],$account['lname'],
                $account['birthday'], $account['password']);
            return $user_account;
        } else {
            return false;
        }
    }
}