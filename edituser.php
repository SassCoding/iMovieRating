<?php
    session_start();
    require('connect.php');

    // Select the user to be edited using GET from url.
    
        $userID = $_GET['id'];
    
        $selectQuery = "SELECT * FROM user WHERE user_id = :user_id";
        $selectStatement = $db->prepare($selectQuery);
        $selectStatement->bindValue(':user_id', $userID);
        $selectStatement->execute();
        $row = $selectStatement->fetch();

        if($_POST)
        {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $email = $_POST['email'];
                // Build the parameterized SQL query and bind to the above sanitized values.
        $updateQuery = "UPDATE user SET user_name = :user_name, email = :email, password = :password WHERE user_id = :user_id";
        $updateStatement = $db->prepare($updateQuery);
        $updateStatement->bindValue(':user_name', $username);  
        $updateStatement->bindValue(':email', $email);
        $updateStatement->bindValue(':password', $password); 
        $updateStatement->bindValue(':user_id', $userID); 


        $modifyCommand = $_POST['modifyCommand'];
        if($modifyCommand){
            $updateStatement->execute();

            header("Location: adminpanel.php");
            exit;
            }

            // Delete the selected user
            $deleteQuery = "DELETE FROM user WHERE user_id = :user_id";
            $deleteStatement = $db->prepare($deleteQuery);
            $deleteStatement->bindValue(':user_id', $userID);

            $deleteCommand = $_POST['deleteCommand'];
            if($deleteCommand){
            $deleteStatement->execute();

            header("Location: adminpanel.php");
            exit;
            }
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
    
    <title>iMovieRatings | Sign-Up</title>

</head>
<body>

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
    <main>
        <section class="bg-dark text-dark p-5 text-left">
            <div class="form_bg">
                <div class="container">
                    <form class="form_horizontal" method="post">
                        <div class="form_icon">
                            <i class="fa fa-user-circle"></i>
                        </div>
                            <h3 class="title">Edit User</h3>
                            <div class="form-group">
                                <label class="fs-3" for="Username">Edit Username</label>
                                <input type="text" class="form-control" name="username" type="text" value="<?=$row['user_name']?>">

                            </div>
                            <div class="form-group">
                                <h2>Edit Password</h2>
                                <input type="text" class="form-control" name="password" value="<?=$row['password']?>">

                            </div>
                            <div class="form-group">
                                <h2>Confirm Password</h2>
                                <input type="text" class="form-control" name="passwordConfirm" value="<?=$row['password']?>">

                            </div>
                            <div class="form-group">
                                <h2>Edit Email</h2>
                                <input type="text" class="form-control" name="email" value="<?=$row['email']?>">

                            </div>
                                <input class ="btn signin bg-light text-danger" type="submit" name="modifyCommand" value="Modify">
                                <input 
                                    class ="btn signin bg-danger text-light" 
                                    name="deleteCommand" 
                                    type="submit" 
                                    name="login" 
                                    value="Delete"
                                    onclick="return confirm('Are you sure you wish to delete this post?')">
                            </div>
                        </div>          
                    </form>
                </div>
            </div>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        </section>
    </main>
</body>