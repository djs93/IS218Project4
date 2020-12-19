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
            </ul>
        </nav>
    </div>
    <div class="col">
        <div class="row justify-content-md-center mt-5">
            <table class="col-10 table table-striped table-bordered">
                <tr>
                    <th>Question Title</th>
                    <th>Quesiton Body</th>
                    <th>View Details</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
                <?php foreach ($questions as $question) : ?>
                    <tr>
                        <td><?php echo $question->getTitle(); ?></td>
                        <td><?php echo $question->getBody(); ?></td>
                        <td>
                            <form action="index.php" method="post">
                                <input id="action" name="action" value="show_question_single" type="hidden">
                                <input id="questionId" name="questionId" value="<?php echo $question->getId();?>" type="hidden">
                                <div>
                                    <input class="btn btn-secondary btn-sm" type="submit" value="View">
                                </div>
                            </form>
                        </td>
                        <td>
                            <form action="index.php" method="post">
                                <input id="action" name="action" value="display_edit_question" type="hidden">
                                <input id="questionId" name="questionId" value="<?php echo $question->getId();?>" type="hidden">
                                <div>
                                    <input class="btn btn-secondary btn-sm" type="submit" value="Edit">
                                </div>
                            </form>
                        </td>
                        <td>
                            <form action="index.php" method="post">
                                <input id="action" name="action" value="delete_question" type="hidden">
                                <input id="questionID" name="questionID" value="<?php echo $question->getId();?>" type="hidden">
                                <div>
                                    <input class="btn btn-secondary btn-sm" type="submit" value="Delete">
                                </div>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>

<?php include('abstract-views/footer.php');?>