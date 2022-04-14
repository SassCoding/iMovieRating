<?php
    require('connect.php');
    require('authenticate.php');
    session_start();

    if ($_POST && !empty($_POST['content'])){
        $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
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
    <title>Create Page</title>
</head>
<body>
	<?php include('nav.php'); ?>

	<form method="post" class="row g-3 needs-validation" novalidate>
		<div class="col-md-4">
			<div class="input-group">
				<span class="input-group-text">Review</span>
				<textarea class="form-control" name="content" id="content" aria-label="Review" placeholder="Your Review Here.."></textarea>
			</div>
		</div>
		<div class="col-12">
			<input type="hidden" name="movieId" value="<?php echo $row['movie_id']?>" />
			<input type="submit" name="create" value="Create" />
		</div>
	</form>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>