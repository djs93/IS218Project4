<?php
class answer
{
    private $id, $score, $questionid, $ownerid, $downvoted_ids, $upvoted_ids, $body, $creationdate;

    public function __construct($id, $score, $questionid, $ownerid, $downvoted_ids, $upvoted_ids, $body, $creationdate)
    {
        $this->id = $id;
        $this->score = $score;
        $this->questionid = $questionid;
        $this->ownerid = $ownerid;
        $this->downvoted_ids = $downvoted_ids;
        $this->upvoted_ids = $upvoted_ids;
        $this->body = $body;
        $this->creationdate = $creationdate;
    }

    /**
     * @return mixed
     */
    public function getCreationdate()
    {
        return $this->creationdate;
    }

    /**
     * @param mixed $creationdate
     */
    public function setCreationdate($creationdate)
    {
        $this->creationdate = $creationdate;
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
        if($this->downvoted_ids != null){
            return explode(',',$this->downvoted_ids );
        }
        else{
            return [];
        }
    }

    /**
     * @param mixed $downvoted_ids
     */
    public function setDownvotedIds($downvoted_ids)
    {
        $this->downvoted_ids = implode(',',$downvoted_ids);
    }

    /**
     * @return mixed
     */
    public function getUpvotedIds()
    {
        if($this->upvoted_ids != null){
            return explode(',',$this->upvoted_ids );
        }
        else{
            return [];
        }
    }

    /**
     * @param mixed $upvoted_ids
     */
    public function setUpvotedIds($upvoted_ids)
    {
        $this->upvoted_ids = implode(',',$upvoted_ids);
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