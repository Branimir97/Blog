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
        <?php include 'css/forgot_password_view.css'; ?>
    </style>

    <title>Recover</title>

</head>
<body>

<div class="jumbotron text-center pt-3 pb-3 text-white">
    <h1><strong>RECOVER </strong><i class="fas fa-splotch"></i></h1>
</div>

<div class="container">
    <a href="/login"><i class="fas fa-long-arrow-alt-left"></i> Go back to login page</a>

    <h6 class="text-center mt-3">If you have forgotten your password, don't worry.
        Here is the way to get it back. In form below,
        place your username or e-mail address which you used for your
        Blog account registration.
    </h6>

    <?php if(isset($recover_error)): ?>

        <h6 class="text-center bg-danger text-white p-3"><?= $recover_error ?></h6>

    <?php endif; ?>

    <form action="forgotPassword/recover" method="post">

        <div class="form-group">
            <label for="username_email"></label>
            <input type="text" name="username_email" id="username_email" class="form-control" placeholder="Username / E-mail"
                   aria-describedby="helpId" required>
            <small id="helpId" class="text-muted">Here you need to enter username or email for your Blog account</small>
        </div>

        <button type="submit" name="submit_recover" class="btn text-white reminder">Recover</button>
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