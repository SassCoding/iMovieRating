<?php
    require('connect.php');
    require('authenticate.php');
    session_start();

    if ($_POST && !empty($_POST['content']))
    {
        $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
        if(!filter_input(INPUT_POST, 'content', FILTER_SANITIZE_FULL_SPECIAL_CHARS))
        {
            header("location:index.php");
        }

        $movie_id = $_SESSION['movieId'];

        $query = "INSERT INTO review (movie_id, content, user_id, author) VALUES (:movie_id, :content, :user_id, :author)";
        $statement = $db->prepare($query);

        $statement->bindValue(':content', $content);
        $statement->bindValue(':movie_id', $movie_id);
        $statement->bindValue(':user_id', $_SESSION['user_id']);
        $statement->bindValue(':author', $_SESSION['username']);

        $statement->execute();
        $redirect = "Location: ratings.php?id=".$movie_id;
        header($redirect);
        exit;
    }

    if(!empty($_POST['search']))
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

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Create Page</title>
</head>
<main>
    <?php include("nav.php");?>
    <section class="bg-dark text-dark p-5 text-left">
      <div class="form_bg">
        <div class="container">
        <form method="post" class="row g-3 needs-validation" novalidate style="justify-content: center;">
      <div class="col-md-4">
        <div class="input-group">
          <span class="input-group-text">Review</span>
          <textarea class="form-control" name="content" id="content" aria-label="Review"></textarea>
        </div>
        <input type="hidden" name="id" value="<?php echo $row['review_id']?>" />
        <input type="hidden" name="movieId" value="<?php echo $row['movie_id']?>" />
        <input type="hidden" name="movieId" value="<?php echo $row['movie_id']?>" />
		<input class="btn btn-success" type="submit" name="create" value="Create" />
      </div>
    </form>
          </div>  
      </div>       
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  </section>
</main>
</html>