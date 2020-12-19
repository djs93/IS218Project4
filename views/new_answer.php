<?php $title="New Answer"; include('abstract-views/header.php');?>
<div class="col">
    <h1 class="h1 mb-3 font-weight-bold">New Answer</h1>
    <h2><i>You are answering question: <b><?php echo QuestionsDB::get_question($questionId)->getTitle();?></b></i></h2>
    <form action="index.php" method="post">
        <input id="action" name="action" value="new_answer" type="hidden">
        <input id="questionId" name="questionId" value="<?php echo($questionId);?>" type="hidden">

        <div class="container alert alert-danger justify-content-center col-1" role="alert" <?php
        if(empty($bodyError)){
            echo('style="display: none;"');
        }
        ?>>
            <?php echo($bodyError);?>
        </div>
        <div class="h3 <?php if(empty($bodyError)){echo "mt-5";}?> font-weight-normal">
            <label for="body">Answer Body</label>
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

        <div>
            <input class="btn btn-lg btn-primary mt-3" type="submit" value="Post Answer">
        </div>
    </form>
</div>
<?php include('abstract-views/footer.php');?>