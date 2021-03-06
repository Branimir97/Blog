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
        <?php include 'css/admin_panel_view.css'; ?>
    </style>

    <title>Admin Panel</title>

</head>
<body>
<div class="jumbotron text-center pt-3 pb-3 mb-0 text-white">
    <h1><strong>ADMIN PANEL</strong></h1>

    <?php
    if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true):?>

        <p>You are logged in as <strong><?= $_SESSION['loggedIn_username'] ?></strong></p>

    <?php endif; ?>

</div>

<nav class="navbar navbar-expand-md bg-dark navbar-dark">
    <!-- Brand -->
    <a class="navbar-brand" href="/home">Homepage <i class="fas fa-house-damage ml-1"></i></a>

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

<div class="container-fluid">

    <?php if (isset($edited)): ?>

        <div class="text-center bg-success p-3 mt-3 text-white"><?= $edited ?></div>

    <?php endif; ?>

    <?php if ($posts == null): ?>

        <h6 class="mt-3 p-3 text-center">There are currently no posts. Here you can <a href="/addNewPost">create</a>
            first post for our Blog!</h6>

    <?php else: ?>

        <table class="table text-center mt-3">
            <caption>List of active posts</caption>
            <thead>
            <tr>
                <th>Jump</th>
                <th>Title</th>
                <th>Image thumbnail</th>
                <th>Posted by</th>
                <th>Created at</th>
                <th>Visibility</th>
                <th>Edit</th>
                <th>Comments</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($posts as $post): ?>

                <?php
                $mysqldate = $post->getCreated();
                $phpdate = strtotime($mysqldate);
                $myDateFormat = date('d. M Y. H:i:s', $phpdate);
                ?>

                <tr>
                    <td><a title="Jump to post <?= $post->getTitle() ?>" href="/postDetails/getPost?id=<?= $post->getId() ?>"><i class="fas fa-location-arrow"></i></a></td>
                    <td><?= $post->getTitle() ?></td>
                    <td><a href="<?= $post->getImgPath() ?>" target="_blank"><img src="<?= $post->getImgPath() ?>"></a>
                    </td>
                    <td>Administrator <strong><?= $post->getPostedBy() ?></strong></td>
                    <td><?= $myDateFormat ?></td>
                    <td>
                        <?php if ($post->getVisibility() == 1): ?>
                            <a href="adminPanel/changeVisibility?id=<?= $post->getId() ?>">
                                <i class="fas fa-eye"></i>
                            </a>
                        <?php else: ?>
                            <a href="adminPanel/changeVisibility?id=<?= $post->getId() ?>">
                                <i class="fas fa-eye-slash"></i>
                            </a>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="editPost/edit?id=<?= $post->getId() ?>" role="button" class="btn text-white edit_post">
                            <i class="far fa-edit"></i>
                        </a>
                    </td>
                    <td>
                        <a href="comments/getComments?id=<?= $post->getId() ?>" role="button" class="btn btn-primary">
                            <i class="fas fa-comment-dots"></i>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
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