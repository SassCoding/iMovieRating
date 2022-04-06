<?php
    session_start();
    require('connect.php');

    $_SESSION;

    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if($_POST && !empty($_POST['username']) && !empty($_POST['password']))
        {
            //Filter login information from the user.
            $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
            $password =  trim($_POST['password']);

            //Create select query, prepare, execute, and fetch.
            $selectQuery = "SELECT * FROM user WHERE user_name = :user_name";
            $selectStatement = $db->prepare($selectQuery);
            $selectStatement->bindParam(':user_name', $username);
            $selectStatement->execute();
            $selectRow = $selectStatement->fetch();   

            $user_id = $selectRow['user_id'];

            //Create select query to get the users profile image value
            //and store it in a session variable
            $findImageQuery = "SELECT * FROM profileimage WHERE user_id = :user_id";
            $findImageStatement = $db->prepare($findImageQuery);
            $findImageStatement->bindValue(':user_id', $user_id);
            $findImageStatement->execute();
            $imageRow = $findImageStatement->fetch();
            
            $validPassword = password_verify($password, $selectRow['password']);

            if($validPassword){
                $_SESSION["username"] = $selectRow["user_name"];
                $_SESSION["password"] = $selectRow["password"];
                $_SESSION["user_id"] = $selectRow["user_id"];
                $_SESSION["image_name"] = $imageRow["image_name"];

                header("Location: index.php");
            }
            else{
                $passwordError = "Username or Password is incorrect. Please try again.";
            }
        }
        if($_POST && empty($_POST['username'])){
            $userNameError = "Please enter a valid user name.";
        }
        if($_POST && empty($_POST['password'])){
            $passwordError = "Please enter a valid password.";
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
    
    <title>iMovieRatings | Login</title>

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
                        <div class="form_icon"><i class="fa fa-user-circle"></i></div>
                            <h3 class="title">Login Form</h3>
                            <div class="form-group">
                                <span class="input-icon"><i class="fa fa-user"></i></span>
                                <input type="text" class="form-control" name="username" type="text" placeholder="username">
                                <?php if(isset($userNameError)): ?>
                                    <p class="fs-5"><?= $userNameError ?></p>
                                <?php endif ?>
                            </div>
                            <div class="form-group">
                                <span class="input-icon"><i class="fa fa-lock"></i></span>
                                <input type="password" class="form-control" name="password" placeholder="password">
                                <?php if(isset($passwordError)): ?>
                                    <p class="fs-5"><?= $passwordError ?></p>
                                <?php endif ?>
                            </div>
                            <input class ="btn signin" type = "submit" name="login" value="Login">

                            <ul class="form-options">
                                <li><a href="#">Forgot Username/Password<i class="fa fa-arrow-right"></i></a></li>
                                
                                <li><a href="signup.php">Create New Account<i class="fa fa-arrow-right"></i></a></li>
                            </ul>
                        </div>          
                    </form>
                </div>
            </div>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        </section>
    </main>
</body>
