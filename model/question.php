<?php
class question
{
    private $id, $owneremail, $ownderid, $createdate, $title, $body, $skills, $score, $downvoted_ids, $upvoted_ids;

    public function __construct($id, $owneremail, $ownderid, $createdate, $title, $body, $skills, $score, $downvoted_ids, $upvoted_ids)
    {
        $this->id = $id;
        $this->owneremail = $owneremail;
        $this->ownderid = $ownderid;
        $this->createdate = $createdate;
        $this->title = $title;
        $this->body = $body;
        $this->skills = $skills;
        $this->score = $score;
        $this->downvoted_ids = $downvoted_ids;
        $this->upvoted_ids = $upvoted_ids;
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
    public function getOwneremail()
    {
        return $this->owneremail;
    }

    /**
     * @param mixed $owneremail
     */
    public function setOwneremail($owneremail)
    {
        $this->owneremail = $owneremail;
    }

    /**
     * @return mixed
     */
    public function getCreatedate()
    {
        return $this->createdate;
    }

    /**
     * @param mixed $createdate
     */
    public function setCreatedate($createdate)
    {
        $this->createdate = $createdate;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
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

    /**
     * @return mixed
     */
    public function getSkills()
    {
        return $this->skills;
    }

    /**
     * @param mixed $skills
     */
    public function setSkills($skills)
    {
        $this->skills = $skills;
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
    public function getOwnerid()
    {
        return $this->ownderid;
    }

    /**
     * @param mixed $ownderid
     */
    public function setOwnderid($ownderid)
    {
        $this->ownderid = $ownderid;
    }

}