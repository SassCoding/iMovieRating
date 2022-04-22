<?php
    session_start();
    $_SESSION;
    require('connect.php');

    //Sanitize and validate inputs
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

    if(!filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT) || !filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT))
    {
      header("location: index.php");
    }

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
    <title>iMovieRatings | Categories</title>

</head>
<body class="bg-dark">
  <?php include('nav.php') ?>    
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
  <?php include 'footer.php'?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>