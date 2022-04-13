<?php
    session_start();
    $_SESSION;
    require('connect.php');

    $selectMovie = "SELECT * FROM movie WHERE category_id = :category_id";
    $movieStatement = $db->prepare($selectMovie);
    $movieStatement->bindValue(':category_id', $_GET['id']);
    $movieStatement->execute();
    $movieRows = $movieStatement->fetchall();

    $selectCategory = "SELECT category_name FROM category WHERE category_id = :category_id";
    $categoryStatement = $db->prepare($selectCategory);
    $categoryStatement->bindValue(':category_id', $_GET['id']);
    $categoryStatement->execute();
    $categoryRow = $categoryStatement->fetch();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>iMovieRatings | Categories</title>

</head>
<body class="bg-dark">
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
    
    <section class="bg-dark text-dark p-5 text-left">
    <div class="container" id="movies">
        <div class="row">
            <H1 class="fs-1 fw-bold" style="text-align: center;"><?=$categoryRow['category_name'] ?></H1>
            <?php foreach ($movieRows as $movieRow) : ?>
                    <div class="col">
                        <div class="card" style="width: 15rem;">
                            <img src="images/starwars.png" alt="Star Wars" class="card-img-top">
                            <div class="card-body">
                                <h5 class="card-title"><?= $movieRow['movie_name']?></h5>
                                <p class="card-text"><?= $movieRow['description'] ?></p>
                                <a href="ratings.php?id=<?= $movieRow['movie_id'] ?>" class="btn btn-primary">View Ratings and Reviews</a>
                            </div>
                        </div>
                    </div>
            <?php endforeach ?>            
        </div>
    </div>
    </section>

    <!--Footer-->
    <div class="container bg-dark">
        <footer class="row row-cols-3 my-4 border-top">
            <div class="col">
                <a href="/" class="d-flex align-items-center mb-3 link-dark text-decoration-none">
                    <svg class="bi me-2" width="40" height="32"><use xlink:href="#bootstrap"/></svg>
                 </a>
                <p class="text-muted">&copy; 2021</p>
            </div>
    
            

            <div class="col">
                <h5 style="color: white;"">Movie Categories</h5>
                <ul class="nav flex-column">
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">Home</a></li>
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">Features</a></li>
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">Pricing</a></li>
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">FAQs</a></li>
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">About</a></li>
                </ul> 
            </div>
            
            <div class="col">
                <h5>User Links</h5>
                <ul class="nav flex-column">
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">Home</a></li>
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">Features</a></li>
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">Pricing</a></li>
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">FAQs</a></li>
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">About</a></li>
                </ul>
            </div>
        </footer>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</div>
</body>
</html>