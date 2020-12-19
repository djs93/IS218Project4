<!DOCTYPE html>
<html lang="en" style="height: 100%; margin: 0;">
<head>
    <meta charset="UTF-8">
    <title><?php echo($title);?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
</head>
<!-- the body section -->
<body class="text-center" style="height: 100%; margin: 0;">
    <div class="row justify-content-between align-content-center" style="border-bottom: 1px solid rgba(0,0,0,.1); background-color: rgba(0,0,0,0.05);">
        <div class="col-auto my-auto">
            <h3 class="ml-2 ">Project 3 - IS218</h3>
        </div>
        <?php if(!($action==='display_login')):?>
        <div class="col-auto">
            <a class="btn btn-md btn-secondary mt-1 mb-1 mr-2" href=".?action=logout">Log Out</a>
        </div>
        <?php endif;?>
    </div>
    <div class="row h-100">