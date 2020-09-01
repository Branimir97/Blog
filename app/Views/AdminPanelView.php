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
        a.logout{
            float: right;
        }

        strong
        {
            color: darkred;
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="jumbotron text-center text-white bg-info">
    <h1>ADMIN PANEL</h1>

    <?php
    if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true):?>

        <a role="button" class="btn btn-danger logout" href="home/logout">Logout</a>
        <p>Prijavljeni ste kao <strong><?= $_SESSION['loggedIn_username']?></strong></p>
    <?php endif;?>

</div>

<div class="container-fluid">
    <a role="button" class="btn btn-info" href="/addNewPost">Create new post</a>
    <a role="button" class="btn btn-primary" href="/addNewAdministrator">Add new administrator</a>
    <table class="table text-center mt-3">
        <caption>List of posts</caption>
        <thead>
            <tr>
                <th>#</th>
                <th>Title</th>
                <th>Image path</th>
                <th>Content</th>
                <th>Posted by</th>
                <th>Created at</th>
                <th>Visibility</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($posts as $post):?>
               <tr>
                   <td><?= $post->getId() ?></td>
                   <td><?= $post->getTitle() ?></td>
                   <td><?= $post->getImgPath() ?></td>
                   <td><?= $post->getContent() ?></td>
                   <td>Administrator <strong><?= $post->getPostedBy() ?></strong></td>
                   <td><?= $post->getCreated() ?></td>
                   <td><a role="button" href="#" class="btn btn-light"> <i class="fas fa-eye-slash"></i></a></td>
                   <td><a role="button" href="editPost/edit?id=<?=$post->getId()?>" class="btn btn-success"><i class="far fa-edit"></i></a></td>
                   <td>
                       <a role="button" class="btn btn-danger"
                          data-toggle="modal" data-target="#exampleModalCenter">
                           <i class="far fa-trash-alt"></i></a>

                       <!-- Modal -->
                       <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                           <div class="modal-dialog modal-dialog-centered" role="document">
                               <div class="modal-content">
                                   <div class="modal-header">
                                       <h5 class="modal-title" id="exampleModalLongTitle">Deleting post#5</h5>
                                       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                           <span aria-hidden="true">&times;</span>
                                       </button>
                                   </div>
                                   <div class="modal-body">
                                       Are you sure you want to delete this post?
                                   </div>
                                   <div class="modal-footer">
                                       <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                       <a role="button" href="adminPanel/delete/<?=$post->getId()?>" class="btn btn-danger">Delete</a>
                                   </div>
                               </div>
                           </div>
                       </div>
                   </td>
               </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
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