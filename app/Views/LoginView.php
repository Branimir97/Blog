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
        <?php include 'css/loginview.css'; ?>
    </style>

    <title>Login</title>

</head>
<body>

<div class="jumbotron text-center pt-3 pb-3 text-white">
    <h1><strong>LOGIN </strong><i class="fas fa-sign-in-alt"></i></h1>
</div>

<?php if (isset($_SESSION['loggedIn']) && ($_SESSION['loggedIn'] === true)):?>

    <?php if (isset($_SESSION['admin_loggedIn']) && $_SESSION['admin_loggedIn'] == true): ?>

    <div class="text-center">
        <a href="/adminPanel"><i class="fas fa-long-arrow-alt-left"></i> Go back to Admin panel</a>
        <h6 class="mt-3">Successfully registrated new user.</h6>
    </div>


    <?php else: ?>
    <div class="text-center">
        <a href="/" class="text-center btn btn-info">LOGOUT FIRST <i class="fas fa-sign-out-alt"></i></a>
    </div>
    <?php endif; ?>

    <?php die();
        endif; ?>

<?php if (isset($registered)): ?>

    <div class="text-center bg-success p-3 mb-3 text-white"><?= $registered ?></div>

<?php endif; ?>

<?php if (isset($error)): ?>

    <div class="text-center bg-danger p-3 text-white mb-3"><?= $error; ?></div>

<?php endif; ?>

<div class="container">

    <a href="/"><i class="fas fa-long-arrow-alt-left"></i> Go back to homepage</a>

    <form action="login/authenticate" method="post">

        <div class="form-group">
            <label for="username-email"></label>
            <input type="text" name="username" id="username" class="form-control" placeholder="Username"
                   aria-describedby="helpId" required>
            <small id="helpId" class="text-muted">Here you need to enter username for your Blog account</small>
        </div>

        <div class="form-group">
            <label for="password"></label>
            <input type="password" name="password" id="password" class="form-control" placeholder="Password"
                   aria-describedby="helpId" required>
            <small id="helpId" class="text-muted">Here you need to enter password for your Blog account</small>
        </div>

        <div class="form-check">
            <label class="form-check-label">
                <input type="checkbox" class="form-check-input" name="remember_me" id="remember_me"
                       value="checkedValue">
                Remember me
            </label>
        </div>
        <button type="submit" name="submit" class="btn mt-3 login text-white">Login</button>
        <a role="button" href="/signup" class="btn mt-3 btn-secondary signup">Sign up</a>
    </form>
    <a href="/forgotPassword" class="btn btn-sm mt-2 forgot_password">Forgot your password?</a><br>
</div>


<?php
if (isset($_COOKIE['username']) && isset($_COOKIE['password'])) {
    $username = $_COOKIE['username'];
    $password = $_COOKIE['password'];

    echo "
            <script>
                document.getElementById('username').value = '{$username}';
                document.getElementById('password').value  = '{$password}';
                document.getElementById('remember_me').checked  = true;
            </script>
            ";
}
?>


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