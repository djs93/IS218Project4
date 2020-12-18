<?php $title="Post New Question"; include('abstract-views/header.php');?>
<div class="col">
    <h1 class="h1 mb-3 font-weight-bold">Post New Question</h1>
    <form action="index.php" method="post">
        <input id="action" name="action" value="submit_question" type="hidden">
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
            <input id="name" name="name" type="text">
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
            <textarea id="body" name="body"></textarea>
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
            <input id="skills" name="skills" type="text">
            <br>
        </div>

        <div>
            <input class="btn btn-lg btn-primary mt-3" type="submit" value="Post New Question">
        </div>
    </form>
</div>
<?php include('abstract-views/footer.php');?>