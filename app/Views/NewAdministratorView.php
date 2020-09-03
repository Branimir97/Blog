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

    <title>Add new administrator</title>
    <style>
        a.logout {
            float: right;
        }

        p.no_admins, p.no_users {
            font-weight: bold;
            color: darkred;
        }

        strong#disablePrivilegie
        {
            color: red;
        }

    </style>
</head>
<body>

<div class="jumbotron text-center text-white bg-info">
    <h1><strong>ADD NEW ADMINISTRATOR</strong></h1>

    <?php
    if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true):?>

        <p>You are logged in as <strong><?= $_SESSION['loggedIn_fullName']?></strong></p>

        <a role="button" class="btn btn-light logout" href="/home/logout">Logout</a>

    <?php endif; ?>


</div>

<div class="container">
    <a href="/adminPanel"><i class="fas fa-long-arrow-alt-left"></i> Go back to admin panel</a>

    <div class="row mt-3">

        <div class="col-sm-6 text-center">
            <h6>Current administrator list</h6>

            <?php
            if ($admins != null): ?>
                <table class="table">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Account created at</th>
                    <th>Remove privilegie</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($admins as $admin): ?>
                    <tr>
                        <td><?= $admin->getUsername(); ?></td>
                        <td><?= $admin->getCreated(); ?></td>
                        <td>

                            <?php if($admin->getUsername() !== $_SESSION['loggedIn_username'] ): ?>
                            <form action="/addNewAdministrator/changeRole" method="post">
                                <input type="hidden" name="id" value="<?= $admin->getId();?>">
                                <input type="hidden" name="role" value="admin">
                                <button type="submit" class="btn btn-danger" name="submit_changeRole">
                                    Unset admin <i class="fas fa-user-cog"></i>
                                </button>
                            </form>

                            <?php else: ?>
                                <h6><strong id="disablePrivilegie">Currently logged in</strong></h6>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach;?>
                </tbody>
                </table>
            <?php else:
                ?>
                <p class="no_admins mt-3">No admins</p>

            <?php endif; ?>
        </div>

        <div class="col-sm-6 text-center">
            <h6>Current users list</h6>
            <?php
            if ($users != null): ?>
                <table class="table">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Account created at</th>
                    <th>Add privilegie</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= $user->getUsername(); ?></td>
                        <td><?= $user->getCreated(); ?></td>
                        <td>
                            <form action="/addNewAdministrator/changeRole" method="post">
                                <input type="hidden" name="id" value="<?= $user->getId();?>">
                                <input type="hidden" name="role" value="user">
                                <button type="submit" class="btn btn-success" name="submit_changeRole">
                                    Set admin <i class="fas fa-user-cog"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach;?>
                </tbody>
                </table>
            <?php else:
                ?>
                <p class="no_users mt-3">No registered users</p>
            <?php endif; ?>
            <h6 class="mt-3"><a href="/signup" class="btn btn-warning" role="button">Register new user</a></h6>

        </div>
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