<?php

function get_users_questions ($userId){
    global $db;

    $query = 'SELECT * FROM questions WHERE ownerid = :userId';
    $statement = $db->prepare($query);
    $statement->bindValue(':userId', $userId);
    $statement->execute();
    $questions = $statement->fetchAll();
    $statement->closeCursor();
    return $questions;
}

function create_question ($title, $body, $skills, $userId){
    global $db;

    $query = 'SELECT email FROM accounts WHERE id = :userId';
    $statement = $db->prepare($query);
    $statement->bindValue(':userId', $userId);
    $statement->execute();
    $returned = $statement->fetch();
    $email = $returned['email'];
    $statement->closeCursor();

    $query = 'INSERT INTO questions
                (owneremail,title, body, skills, ownerid, createddate)
              VALUES 
                (:email, :title, :body, :skills, :ownerid, now())';
    $statement = $db->prepare($query);
    $statement->bindValue(':ownerid', $userId);
    $statement->bindValue(':skills', $skills);
    $statement->bindValue(':body', $body);
    $statement->bindValue(':title', $title);
    $statement->bindValue(':email', $email);
    $statement->execute();
    $statement->closeCursor();
}

function get_question ($questionId){
    global $db;

    $query = 'SELECT * FROM questions WHERE id = :questionId';
    $statement = $db->prepare($query);
    $statement->bindValue(':questionId', $questionId);
    $statement->execute();
    $questions = $statement->fetch();
    $statement->closeCursor();
    return $questions;
}

function edit_question ($questionId, $title, $body, $skills){
    global $db;

    $query = 'UPDATE questions SET
                title = :title,
                body = :body,
                skills = :skills
              WHERE id=:questionID';
    $statement = $db->prepare($query);
    $statement->bindValue(':questionID', $questionId);
    $statement->bindValue(':skills', $skills);
    $statement->bindValue(':body', $body);
    $statement->bindValue(':title', $title);
    $statement->execute();
    $statement->closeCursor();
}

function delete_question ($questionId){
    global $db;

    $query = 'DELETE FROM questions 
              WHERE id=:questionID';
    $statement = $db->prepare($query);
    $statement->bindValue(':questionID', $questionId);
    $statement->execute();
    $statement->closeCursor();
}