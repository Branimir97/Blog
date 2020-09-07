<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="icon" href="Uploaded_images/logo.png">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
          integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <!-- FontAwesome -->
    <script src="https://kit.fontawesome.com/6aa1bd9ffa.js" crossorigin="anonymous"></script>

    <title>Create new post</title>

    <style>
        * {
            font-family: "Ubuntu Condensed", sans-serif;
        }

        span {
            font-size: 11px;
            color: red;
        }
    </style>
</head>
<body>
<div class="jumbotron text-center text-white bg-success pt-3 pb-3">
    <h1><strong>CREATE NEW POST</strong></h1>

    <?php
    if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true):?>

        <p>You are logged in as <strong><?= $_SESSION['loggedIn_username'] ?></strong></p>

    <?php endif; ?>

</div>

<div class="container">
    <a href="/adminPanel"><i class="fas fa-long-arrow-alt-left"></i> Go back to admin panel</a>

    <?php if (isset($error)): ?>
        <div class="text-center bg-danger p-3 text-white"><?= $error; ?></div>
    <?php endif; ?>

    <?php if (isset($postCreated)): ?>
        <div class="text-center bg-success p-3 text-white"><?= $postCreated; ?></div>
    <?php endif; ?>

    <form action="addNewPost/store" method="post" enctype="multipart/form-data">

        <div class="form-group">
            <label for="title"></label>
            <input type="text" name="title" id="title" class="form-control" placeholder="Post tittle"
                   aria-describedby="helpId" required>
            <small id="helpId" class="text-muted">Write some good title here</small>
        </div>

        <div class="form-group">
            <label for="intro"></label>
            <textarea class="form-control" name="intro" id="intro" placeholder="Post introduction" rows="3"
                      required></textarea>
            <small id="helpId" class="text-muted">Write some good text to attract people open your post</small>
        </div>

        <div class="form-group">
            <label for="content"></label>
            <textarea class="form-control" name="content" id="content" placeholder="Post content" rows="6"
                      required></textarea>
            <small id="helpId" class="text-muted">Write some text for your post here</small>
        </div>

        <div class="form-group">
            <label for="post_image"></label>
            <input type="file" class="form-control-file" name="post_image" id="post_image" aria-describedby="fileHelpId"
                   required>
            <small id="fileHelpId" class="form-text text-muted">Pick some good photo for your post</small>
        </div>

        <div class="form-check">
            <label class="form-check-label mb-3">
                <input type="checkbox" class="form-check-input" name="post_visibility" id="post_visibility">
                Make your post invisible
                <br>
                <span><sup>*</sup> As default your post will be visible</span>
            </label>
        </div>

        <button type="submit" name="submit" class="btn btn-success mb-3">Create new post</button>

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
</html>