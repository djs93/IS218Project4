<?php
    $name = ucfirst($_SESSION['user']->getFname()).' '.ucfirst($_SESSION['user']->getLname());
    $skillsArray = explode(",", $question->getSkills());
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
        <?php if($question->getOwnerid() === $_SESSION['user']->getId()):?>
        <div class="row justify-content-md-center mt-3">
            <div class="col-2">
                <form action="index.php" method="post">
                    <input id="action" name="action" value="display_edit_question" type="hidden">
                    <input id="questionId" name="questionId" value="<?php echo $question->getId();?>" type="hidden">
                    <div>
                        <input class="btn btn-secondary btn-md" type="submit" value="Edit">
                    </div>
                </form>
            </div>
            <div class="col-2">
                <form action="index.php" method="post">
                    <input id="action" name="action" value="delete_question" type="hidden">
                    <input id="questionID" name="questionID" value="<?php echo $question->getId();?>" type="hidden">
                    <div>
                        <input class="btn btn-secondary btn-md" type="submit" value="Delete">
                    </div>
                </form>
            </div>
        </div>
        <div class="row justify-content-md-center mt-3">
            <?php else:?>
        <div class="row justify-content-md-center mt-5">
        <?php endif;?>
            <table class="col-10 table table-striped table-bordered">
                <tr>
                    <th>Question Title</th>
                </tr>
                    <tr>
                        <td><h2><?php echo $question->getTitle(); ?></h2></td>
                    </tr>
            </table>
        </div>
        <div class="row justify-content-md-center mt-5">
            <table class="col-10 table table-striped table-bordered">
                <tr>
                    <th>Author</th>
                    <th>Author Email</th>
                    <th>Creation Time</th>
                    <th>Question ID</th>
                    <th>Score</th>
                </tr>
                <tr>
                    <td><?php echo AccountsDB::get_user_name($question->getOwnerid()); ?></td>
                    <td><?php echo $question->getOwneremail(); ?></td>
                    <td><?php echo $question->getCreatedate(); ?></td>
                    <td><?php echo $question->getId(); ?></td>
                    <td><?php echo $question->getScore(); ?></td>
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
        <div class="row justify-content-md-center mt-5">
            <table class="col-10 table table-striped table-bordered">
                <tr>
                    <th>Listed Skills</th>
                </tr>
                <?php foreach ($skillsArray as $skill) : ?>
                <tr>
                    <td><?php echo $skill; ?></td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>

<?php include('abstract-views/footer.php');?>