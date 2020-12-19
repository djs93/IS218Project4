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
            </ul>
        </nav>
    </div>
    <div class="col">
        <div class="row justify-content-md-center mt-5">
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
                </tr>
                <tr>
                    <td><?php echo $_SESSION['user']->getFname().' '.$_SESSION['user']->getLname(); ?></td>
                    <td><?php echo $question->getOwneremail(); ?></td>
                    <td><?php echo $question->getCreatedate(); ?></td>
                    <td><?php echo $question->getId(); ?></td>
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