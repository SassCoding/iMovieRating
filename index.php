<?php
require('connect.php');

session_start();
$_SESSION;

$query = "SELECT * FROM movie WHERE category_id = 1";

$statement = $db->prepare($query);
$statement->execute();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>iMovieRatings</title>

</head>
<body>
    <!-- NavBar -->
    <nav class="navbar navbar-expand-lg bg-dark navbar-dark">
        <div class="container">
            <a href="#" class="navbar-brand">iMovieRatings</a>
            <button 
                class="navbar-toggler" 
                type="button" 
                data-bs-toggle="collapse" 
                data-bs-target="#navmenu"
            >
             <span class="span-navbar-toggler-icon"><i class="bi bi-list"></i></span>
            </button>

            <div class="collapse navbar-collapse" id="navmenu">
                <ul class="navbar-nav ms-auto">
                    <?php if($_SESSION['username']): ?>
                        <p class="text-light">Hello, <?= $_SESSION['username'] ?></p>
                        <li class="nav-item">
                            <a href="logout.php" class="nav-link">Logout</a>
                        </li>
                    <?php else : ?>
                        <li class="nav-item">
                            <a href="login.php" class="nav-link">Login</a>
                        </li>
                    <?php endif ?>
                    <?php if($_SESSION['username'] == "admin"): ?>
                        <li class="nav-item">
                            <a href="adminpanel.php" class="nav-link">Admin Panel</a>
                        </li>
                    <?php endif ?>
                </ul>
                <input class = "search" type="text">
                <button type="button" class="btn btn-danger">Search</button>
                <button type="button" class="btn btn-danger">Enter a Movie</button>
            </div>
        </div>
    </nav> 
    
    <section class="bg-dark text-dark p-5 text-left">
    <div class="container-2">
        <h3>Most Popular Movies Right Now</h3>
        <div class="row">            
            
        <?php while($row = $statement->fetch()): ?>
                <div class="col-4">
                    <div class="card">
                        <img src="images/starwars.png" alt="Star Wars" class="card-img-top">
                        <starwars></starwars>
                        <div class="card-body">
                            <h5 class="card-title"><?= $row['movie_name']?></h5>
                            <p class="card-text"><?= $row['description'] ?></p>
                            <a href="ratings.php?id=<?= $row['movie_id'] ?>" class="btn btn-primary">View Ratings and Reviews</a>
                        </div>
                    </div>
                </div>
            <?php endwhile ?>
            
        </div>
    </div>
    </section>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</div>
</body>
</html>