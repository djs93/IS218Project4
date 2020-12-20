<?php
    $name = ucfirst($_SESSION['user']->getFname()).' '.ucfirst($_SESSION['user']->getLname());
    $skillsArray = explode(",", $question->getSkills());
    $answerArray = AnswersDB::get_answers($question->getId());
?>
<?php $title="User Questions"; include('abstract-views/header.php');?>
    <div class="col-2" style="border-right: 1px solid rgba(0,0,0,.1); background-color: rgba(0,0,0,0.05);">
        <nav id="sidebar" class="mt-4">
            <div class="sidebar-header">
                <h3><?php echo $name;?></h3>
            </div>

            <ul class="list-unstyled components">
                <p><?php echo $_SESSION['user']->getEmail();?></>
                <li>
                    <a class="btn btn-lg btn-primary mt-3" href=".?action=display_question_form">Add Question</a>
                </li>
                <li>
                    <a class="btn btn-lg btn-primary mt-3" href=".?action=display_questions">Home</a>
                </li>
                <li>
                    <a class="btn btn-lg btn-primary mt-3" href=".?action=display_all_questions">All Questions</a>
                </li>
            </ul>
        </nav>
    </div>
    <div class="col">
        <div class="row justify-content-md-center mt-3">
        <?php if($question->getOwnerid() === $_SESSION['user']->getId()):?>
            <div class="col-2">
                <form action="index.php" method="post">
                    <input id="action" name="action" value="display_edit_question" type="hidden">
                    <input id="questionId" name="questionId" value="<?php echo $question->getId();?>" type="hidden">
                    <div>
                        <input class="btn btn-secondary btn-md" type="submit" value="Edit">
                    </div>
                </form>
            </div>
        <?php endif;?>
            <div class="col-2">
                <form action="index.php" method="post">
                    <input id="action" name="action" value="display_post_answer" type="hidden">
                    <input id="questionId" name="questionId" value="<?php echo $question->getId();?>" type="hidden">
                    <div>
                        <input class="btn btn-secondary btn-md" type="submit" value="New Answer">
                    </div>
                </form>
            </div>
        <?php if($question->getOwnerid() === $_SESSION['user']->getId()):?>
            <div class="col-2">
                <form action="index.php" method="post">
                    <input id="action" name="action" value="delete_question" type="hidden">
                    <input id="questionID" name="questionID" value="<?php echo $question->getId();?>" type="hidden">
                    <div>
                        <input class="btn btn-secondary btn-md" type="submit" value="Delete">
                    </div>
                </form>
            </div>
        <?php endif;?>
        </div>
        <div class="row justify-content-md-center mt-3">
            <table class="col-10 table table-striped table-bordered">
                <tr>
                    <th>Question Title</th>
                </tr>
                    <tr>
                        <td><h2><?php echo $question->getTitle(); ?></h2></td>
                    </tr>
            </table>
        </div>
        <div class="row justify-content-md-center mt-1">
            <table class="col-10 table table-striped table-bordered">
                <tr>
                    <th>Author</th>
                    <th>Author Email</th>
                    <th>Creation Time</th>
                    <th>Question ID</th>
                    <th>Score</th>
                </tr>
                <tr>
                    <td style="line-height: 5px;"><?php echo AccountsDB::get_user_name($question->getOwnerid()); ?></td>
                    <td style="line-height: 5px;"><?php echo $question->getOwneremail(); ?></td>
                    <td style="line-height: 5px;"><?php echo $question->getCreatedate(); ?></td>
                    <td style="line-height: 5px;"><?php echo $question->getId(); ?></td>
                    <td style="line-height: 5px;"><?php echo $question->getScore(); ?></td>
                </tr>
            </table>
        </div>
        <div class="row justify-content-md-center mt-5">
            <table class="col-10 table table-striped table-bordered">
                <tr>
                    <th>Question Body</th>
                </tr>
                <tr>
                    <td><?php echo $question->getBody(); ?></td>
                </tr>
            </table>
        </div>
        <div class="row justify-content-md-center mt-1">
            <table class="col-10 table table-striped table-bordered">
                <tr>
                    <th>Listed Skills</th>
                </tr>
                <?php foreach ($skillsArray as $skill) : ?>
                <tr style="line-height: 5px;">
                    <td><?php echo $skill; ?></td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <div class="row justify-content-md-center mt-5">
            <table class="col-10 table table-striped table-bordered">
                <tr>
                    <th>Answers</th>
                </tr>
                <tr>
                    <td>
                        <table class="col-12 table table-striped table-bordered">
                            <tr>
                                <th style="width: 7% !important;">Vote</th>
                                <th style="width: 7% !important;">Score</th>
                                <th>Answer Body</th>
                                <th style="width: 10% !important;">Author</th>
                                <th style="width: 10% !important;">Date</th>
                            </tr>
                            <?php /** @var answer $answer */
                            foreach ($answerArray as $answer) : ?>
                                <tr>
                                    <td style="vertical-align: middle">
                                        <div class="col">
                                            <div class="row justify-content-md-center">
                                                <a class="btn btn-sm <?php
                                                if(in_array($_SESSION['user']->getId(),$answer->getDownvotedIds())){
                                                    echo "btn-secondary";
                                                }
                                                else{
                                                    echo "btn-success";
                                                }?>"
                                                   href=".?action=upvote_answer&answerId=<?php echo $answer->getId() ?>&questionId=<?php echo $question->getId() ?>">↑</a>
                                                <a class="btn btn-sm <?php
                                                if(in_array($_SESSION['user']->getId(),$answer->getUpvotedIds())){
                                                    echo "btn-secondary";
                                                }
                                                else{
                                                    echo "btn-danger";
                                                }?>"
                                                   href=".?action=downvote_answer&answerId=<?php echo $answer->getId() ?>&questionId=<?php echo $question->getId() ?>">↓</a>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="vertical-align: middle"><?php echo $answer->getScore();?></td>
                                    <td style="vertical-align: middle"><?php echo $answer->getBody(); ?></td>
                                    <td style="vertical-align: middle"><?php echo AccountsDB::get_user_name($answer->getOwnerid()); ?></td>
                                    <td style="vertical-align: middle"><?php echo $answer->getCreationdate(); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </div>

<?php include('abstract-views/footer.php');?>