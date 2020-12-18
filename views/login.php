<?php $title="Login"; include('abstract-views/header.php');?>
    <div class="col">
    <h1 class="h1 mb-3 font-weight-bold">Login</h1>
    <form action="index.php" method="post">
        <input id="action" name="action" value="validate_login" type="hidden">
        <div class="container alert alert-danger justify-content-center col-1" role="alert" <?php
            if($hasLogonError!=true){
                echo('style="display: none;"');
            }
        ?>>
            Invalid Login!
        </div>
        <div class="h3 mt-3 font-weight-normal">
            <label for="email">Email Address</label>
            <br>
            <input id="email" name="email" type="text" <?php
            if(!empty(filter_input(INPUT_GET, 'email'))){
                echo("value=".filter_input(INPUT_GET, 'email'));
            };?>>
            <br>
        </div>

        <div class="h3 mt-5 font-weight-normal">
            <label for="password">Password</label>
            <br>
            <input id="password" name="password" type="password">
            <br>
        </div>

        <div>
            <input class="btn btn-lg btn-primary mt-3" type="submit" value="Login">
        </div>
    </form>

    <form action="index.php" method="post">
        <input id="action" name="action" value="display_registration" type="hidden">
        <div>
            <input class="btn btn-secondary btn-lg mt-3" type="submit" value="Register">
        </div>
    </form>
    </div>
<?php include('abstract-views/footer.php');?>