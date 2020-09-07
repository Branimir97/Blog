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

    <title>Profile</title>

    <style>

        * {
            font-family: "Ubuntu Condensed", sans-serif;
        }

    </style>

</head>
<body>

<div class="jumbotron text-center bg-secondary text-white pt-3 pb-3">
    <h1><strong>CHANGE PASSWORD</strong></h1>

    <?php
    if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true):?>

        <p>You are logged in as <strong><?= $_SESSION['loggedIn_username'] ?></strong></p>

    <?php endif; ?>

</div>

<?php if (isset($error_password)): ?>

    <div class="text-center bg-danger p-3 text-white mb-3"><?= $error_password; ?></div>

<?php endif; ?>

<div class="container">

    <a href="/profile"><i class="fas fa-long-arrow-alt-left"></i> Go back to my profile</a>

    <form action="changePassword/change" method="POST">

        <div class="form-group">
            <label for="old_password"></label>
            <input type="password" name="old_password" id="old_password" class="form-control"
                   placeholder="Current password" aria-describedby="helpId" required>
            <small id="helpId" class="text-muted">Enter your current password</small>
        </div>

        <div class="form-group">
            <label for="new_password"></label>
            <input type="password" name="new_password" id="new_password" class="form-control" placeholder="New password"
                   aria-describedby="helpId" required>
            <small id="helpId" class="text-muted">Enter new password</small>
        </div>

        <div class="form-group">
            <label for="new_password2"></label>
            <input type="password" name="new_password2" id="new_password2" class="form-control"
                   placeholder="New password once more" aria-describedby="helpId" required>
            <small id="helpId" class="text-muted">Enter new password one more time</small>
        </div>

        <button type="submit" name="submit_password" class="btn btn-primary">Change password</button>
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