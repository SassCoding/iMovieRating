<?php
    require('authenticate.php');
    require('connect.php');

    if($_POST && isset($_POST['content']) && isset($_POST['id'])){
        $movieId = $_POST['movieId'];
        $redirect = "Location: ratings.php?id=".$movieId;

        //Sanitization
        $review  = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    
        if(!filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT) || !filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT))
        {
          header("location: index.php");
        }

        // Build the parameterized SQL query and bind to the above sanitized values.
        $query     = "UPDATE review SET content = :content WHERE review_id = :id";
        $statement = $db->prepare($query);
        $statement->bindValue(':content', $review);  
        $statement->bindValue(':id', $id);  
        
        // Build the second statement
        $querydelete = "DELETE FROM review WHERE review_id = :id LIMIT 1";
        $statementDelete = $db->prepare($querydelete);
        $statementDelete->bindValue(':id', $id, PDO::PARAM_INT);

        // Delete if the button is pressed.
        $deleteCommand = $_POST['deleteCommand'];
        if($deleteCommand){
           $statementDelete->execute();

            header($redirect);
            exit;
        }
        
        // Execute the INSERT.
        $statement->execute(); 
        
        // Redirect after update.             
        header($redirect);
        exit;
    } else if (isset($_GET['id'])){
        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        $query = "SELECT * FROM review WHERE review_id = :id";
        $statement = $db->prepare($query);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();
        $row = $statement->fetch();
    } else {
        $id = false; 
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

    <title>Edit Page</title>
  </head>
  <body>
    <?php include('nav.php'); ?>
    <form method="post" class="row g-3 needs-validation" novalidate>
      <div class="col-md-4">
        <div class="input-group">
          <span class="input-group-text">Review</span>
          <textarea class="form-control" name="content" id="content" aria-label="Review"><?= $row['content'] ?></textarea>
        </div>
      </div>
      <div class="col-12">
        <input type="hidden" name="id" value="<?php echo $row['review_id']?>" />
        <input type="hidden" name="movieId" value="<?php echo $row['movie_id']?>" />
        <input type="submit" name="update" value="Update" />
        <input type="submit" name="deleteCommand" value="Delete" onclick="return confirm('Are you sure you wish to delete this post?')" />
      </div>
    </form>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>