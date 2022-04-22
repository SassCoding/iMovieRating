<?php
    session_start();
    require('connect.php');


    
    $searchTerm = $_SESSION['searchterm'];
    $searchQuery = "SELECT * FROM movie WHERE movie_name LIKE '%' :term '%'";
    $searchStatement = $db->prepare($searchQuery);
    $searchStatement->bindParam(':term', $searchTerm);
    $searchStatement->execute();
    $results = $searchStatement->fetchAll(); 

    $noResults = "";

    if($results == null)
    {
      $noResults = "No movies matched your search.";
    }

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
    <?php include('nav.php')?>
    <section class="bg-dark text-dark p-5 text-left">
    <H2 class="text-white text-center">Search Results For: <?=$searchTerm ?></H2>
      <div class="form_bg">
        <div class="container">
          <?php if($noResults != "") : ?>
            <h1 class="text-center"><?= $noResults ?></h1>
          <?php else : ?>
          <table class="table table-striped table-dark">
            <thead>
              <tr>
                <th scope="col">Movie Name</th>
                <th scope="col">Description</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($results as $result) : ?>
                <tr>
                  <td><a href="ratings.php?id=<?=$result['movie_id']?>"><?= $result['movie_name'] ?></a></td>
                  <td><?= $result['description'] ?></td>
                </tr>
              <?php endforeach ?>
            </tbody>
          </table>
        <?php endif ?>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</div>
</body>
</html>