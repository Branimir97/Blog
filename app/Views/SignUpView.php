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


    <title>Sign up</title>

    <style>

        *
        {
            font-family: "Ubuntu Condensed", sans-serif;
        }

    </style>
</head>
<body>

    <div class="jumbotron text-center text-white bg-secondary pt-3 pb-3">
        <h1><strong>SIGN UP </strong><i class="fas fa-user-plus"></i></h1>
    </div>

    <?php if(isset($error)):?>

        <div class="text-center bg-danger p-3 mb-3 text-white"><strong><?= $error;?></strong></div>

    <?php endif; ?>
    <div class="container">

        <a href="/login"><i class="fas fa-long-arrow-alt-left"></i> Go back to login page</a>

        <form action="signup/create" method="post">

            <div class="form-group">
                <label for="username"></label>
                <input type="text" name="username" id="username" class="form-control" placeholder="Username" aria-describedby="helpId" required>
                <small id="helpId" class="text-muted">Here you need to enter username for our Blog</small>
            </div>

            <div class="form-group">
                <label for="first_name"></label>
                <input type="text" name="first_name" id="first_name" class="form-control" placeholder="First name" aria-describedby="helpId" required>
                <small id="helpId" class="text-muted">Here you need to enter your first name</small>
            </div>

            <div class="form-group">
                <label for="last_name"></label>
                <input type="text" name="last_name" id="last_name" class="form-control" placeholder="Last name" aria-describedby="helpId" required>
                <small id="helpId" class="text-muted">Here you need to enter your last name</small>
            </div>

            <div class="form-group">
                <label for="email"></label>
                <input type="text" name="email" id="email" class="form-control" placeholder="Email address" aria-describedby="helpId" required>
                <small id="helpId" class="text-muted">Here you need to enter your email address</small>
            </div>

            <div class="form-group">
                <label for="password"></label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Password" aria-describedby="helpId" required>
                <small id="helpId" class="text-muted">Here you need to enter some good password</small>
            </div>

            <button type="submit" name="submit" class="btn btn-primary">Sign up</button>
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