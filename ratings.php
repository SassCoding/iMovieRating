<?php
    require('connect.php');
    session_start();

    //Sanatize the ID
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    $_SESSION['movieId'] = $id;

    // Build the first query for the movie information.
    $query = "SELECT * FROM movie WHERE movie_id = :id";
    $statement = $db->prepare($query);
    $statement->bindValue(':id', $id, PDO::PARAM_INT);

    // Execute the SELECT and fetch the single row returned.
    $statement->execute();
    $rowQuery1 = $statement->fetch();

    //Build our second query for the reviews.
    $query2 = "SELECT * FROM review WHERE movie_id = :id";
    $statement = $db->prepare($query2);
    $statement->bindValue(':id', $id, PDO::PARAM_INT);

    // Execute the SELECT and fetch the single row returned.
    $statement->execute();


?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Ratings Page</title>
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

    <div class="container">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"><?= $rowQuery1['movie_name'] ?></h3>
            </div>
            <div class="panel-body">
            <?= $rowQuery1['description'] ?>
            </div>
            <div class="panel-footer">
                <a href="create.php" class="btn btn-dark">Create Review</a>
            </div>
        </div>
    </div>
    <div class="list-group">
            
    <?php while($rowQuery2 = $statement->fetch()): ?>
        <a class="list-group-item list-group-item-action" aria-current="true">
        <div class="d-flex w-100 justify-content-between">
            <h5 class="mb-1"><?= $rowQuery2['user_id'] ?></h5>
            <p class="mb-1"><?= $rowQuery2['content'] ?></p>
            <small><?= $rowQuery2['date'] ?></small>
            <?php if($_SESSION['user_id'] == $rowQuery2['user_id']): ?>
                <a href="edit.php?id=<?= $rowQuery2['review_id'] ?>" class="btn btn-info">Edit</a>
            <?php elseif($_SESSION['username'] == "admin"): ?>
                <a href="edit.php?id=<?= $rowQuery2['review_id'] ?>" class="btn btn-info">Edit</a>
            <?php endif ?>
        </div>    
    <?php endwhile ?>


    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>