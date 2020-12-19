<?php
class QuestionsDB
{
    public static function get_users_questions($userId)
    {
        $db = Database::getDB();

        $query = 'SELECT * FROM questions WHERE ownerid = :userId';
        $statement = $db->prepare($query);
        $statement->bindValue(':userId', $userId);
        $statement->execute();
        $questions_fetch = $statement->fetchAll();
        $statement->closeCursor();
        $questions = [];
        foreach ($questions_fetch as $question) {
            $new_question = new question($question['id'], $question['owneremail'], $question['createdate'],
                $question['title'], $question['body'], $question['skills'], $question['score']);
            array_push($questions,$new_question);
        }
        return $questions;
    }

    public static function create_question($title, $body, $skills, $userId)
    {
        $db = Database::getDB();

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

    public static function get_question($questionId)
    {
        $db = Database::getDB();

        $query = 'SELECT * FROM questions WHERE id = :questionId';
        $statement = $db->prepare($query);
        $statement->bindValue(':questionId', $questionId);
        $statement->execute();
        $questions = $statement->fetch();
        $statement->closeCursor();

        if(!empty($questions)){
            return new question($questions['id'],$questions['owneremail'],$questions['createdate'],
                $questions['title'],$questions['body'],$questions['skills'],$questions['score']);
        }
        else{
            return false;
        }

    }

    public static function edit_question($questionId, $title, $body, $skills)
    {
        $db = Database::getDB();

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

    public static function delete_question($questionId)
    {
        $db = Database::getDB();

        $query = 'DELETE FROM questions 
              WHERE id=:questionID';
        $statement = $db->prepare($query);
        $statement->bindValue(':questionID', $questionId);
        $statement->execute();
        $statement->closeCursor();
    }
}