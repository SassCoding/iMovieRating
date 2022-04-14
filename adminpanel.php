<?php
    session_start();
    require('connect.php');

    $selectQuery = "SELECT * FROM user";
    $selectStatement = $db->prepare($selectQuery);
    $selectStatement->execute();
    $selectStatement->fetch();

    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
	    $_SESSION['searchterm'] = $_POST['search'];
	    header("location: search.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="style.css">
    
    <title>iMovieRatings | Admin Panel</title>

</head>

<body>
  <?php include('nav.php') ?>
    <main>
      <section class="bg-dark text-dark p-5 text-left">
      <div class="form_bg">
        <div class="container">
          <table class="table table-striped table-dark">
            <thead>
              <tr>
                <th scope="col">User ID</th>
                <th scope="col">Username</th>
                <th scope="col">Email</th>
                <th scope="col">Modify</th>
              </tr>
            </thead>
            <tbody>
              <?php while($selectRow = $selectStatement->fetch()): ?>
                <tr>
                  <th scope="row" name="user_id"><?= $selectRow['user_id'] ?></th>
                    <td><?= $selectRow['user_name'] ?></td>
                    <td><?= $selectRow['email'] ?></td>
                    <a href="edituser.php?id=<?= $selectRow['user_id'] ?>" class="btn btn-info">Edit</a>  
                </tr>
              <?php endwhile ?>
            </tbody>
          </table>
          <a href="adduser.php" class="btn btn-success">Add User</a>
        </div>
      </section>
    </main>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

