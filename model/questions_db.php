<?php
class QuestionsDB
{
    public static function get_users_questions($userId)
    {
        $db = Database::getDB();

        $query = 'SELECT * FROM questions WHERE ownerid = :userId ORDER BY score DESC';
        $statement = $db->prepare($query);
        $statement->bindValue(':userId', $userId);
        $statement->execute();
        $questions_fetch = $statement->fetchAll();
        $statement->closeCursor();
        $questions = [];
        foreach ($questions_fetch as $question) {
            $new_question = new question($question['id'], $question['owneremail'], $question['ownerid'],
                $question['createddate'], $question['title'], $question['body'], $question['skills'], $question['score'],
                $question['downvoted_ids'],$question['upvoted_ids']);
            array_push($questions,$new_question);
        }
        return $questions;
    }

    public static function get_all_questions()
    {
        $db = Database::getDB();

        $query = 'SELECT * FROM questions ORDER BY score DESC';
        $statement = $db->prepare($query);
        $statement->execute();
        $questions_fetch = $statement->fetchAll();
        $statement->closeCursor();
        $questions = [];
        foreach ($questions_fetch as $question) {
            $new_question = new question($question['id'], $question['owneremail'], $question['ownerid'],
                $question['createddate'], $question['title'], $question['body'], $question['skills'], $question['score'],
                $question['downvoted_ids'],$question['upvoted_ids']);
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
                (owneremail,title, body, skills, ownerid, createddate, upvoted_ids, downvoted_ids)
              VALUES 
                (:email, :title, :body, :skills, :ownerid, now(), :uid, :did)';
        $statement = $db->prepare($query);
        $statement->bindValue(':ownerid', $userId);
        $statement->bindValue(':skills', $skills);
        $statement->bindValue(':body', $body);
        $statement->bindValue(':title', $title);
        $statement->bindValue(':email', $email);
        $statement->bindValue(':uid', "");
        $statement->bindValue(':did', "");
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
            return new question($questions['id'], $questions['owneremail'], $questions['ownerid'],
                $questions['createddate'], $questions['title'], $questions['body'], $questions['skills'],
                $questions['score'],$questions['downvoted_ids'],$questions['upvoted_ids']);
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

    public static function apply_upvote($questionId, $userId){
        $question = self::get_question($questionId);
        $downvote_users = $question->getDownvotedIds();
        $upvote_users = $question->getUpvotedIds();
        if(in_array($userId,$downvote_users)){
            //toggle off user's downvote
            self::apply_downvote($questionId, $userId);
            $question = self::get_question($questionId);
        }
        if(in_array($userId,$upvote_users)){
            //decrement score and remove user from answer's upvote list
            $question->setScore($question->getScore()-1);
            $upvote_users = \array_diff($upvote_users, [$userId]);
        }
        else{
            //increment score and add user to answer's upvote list
            $question->setScore($question->getScore()+1);
            array_push($upvote_users, $userId);
        }
        $question->setUpvotedIds($upvote_users);
        $db = Database::getDB();
        $query = 'UPDATE questions SET
                score = :score,
                upvoted_ids = :upvote_ids
              WHERE id=:questionid';
        $statement = $db->prepare($query);
        $statement->bindValue(':score', $question->getScore());
        $statement->bindValue(':upvote_ids',implode(',',$upvote_users));
        $statement->bindValue(':questionid', $questionId);
        $statement->execute();
        $statement->closeCursor();
    }

    public static function apply_downvote($questionId, $userId){
        $question = self::get_question($questionId);
        $downvote_users = $question->getDownvotedIds();
        $upvote_users = $question->getUpvotedIds();
        if(in_array($userId,$upvote_users)){
            //toggle off user's upvote
            self::apply_upvote($questionId, $userId);
            $question = self::get_question($questionId);
        }
        if(in_array($userId,$downvote_users)){
            //increment score and remove user from answer's downvote list
            $question->setScore($question->getScore()+1);
            $downvote_users = \array_diff($downvote_users, [$userId]);
        }
        else{
            //decrement score and add user to answer's downvote list
            $question->setScore($question->getScore()-1);
            array_push($downvote_users, $userId);
        }
        $question->setDownvotedIds($downvote_users);
        $db = Database::getDB();
        $query = 'UPDATE questions SET
                score = :score,
                downvoted_ids = :downvote_ids
              WHERE id=:questionid';
        $statement = $db->prepare($query);
        $statement->bindValue(':score', $question->getScore());
        $statement->bindValue(':downvote_ids',implode(',',$downvote_users));
        $statement->bindValue(':questionid', $questionId);
        $statement->execute();
        $statement->closeCursor();
    }
}