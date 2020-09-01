<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
          integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <!-- FontAwesome -->
    <script src="https://kit.fontawesome.com/6aa1bd9ffa.js" crossorigin="anonymous"></script>

    <title>Edit post</title>

    <style>
        a.logout {
            float: right;
        }
    </style>
</head>
<body>
<div class="jumbotron text-center bg-warning">
    <h1>EDIT POST</h1>
    <?php
    if (isset($_SESSION['admin_loggedIn']) && $_SESSION['admin_loggedIn'] == true):?>

        <a role="button" class="btn btn-danger logout" href="/adminPanel/logout">Logout</a>

    <?php endif; ?>

</div>

<div class="container">
    <a href="/adminPanel"><i class="fas fa-long-arrow-alt-left"></i> Go back to admin panel</a>

    <?php if (isset($error)): ?>

        <div class="text-center bg-danger p-3 text-white"><?= $error; ?></div>

    <?php endif; ?>
<?php var_dump($postDetails);?>
    <form action="editPost/update" method="post" enctype="multipart/form-data">

        <div class="form-group">
            <label for="title"></label>
            <input type="text" name="title" id="title" class="form-control"
                   aria-describedby="helpId" value="">
            <small id="helpId" class="text-muted">Write some good title here</small>
        </div>

        <div class="form-group">
            <label for="content"></label>
            <textarea class="form-control" name="content" id="content" rows="3"></textarea>
            <small id="helpId" class="text-muted">Write some text for your post here</small>
        </div>

        <div class="form-group">
            <label for="post_image"></label>
            <input type="file" class="form-control-file" name="post_image" id="post_image" aria-describedby="fileHelpId">
            <small id="fileHelpId" class="form-text text-muted">Choose new photo, or just skip, old photo stays stored</small>
        </div>

        <button type="submit" name="submit" class="btn btn-warning">Update post</button>

    </form>
</div>


<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
        integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV"
        crossorigin="anonymous"></script>
</body>
</body>
</html>