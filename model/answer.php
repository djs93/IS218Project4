<?php
class answer
{
    private $id, $score, $questionid, $ownerid, $downvoted_ids, $upvoted_ids, $body;

    public function __construct($id, $score, $questionid, $ownerid, $downvoted_ids, $upvoted_ids, $body)
    {
        $this->id = $id;
        $this->score = $score;
        $this->questionid = $questionid;
        $this->ownerid = $ownerid;
        $this->downvoted_ids = $downvoted_ids;
        $this->upvoted_ids = $upvoted_ids;
        $this->body = $body;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * @param mixed $score
     */
    public function setScore($score)
    {
        $this->score = $score;
    }

    /**
     * @return mixed
     */
    public function getQuestionid()
    {
        return $this->questionid;
    }

    /**
     * @param mixed $questionid
     */
    public function setQuestionid($questionid)
    {
        $this->questionid = $questionid;
    }

    /**
     * @return mixed
     */
    public function getOwnerid()
    {
        return $this->ownerid;
    }

    /**
     * @param mixed $ownerid
     */
    public function setOwnerid($ownerid)
    {
        $this->ownerid = $ownerid;
    }

    /**
     * @return mixed
     */
    public function getDownvotedIds()
    {
        return $this->downvoted_ids;
    }

    /**
     * @param mixed $downvoted_ids
     */
    public function setDownvotedIds($downvoted_ids)
    {
        $this->downvoted_ids = $downvoted_ids;
    }

    /**
     * @return mixed
     */
    public function getUpvotedIds()
    {
        return $this->upvoted_ids;
    }

    /**
     * @param mixed $upvoted_ids
     */
    public function setUpvotedIds($upvoted_ids)
    {
        $this->upvoted_ids = $upvoted_ids;
    }

    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param mixed $body
     */
    public function setBody($body)
    {
        $this->body = $body;
    }
}