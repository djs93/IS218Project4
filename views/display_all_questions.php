<?php
    $name = ucfirst($_SESSION['user']->getFname()).' '.ucfirst($_SESSION['user']->getLname());
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
                    <a class="btn btn-lg btn-primary mt-3" href=".?action=display_questions">User Questions</a>
                </li>
            </ul>
        </nav>
    </div>
    <div class="col">
        <div class="row justify-content-md-center mt-5">
            <table class="col-10 table table-striped table-bordered">
                <tr>
                    <th style="width: 7% !important;">Vote</th>
                    <th style="width: 7% !important;">Score</th>
                    <th style="width: 30% !important;">Question Title</th>
                    <th>Author</th>
                    <th style="width: 7% !important;">Answers</th>
                    <th>Question Body</th>
                    <th>View Details</th>
                    <th style="width: 7% !important;">New Answer</th>
                </tr>
                <?php /** @var question $question */
                foreach ($questions as $question) : ?>
                    <tr>
                        <td style="vertical-align: middle">
                            <div class="col">
                                <div class="row justify-content-md-center">
                                    <a class="btn btn-sm <?php
                                    if(in_array($_SESSION['user']->getId(),$question->getDownvotedIds())){
                                        echo "btn-secondary";
                                    }
                                    else{
                                        echo "btn-success";
                                    }?>"
                                       href=".?action=upvote_question&questionId=<?php echo $question->getId() ?>">↑</a>
                                    <a class="btn btn-sm <?php
                                    if(in_array($_SESSION['user']->getId(),$question->getUpvotedIds())){
                                        echo "btn-secondary";
                                    }
                                    else{
                                        echo "btn-danger";
                                    }?>"
                                       href=".?action=downvote_question&questionId=<?php echo $question->getId() ?>">↓</a>
                                </div>
                            </div>
                        </td>
                        <td style="vertical-align: middle"><?php echo $question->getScore(); ?></td>
                        <td style="vertical-align: middle"><?php echo $question->getTitle(); ?></td>
                        <td style="vertical-align: middle"><?php echo AccountsDB::get_user_name($question->getOwnerId()); ?></td>
                        <td style="vertical-align: middle"><?php echo count(AnswersDB::get_answers($question->getId())); ?></td>
                        <td style="vertical-align: middle"><?php echo $question->getBody(); ?></td>
                        <td style="vertical-align: middle">
                            <form action="index.php" method="post">
                                <input id="action" name="action" value="show_question_single" type="hidden">
                                <input id="questionId" name="questionId" value="<?php echo $question->getId();?>" type="hidden">
                                <div>
                                    <input class="btn btn-secondary btn-sm" type="submit" value="View">
                                </div>
                            </form>
                        </td>
                        <td style="vertical-align: middle">
                            <form action="index.php" method="post">
                                <input id="action" name="action" value="display_post_answer" type="hidden">
                                <input id="questionId" name="questionId" value="<?php echo $question->getId();?>" type="hidden">
                                <div>
                                    <input class="btn btn-secondary btn-sm" type="submit" value="Answer">
                                </div>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>

<?php include('abstract-views/footer.php');?>