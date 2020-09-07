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

    <title>Profile</title>

    <style>

        * {
            font-family: "Ubuntu Condensed", sans-serif;
        }

        h5 {
            text-decoration: underline;
        }

        .delete, .change_password {
            float: right;
        }

        .one_entity {
            background-color: lightgrey;
            border-left: 5px solid darkgrey;
        }

        .one_entity p {
            font-size: 11px;
            color: dodgerblue;
        }

        .one_entity h6 {
            margin-left: 15px;
        }

    </style>

</head>
<body>

<div class="jumbotron text-center bg-secondary text-white pt-3 pb-3">
    <h1><strong>MY PROFILE</strong></h1>

    <?php
    if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true):?>

        <p>You are logged in as <strong><?= $_SESSION['loggedIn_username'] ?></strong></p>

    <?php endif; ?>


</div>

<?php
if (isset($changedPassword)):
    ?>
    <div class="text-center bg-success p-3 mb-3 text-white"><?= $changedPassword ?></div>

<?php endif; ?>

<div class="container mb-3">
    <a href="/home"><i class="fas fa-long-arrow-alt-left"></i> Go back to homepage</a>

    <a role="button" class="btn btn-danger delete"
       data-toggle="modal" data-target="#exampleModalCenter">Delete account
    </a>

    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Account delete</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete your account?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel
                    </button>
                    <a href="profile/delete" role="button"
                       class="btn btn-danger">Delete</a>
                </div>
            </div>
        </div>
    </div>

    <a href="/changePassword" class="btn btn-info change_password mr-1">Change password</a>

    <h5 class="mt-3">Account details</h5>

    <div class="one_entity p-3 mt-3">
        <p>Username:
        <p>
        <h6></t><?= $userDetails->getUsername() ?></h6>
    </div>

    <div class="one_entity p-3 mt-3">
        <p>First name:
        <p>
        <h6></t><?= $userDetails->getFirstName() ?></h6>
    </div>

    <div class="one_entity p-3 mt-3">
        <p>Last name:
        <p>
        <h6></t><?= $userDetails->getLastName() ?></h6>
    </div>

    <div class="one_entity p-3 mt-3">
        <p>Email address:
        <p>
        <h6></t><?= $userDetails->getEmail() ?></h6>
    </div>

    <div class="one_entity p-3 mt-3">
        <p>Role:
        <p>
        <h6><?= $userDetails->getRole() ?></h6>
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