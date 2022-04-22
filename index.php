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
    <?php include 'footer.php'?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>