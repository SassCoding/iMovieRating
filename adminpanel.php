<?php
    session_start();
    require('connect.php');

    $selectQuery = "SELECT * FROM user";
    $selectStatement = $db->prepare($selectQuery);
    $selectStatement->execute();
    $selectStatement->fetch();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="style.css">
    
    <title>iMovieRatings | Admin Panel</title>

</head>
<body>

<!-- NavBar -->
    <nav class="navbar navbar-expand-lg bg-dark navbar-dark">
        <div class="container">
            <a href="index.php" class="navbar-brand">iMovieRatings</a>
            <button 
                class="navbar-toggler" 
                type="button" 
                data-bs-toggle="collapse" 
                data-bs-target="#navmenu"
            >
                <span class="span-navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navmenu">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a href="index.php" class="nav-link">Home</a>
                    </li>
                    <li class="nav-item">
                        <a href="login.php" class="nav-link">Login</a>
                    </li>
                    <li class="nav-item">
                        <a href="#logout" class="nav-link">Logout</a>
                    </li>
                </ul>
                <input class = "search" type="text">
                <button type="button" class="btn btn-danger">Search</button>
                <button type="button" class="btn btn-danger">Enter a Movie</button>
            </div>
        </div>
    </nav> 
    <main>
        <section class="bg-dark text-dark p-5 text-left">
            <div class="form_bg">
                <div class="container">
                <table class="table table-striped table-dark">
                    <thead>
                        <tr>
                            <th scope="col">User ID</th>
                            <th scope="col">Username</th>
                            <th scope="col">Email</th>
                            <th scope="col">Modify</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($selectRow = $selectStatement->fetch()): ?>
                            <tr>
                                <th scope="row" name="user_id"><?= $selectRow['user_id'] ?></th>
                                <td><?= $selectRow['user_name'] ?></td>
                                <td><?= $selectRow['email'] ?></td>
                                <td>
                                <a href="edituser.php?id=<?= $selectRow['user_id'] ?>" class="btn btn-info">Edit</a>
                            </tr>
                        <?php endwhile ?>
                    </tbody>
                </table>
                <a href="adduser.php" class="btn btn-success">Add User</a>
            </div>
        </section>

    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

