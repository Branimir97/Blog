<?php
if (!isset($_SESSION['loggedIn_username']))

    return new \Controllers\Controller404();

?>

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

    <!-- Stylesheet -->
    <style>
        <?php include 'css/edit_post_view.css'; ?>
    </style>

    <title>Edit post</title>

</head>
<body>
<div class="jumbotron text-center text-white pt-3 pb-3 mb-0">
    <h1><strong>EDIT POST</strong></h1>

    <?php
    if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true):?>

        <p>You are logged in as <strong><?= $_SESSION['loggedIn_username'] ?></strong></p>

    <?php endif; ?>

</div>

<nav class="navbar navbar-expand-md bg-dark navbar-dark mb-4">
    <!-- Brand -->
    <a class="navbar-brand" href="/adminPanel">Admin panel <i class="fas fa-user-shield ml-1"></i></a>

    <!-- Toggler/collapsibe Button -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
        <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Navbar links -->
    <div class="collapse navbar-collapse" id="collapsibleNavbar">
        <ul class="navbar-nav ml-auto">

            <?php if (isset($_SESSION['admin_loggedIn']) && $_SESSION['admin_loggedIn'] == true): ?>
                <li class="nav-item">
                    <a class="nav-link" href="/addNewPost">Create new post <i class="far fa-file-alt"></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/addNewAdministrator">Add new administrator <i
                                class="fas fa-users-cog"></i></a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="/profile">My profile <i class="fas fa-user-cog"></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="home/logout">Logout <i class="fas fa-sign-out-alt"></i></a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>

<div class="container">

    <?php if (isset($error)): ?>

        <div class="text-center bg-danger p-3 text-white mb-3"><?= $error; ?></div>

    <?php endif; ?>

    <button type="submit" name="submit_delete"
            data-toggle="modal" data-target="#exampleModalCenter"
            class="btn btn-danger delete mb-3">Delete post
    </button>

    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Really?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this post?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel
                    </button>
                    <a href="delete?id=<?= $postDetails->getId() ?>" role="button"
                       class="btn btn-danger">Delete</a>
                </div>
            </div>
        </div>
    </div>
    <form action="update?id=<?= $postDetails->getId() ?>" method="post" enctype="multipart/form-data">

        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" class="form-control"
                   aria-describedby="helpId" value="<?= $postDetails->getTitle() ?>">
            <small id="helpId" class="text-muted">Write some good title here</small>
        </div>

        <div class="form-group">
            <label for="intro">Introduction</label>
            <textarea class="form-control" name="intro" id="intro" placeholder="Post introduction" rows="3"
                      required><?= html_entity_decode($postDetails->getIntro()) ?></textarea>
            <small id="helpId" class="text-muted">Write some good text to attract people open your post</small>
        </div>

        <div class="form-group">
            <label for="content">Content</label>
            <textarea class="form-control" name="content" id="content" placeholder="Post content" rows="6"
                      required><?= html_entity_decode($postDetails->getContent()) ?></textarea>
            <small id="helpId" class="text-muted">Write some text for your post here</small>
        </div>

        <div>
            <h6>Current photo</h6>
            <img src="<? $postDetails->getImgPath() ?>">
            <?php echo $postDetails->getImgPath() ?>
        </div>
        <div class="form-group">
            <label for="post_image"></label>
            <input type="file" class="form-control-file" name="post_image" id="post_image"
                   aria-describedby="fileHelpId">
            <small id="fileHelpId" class="form-text text-muted">Choose new photo, or just skip, old photo stays
                stored</small>
        </div>

        <button type="submit" name="submit_update" class="btn text-white edit_post mb-3">Edit post</button>

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