<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Icon -->
    <link rel="icon" href="Uploaded_images/logo.png">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
          integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <!-- FontAwesome -->
    <script src="https://kit.fontawesome.com/6aa1bd9ffa.js" crossorigin="anonymous"></script>

    <!-- Stylesheet -->
    <style>
        <?php include 'css/homeview.css'; ?>
    </style>

    <title>Branimir's Blog</title>

</head>
<body>
<div class="jumbotron text-center pt-3 pb-3 mb-0 text-white">
    <h1><strong>Branimir's Blog</strong></h1>

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
    <div class="container">

        <?php if ($posts == null): ?>

            <h6 class="mt-3 p-3 text-center">There are currently no posts on our Blog. Please check back later.</h6>

        <?php endif; ?>

        <?php foreach ($posts as $post) : ?>
            <div class="one_post p-3 mb-3 mt-5">
                <h4 class="p-3"><?= $post->getTitle() ?></h4>
                <div class="fake-img">
                    <a href="/postDetails/getPost?id=<?= $post->getId() ?>"><img src="<?= $post->getImgPath() ?>"></a>
                </div>

                <?php
                    $mysqldate = $post->getCreated();
                    $phpdate = strtotime($mysqldate);
                    $myDateFormat = date('d. M Y. H:i:s', $phpdate);
                ?>

                <p class="postedBy p-2 mb-0">By: <strong><?= $post->getPostedBy() ?></strong>, <?= $myDateFormat ?>
                </p>
                <div class="p-2">
                    <p class="intro"><?= html_entity_decode($post->getIntro()) ?></p>
                </div>
                <a class="btn btn-sm btn-primary" href="/postDetails/getPost?id=<?= $post->getId() ?>">READ MORE</a>

                <?php if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true): ?>
                    <a class="btn btn-sm btn-success" href="/postDetails/getPost?id=<?= $post->getId() ?>#comments">COMMENT</a>
                <?php endif; ?>

            </div>
        <?php endforeach; ?>
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