<?php
$name = ucfirst($_SESSION['user']->getFname()).' '.ucfirst($_SESSION['user']->getLname());
?>
<?php $title="Edit Question"; include('abstract-views/header.php');?>
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
    <h1 class="h1 mb-3 mt-3 font-weight-bold">Edit Question</h1>
    <form action="index.php" method="post">
        <input id="action" name="action" value="edit_question" type="hidden">
        <input id="questionId" name="questionId" value="<?php echo($questionId);?>" type="hidden">
        <div class="container alert alert-danger justify-content-center col-1" role="alert" <?php
        if(empty($nameError)){
            echo('style="display: none;"');
        }
        ?>>
            <?php echo($nameError);?>
        </div>
        <div class="h3 mt-5 font-weight-normal">
            <label for="name">Question Name</label>
            <br>
            <input id="name" name="name" type="text" value="<?php
            if(!empty($question)){
                echo($question->getTitle());
            }
            elseif($qtitle){
                echo($qtitle);
            }
            ?>">
            <br>
        </div>

        <div class="container alert alert-danger justify-content-center col-1" role="alert" <?php
        if(empty($bodyError)){
            echo('style="display: none;"');
        }
        ?>>
            <?php echo($bodyError);?>
        </div>
        <div class="h3 mt-5 font-weight-normal">
            <label for="body">Question Body</label>
            <br>
            <textarea id="body" name="body" ><?php
                if(!empty($question)){
                    echo($question->getBody());
                }
                elseif($body){
                    echo($body);
            }
                ?></textarea>
            <br>
        </div>

        <div class="container alert alert-danger justify-content-center col-1" role="alert" <?php
        if(empty($skillsError)){
            echo('style="display: none;"');
        }
        ?>>
            <?php echo($skillsError);?>
        </div>
        <div class="h3 mt-5 font-weight-normal">
            <label for="skills">Skills (Separated by commas)</label>
            <br>
            <input id="skills" name="skills" type="text" value="<?php
            if(!empty($question)){
                echo($question->getSkills());
            }
            elseif($skills){
                echo($skills);
            }
            ?>">
            <br>
        </div>

        <div>
            <input class="btn btn-lg btn-primary mt-3" type="submit" value="Edit Question">
        </div>
    </form>
</div>
<?php include('abstract-views/footer.php');?>