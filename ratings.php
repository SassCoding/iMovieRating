<?php
    require('connect.php');
    session_start();

    //Sanatize the ID
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    $_SESSION['movieId'] = $id;

    // Build the first query for the movie information.
    $querySelectMovie = "SELECT * FROM movie WHERE movie_id = :id";
    $selectMovieStatement = $db->prepare($querySelectMovie);
    $selectMovieStatement->bindValue(':id', $id, PDO::PARAM_INT);

    // Execute the SELECT and fetch the single row returned.
    $selectMovieStatement->execute();
    $rowQuery1 = $selectMovieStatement->fetch();

    //Build our second query for the reviews.
    $querySelectReview = "SELECT * FROM review WHERE movie_id = :id";
    $selectReviewStatement = $db->prepare($querySelectReview);
    $selectReviewStatement->bindValue(':id', $id, PDO::PARAM_INT);

    // Execute the SELECT and fetch the single row returned.
    $selectReviewStatement->execute();

    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
      $_SESSION['searchterm'] = $_POST['search'];
      header("location: search.php");
    }
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
    <?php include('nav.php')?>
    <main class="bg-info" style="height: 100vh;">
      <div class="container">
        <div class="panel panel-primary">
          <div class="panel-heading">
            <h3 class="panel-title"><?= $rowQuery1['movie_name'] ?></h3>
          </div>
          <div class="panel-body">
            <?= $rowQuery1['description'] ?>
          </div>
          <div class="panel-footer">
            <?php if($_SESSION): ?>
              <a href="create.php" class="btn btn-dark">Create Review</a>
            <?php endif ?>
            <?php if(!$_SESSION): ?>
              <a href="login.php" class="btn btn-dark">Login to Review</a>
            <?php endif ?>
          </div>
        </div>
      </div>
      <div class="list-group">
        <div class="container">
          <div class="row row-cols-1 row-cols-md-3">
            <?php while($rowQuery2 = $selectReviewStatement->fetch()): ?>
              <?php $user_id = $rowQuery2['user_id']; 
                //Build the third statement for profile pictures
                $querySelectImage = "SELECT * FROM profileimage WHERE user_id = :user_id";
                $selectImageStatement = $db->prepare($querySelectImage);
                $selectImageStatement->bindValue(':user_id', $user_id, PDO::PARAM_INT);
                $selectImageStatement->execute(); ?>
              <?php while($rowQuery3 = $selectImageStatement->fetch()):?>
                <div class="col">
                  <div class="card mt-5 ms-5 bg-danger text-black border-light" style="width: 18rem; height: 100%" id="card-git">
                    <img class="card-img-top" src="uploads/<?=$rowQuery3['image_name']?>" alt="Card image cap">
                    <div class="card-body">
                      <h5 class="card-title fs-3"><?= $rowQuery2['author'] ?></h5>
                      <p class="card-text text-light fs-5"><?=$rowQuery2['content']?></p>
                      <?php $userId = $rowQuery2['user_id']; if($_SESSION['user_id'] == $rowQuery2['user_id']): ?>
                        <a href="edit.php?id=<?= $rowQuery2['review_id'] ?>" class="btn btn-success">Edit</a>
                      <?php elseif($_SESSION['username'] == "admin"): ?>
                        <a href="edit.php?id=<?= $rowQuery2['review_id'] ?>" class="btn btn-success">Edit</a>
                      <?php endif ?>
                    </div>
                  </div>
                </div>
              <?php endwhile ?>
            <?php endwhile ?>
          </div>
        </div>
      </div>
</main>
</body>
</html>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>