<?php
class AnswersDB
{
    public static function newAnswer($questionId, $ownerId, $body)
    {
        $db = Database::getDB();

        $query = 'INSERT INTO answers
                (questionid,ownerid, body, creationdate)
              VALUES 
                (:questionid, :ownerid, :body, now())';
        $statement = $db->prepare($query);
        $statement->bindValue(':questionid', $questionId);
        $statement->bindValue(':ownerid', $ownerId);
        $statement->bindValue(':body', $body);
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
}