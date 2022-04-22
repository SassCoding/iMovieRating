<?php
require('connect.php');

session_start();
$_SESSION;

$counter = 0;

$statement = "SELECT category_id, category_name FROM category;";
$statement = $db->prepare($statement);
$statement->execute();
$categories = $statement->fetchAll();

$statement = "SELECT * FROM movie ORDER BY rand()";
$statement = $db->prepare($statement);
$statement->execute();
$movies = $statement->fetchAll();

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $searchTerm = filter_input(INPUT_POST, 'search', FILTER_SANITIZE_SPECIAL_CHARS);
      
    if(!filter_input(INPUT_POST, 'search', FILTER_SANITIZE_SPECIAL_CHARS))
    {
        header("location: index.php");
    }
    else
    {
        $_SESSION['searchterm'] = $searchTerm;
        header("location: search.php");
    }
}

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
<body class="bg-dark">
	<?php include 'nav.php'?>
    <section class="bg-dark text-dark p-5 text-left">
    	<div class="container" id="movies">
				<div class="row">
        	<h1 class="text-center text-light">Welcome to iMovieRatings - Select a category of movies!</h1>
					<?php foreach ($categories as $category) : ?>
						<?php $counter = 0 ?>
						<div>
							<a class ="text-dark text-center" href="category.php?id=<?=$category['category_id']?>"><h1 class="category-head"><?= $category['category_name'] ?></h1></a>
            </div>
            <?php foreach ($movies as $movie) : ?>
							<?php if($category['category_id'] === $movie['category_id'] && $counter < 3) : ?>
								<div class="col">
									<div class="card" style="width: 15rem; height: 40rem;">
										<img src="images/starwars.png" alt="Star Wars" class="card-img-top mt-5">
										<div class="card-body">
											<h5 class="card-title text-danger" style="font-weight: bolder;"><?= $movie['movie_name']?></h5>
											<p class="card-text"><?= $movie['description'] ?></p>
											<a href="ratings.php?id=<?= $movie['movie_id'] ?>" class="btn btn-primary">View Ratings and Reviews</a>
										</div>
									</div>
								</div>
								<?php $counter++?>
							<?php endif ?>
						<?php endforeach ?>  
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
					<p class="text-muted">&copy; 2022</p>
				</div>            

            <div class="col">
            <h5>User Links</h5>
                <ul class="nav flex-column">
                    <li class="nav-item mb-2"><a href="index.php" class="nav-link p-0 text-muted">Home</a></li>
                    <li class="nav-item mb-2"><a href="userpanel.php?id=<?=$_SESSION['user_id']?>" class="nav-link p-0 text-muted">User Settings</a></li>
                </ul>
            </div>
            
            <div class="col">
            <h5 style="color: white;">Movie Categories</h5>
                <ul class="nav flex-column">
                    <li class="nav-item mb-2"><a href="category.php?id=1" class="nav-link p-0 text-muted">Science Fiction</a></li>
                    <li class="nav-item mb-2"><a href="category.php?id=2" class="nav-link p-0 text-muted">Comedy</a></li>
                    <li class="nav-item mb-2"><a href="category.php?id=3" class="nav-link p-0 text-muted">Romantic</a></li>
                    <li class="nav-item mb-2"><a href="category.php?id=4" class="nav-link p-0 text-muted">Action</a></li>
                    <li class="nav-item mb-2"><a href="category.php?id=5" class="nav-link p-0 text-muted">Christmas</a></li>
                    <li class="nav-item mb-2"><a href="category.php?id=6" class="nav-link p-0 text-muted">Halloween</a></li>
                    <li class="nav-item mb-2"><a href="category.php?id=7" class="nav-link p-0 text-muted">Drama</a></li>
                    <li class="nav-item mb-2"><a href="category.php?id=8" class="nav-link p-0 text-muted">Documentary</a></li>
                </ul> 
            </div>
        </footer>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>