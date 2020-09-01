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

    <title>Homepage</title>

    <style>

        a.login
        {
            float: right;
        }
        .one_post
        {
            cursor: pointer;
        }

        .one_post:nth-child(odd)
        {
            background-color: darkorange;
        }

        .one_post:nth-child(even)
        {
            background-color: orangered;
        }

        .fake-img
        {
            height: 700px;
            background-color: gray;
        }

        .fake-img img
        {
            width: 100%;
            height: 100%;
        }
    </style>
</head>
<body>
<div class="jumbotron text-center bg-primary text-white mb-3">
    <h1>Homepage</h1>

    <?php
    if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true):?>

    <a role="button" class="btn btn-primary login" href="home/logout">Logout</a>
    <?php else:?>

    <a role="button" class="btn btn-primary login" href="/login">Login</a>
    <?php endif;?>

</div>
<div class="container">

    <?php foreach($posts as $post) :?>
    <div class="one_post text-center p-3 text-white mb-3" onclick="openPostDetails();">
        <h3 class="p-3"><?= $post->getTitle() ?></h3>
        <div class="fake-img">
            <img src="<?= $post->getImgPath()?>">

        </div>
        <p class="p-3"><?= $post->getContent() ?></p>
        <p>Posted by: <?= $post->getPostedBy() ?></p>
        <p>Blog post created at: <?= $post->getCreated() ?></p>
    </div>
    <?php endforeach; ?>

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


<script>
    function openPostDetails()
</script>
</html>