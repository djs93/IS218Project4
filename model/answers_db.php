<?php
class AnswersDB
{
    public static function newAnswer($questionId, $ownerId, $body)
    {
        $db = Database::getDB();

        $query = 'INSERT INTO answers
                (questionid,ownerid, body, creationdate,upvoted_ids,downvoted_ids)
              VALUES 
                (:questionid, :ownerid, :body, now(), :uid,:did)';
        $statement = $db->prepare($query);
        $statement->bindValue(':questionid', $questionId);
        $statement->bindValue(':ownerid', $ownerId);
        $statement->bindValue(':body', $body);
        $statement->bindValue(':uid', "");
        $statement->bindValue(':did', "");
        $statement->execute();
        $statement->closeCursor();
    }

    public static function get_answers($questionId)
    {
        $db = Database::getDB();

        $query = 'SELECT * FROM answers WHERE questionid = :questionId ORDER BY score DESC';
        $statement = $db->prepare($query);
        $statement->bindValue(':questionId', $questionId);
        $statement->execute();
        $answers_fetch = $statement->fetchAll();
        $statement->closeCursor();
        $answers = [];
        foreach ($answers_fetch as $answer) {
            $new_answer = new answer($answer['id'],$answer['score'],$answer['questionid'],$answer['ownerid'],
            $answer['downvoted_ids'],$answer['upvoted_ids'],$answer['body'],$answer['creationdate']);
            array_push($answers,$new_answer);
        }
        return $answers;
    }

    public static function get_answer($answerId)
    {
        $db = Database::getDB();

        $query = 'SELECT * FROM answers WHERE id = :id';
        $statement = $db->prepare($query);
        $statement->bindValue(':id', $answerId);
        $statement->execute();
        $answer = $statement->fetch();
        $statement->closeCursor();

        if(!empty($answer)){
            return new answer($answer['id'],$answer['score'],$answer['questionid'],$answer['ownerid'],
                $answer['downvoted_ids'],$answer['upvoted_ids'],$answer['body'],$answer['creationdate']);
        }
        return false;
    }

    public static function apply_upvote($answerId, $userId){
        $answer = self::get_answer($answerId);
        $downvote_users = $answer->getDownvotedIds();
        $upvote_users = $answer->getUpvotedIds();
        if(in_array($userId,$downvote_users)){
            //toggle off user's downvote
            self::apply_downvote($answerId, $userId);
            $answer = self::get_answer($answerId);
        }
        if(in_array($userId,$upvote_users)){
            //decrement score and remove user from answer's upvote list
            $answer->setScore($answer->getScore()-1);
            $upvote_users = \array_diff($upvote_users, [$userId]);
        }
        else{
            //increment score and add user to answer's upvote list
            $answer->setScore($answer->getScore()+1);
            array_push($upvote_users, $userId);
        }
        $answer->setUpvotedIds($upvote_users);
        $db = Database::getDB();
        $query = 'UPDATE answers SET
                score = :score,
                upvoted_ids = :upvote_ids
              WHERE id=:answerid';
        $statement = $db->prepare($query);
        $statement->bindValue(':score', $answer->getScore());
        $statement->bindValue(':upvote_ids',implode(',',$upvote_users));
        $statement->bindValue(':answerid', $answerId);
        $statement->execute();
        $statement->closeCursor();
    }

    public static function apply_downvote($answerId, $userId){
        $answer = self::get_answer($answerId);
        $downvote_users = $answer->getDownvotedIds();
        $upvote_users = $answer->getUpvotedIds();
        if(in_array($userId,$upvote_users)){
            //toggle off user's upvote
            self::apply_upvote($answerId, $userId);
            $answer = self::get_answer($answerId);
        }
        if(in_array($userId,$downvote_users)){
            //increment score and remove user from answer's downvote list
            $answer->setScore($answer->getScore()+1);
            $downvote_users = \array_diff($downvote_users, [$userId]);
        }
        else{
            //decrement score and add user to answer's downvote list
            $answer->setScore($answer->getScore()-1);
            array_push($downvote_users, $userId);
        }
        $answer->setDownvotedIds($downvote_users);
        $db = Database::getDB();
        $query = 'UPDATE answers SET
                score = :score,
                downvoted_ids = :downvote_ids
              WHERE id=:answerid';
        $statement = $db->prepare($query);
        $statement->bindValue(':score', $answer->getScore());
        $statement->bindValue(':downvote_ids',implode(',',$downvote_users));
        $statement->bindValue(':answerid', $answerId);
        $statement->execute();
        $statement->closeCursor();
    }
}