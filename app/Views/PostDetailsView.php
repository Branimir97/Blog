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
        <?php include 'css/post_details_view.css'; ?>
    </style>

    <title><?= $postDetails->getTitle() ?></title>

</head>
<body>

<div class="jumbotron pt-3 pb-3 text-center text-white mb-0">
    <h1><strong>Branimir's BLOG</strong></h1>

    <?php
    if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true):?>

        <p>You are logged in as <strong><?= $_SESSION['loggedIn_username'] ?></strong></p>

    <?php endif; ?>

</div>

<nav class="navbar navbar-expand-md bg-dark navbar-dark">
    <!-- Brand -->
    <a class="navbar-brand" href="/">Homepage <i class="fas fa-house-damage ml-1"></i></a>

    <!-- Toggler/collapsibe Button -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
        <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Navbar links -->
    <div class="collapse navbar-collapse" id="collapsibleNavbar">
        <ul class="navbar-nav ml-auto">

            <?php if (isset($_SESSION['admin_loggedIn']) && $_SESSION['admin_loggedIn'] == true): ?>
                <li class="nav-item">
                    <a class="nav-link" href="/adminPanel">Admin panel <i class="fas fa-users-cog"></i></a>
                </li>
            <?php endif; ?>

            <?php if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true):?>
                <li class="nav-item">
                    <a class="nav-link" href="/profile">My profile <i class="fas fa-user-cog"></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="home/logout">Logout <i class="fas fa-sign-out-alt"></i></a>
                </li>

            <?php else: ?>
                <li class="nav-item">
                    <a class="nav-link" href="/login">Login <i class="fas fa-sign-in-alt"></i></a>
                </li>
            <?php endif; ?>

        </ul>
    </div>
</nav>

<div class="container">
    <?php
    $mysqldate = $postDetails->getCreated();
    $phpdate = strtotime($mysqldate);
    $myDateFormat = date('d. M Y. H:i:s', $phpdate);
    ?>

    <h1 class="text-center title mt-3"><?= $postDetails->getTitle() ?></h1>
    <p class="text-center mt-3 date"><?= $myDateFormat ?></p>
    <div class="fake-img">
        <img src="<?= '../' . $postDetails->getImgPath() ?>">
    </div>

    <p class="introduction mt-3">Introduction</p>
    <h6 class=""><?= html_entity_decode($postDetails->getIntro()) ?></h6>

    <p class="introduction mt-3">Content</p>
    <p><?= html_entity_decode($postDetails->getContent()) ?></p>

    <div id="comments" class="mb-3">

        <?php if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true): ?>
            <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample"
                    aria-expanded="false" aria-controls="collapseExample">
                <i class="far fa-comment"></i> Leave a comment
            </button>
        <?php else: ?>

            <h6 class="loggedOut">* You need to be logged in for posting your comments.</h6>
        <?php endif; ?>

        <div class="collapse" id="collapseExample">
            <div class="card card-body">
                <form action="postComment?id=<?= $postDetails->getId() ?>" method="POST">

                    <div class="form-group">
                        <label for="content"></label>
                        <textarea class="form-control" name="content" id="content"
                                  placeholder="This is so beautiful website, right?" rows="6" required></textarea>
                        <small id="helpId" class="text-muted">Write your comment here</small>
                    </div>

                    <button type="submit" name="submit_comment" class="btn btn-sm btn-success">
                        Post comment
                    </button>
                </form>
            </div>
        </div>

        <?php if ($commentsDetails != null): ?>

            <?php foreach ($commentsDetails as $comment): ?>

                <?php
                $mysqldate = $comment->getCreated();
                $phpdate = strtotime($mysqldate);
                $myDateFormat = date('d. M Y. H:i:s', $phpdate);
                ?>

                <div class="one_comment p-3 mt-3">
                    <p>By: <strong><?= $comment->getPostedBy() ?></strong> at
                        <strong><?= $myDateFormat ?></strong></p>
                    <h6><?= $comment->getContent() ?></h6>
                </div>

            <?php endforeach; ?>
        <?php else: ?>
            <h6 class="no_comments mt-2 p-2">No comments yet. Be first who'll comment this post.</h6>
        <?php endif; ?>
    </div>
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