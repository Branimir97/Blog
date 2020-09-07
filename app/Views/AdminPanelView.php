<?php
if(!isset($_SESSION['loggedIn_username']))

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

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
          integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <!-- FontAwesome -->
    <script src="https://kit.fontawesome.com/6aa1bd9ffa.js" crossorigin="anonymous"></script>

    <title>Admin Panel</title>

    <style>

        * {
            font-family: "Ubuntu Condensed", sans-serif;
        }

        a.logout, a.profile, a.home {
            float: right;
        }

        td img {
            width: 80px;
            height: 70px;
        }

        td img:hover {
            cursor: pointer;
            box-shadow: 0 0 2px 1px rgba(0, 140, 186, 0.5);
        }

    </style>
</head>
<body>
<div class="jumbotron text-center text-white bg-danger pt-3 pb-3">
    <h1><strong>ADMIN PANEL</strong></h1>

    <?php
    if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true):?>

        <p>You are logged in as <strong><?= $_SESSION['loggedIn_username'] ?></strong></p>

        <a role="button" class="btn btn-secondary logout" href="/home/logout">Logout <i class="fas fa-sign-out-alt"></i></a>

        <a role="button" class="btn btn-secondary home mr-1" href="/home"><i class="fas fa-house-damage"></i>
            Homepage</a>

    <?php endif; ?>

</div>

<div class="container-fluid">
    <a role="button" class="btn btn-success" href="/addNewPost">Create new post</a>
    <a role="button" class="btn btn-info" href="/addNewAdministrator">Add new administrator</a>

    <?php if ($posts == null): ?>

        <h6 class="mt-3 p-3 text-center">There are currently no posts. Here you can <a href="/addNewPost">create</a>
            first post for our Blog!</h6>

    <?php else: ?>


        <table class="table text-center mt-3">
            <caption>List of active posts</caption>
            <thead>
            <tr>
                <th>#</th>
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
                <tr>
                    <td><?= $post->getId() ?></td>
                    <td><?= $post->getTitle() ?></td>
                    <td><a href="<?= $post->getImgPath() ?>" target="_blank"><img src="<?= $post->getImgPath() ?>"></a>
                    </td>
                    <td>Administrator <strong><?= $post->getPostedBy() ?></strong></td>
                    <td><?= $post->getCreated() ?></td>
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
                        <a href="editPost/edit?id=<?= $post->getId() ?>" role="button" class="btn btn-success">
                            <i class="far fa-edit"></i>
                        </a>
                    </td>
                    <td>
                        <a href="comments/checkComments?id=<?= $post->getId() ?>" role="button" class="btn btn-info">
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