<?php
    session_start();
    require('connect.php');
    
    if($_SERVER["REQUEST_METHOD"] == "POST")
        {
        if($_POST && !empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['passwordConfirm']) && !empty($_POST['email']))
        { 
            // Filter and set variables.
            $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $password = $_POST['password'];
            $passwordConfirm = filter_input(INPUT_POST, 'passwordConfirm', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);

            //Check for duplicate users in our database.
            // $selectQuery = "SELECT count(*) as total from user WHERE email = '$email' OR user_name = '$username'";
            // $selectStatement = $db->prepare($selectQuery);
            // $selectStatement->bindValue(':username', $username);
            // $selectStatement->bindValue(':email', $email);
            // $selectStatement->execute();

            // If passwords match, exectue the database insert of the new user.
            if($_POST['password'] == $_POST['passwordConfirm'])
            {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $insertQuery = "INSERT INTO user (user_name, password, email) VALUES (:username, :password, :email)";

                $insertStatement = $db->prepare($insertQuery);

                $insertStatement->bindValue(':username', $username);
                $insertStatement->bindValue(':password', $hashedPassword);
                $insertStatement->bindValue(':email', $email);
    
                $insertStatement->execute();
                header('Location: adminpanel.php');
            }
            else
            {
                $passwordConfirmationError = "Passwords didnt match";
            }
        }
        if(empty($_POST['username'])){
            $userNameError = "Please enter a valid user name.";
        }
        if(empty($_POST['password'])){
            $passwordError = "Please enter a valid password.";
        }
        if(empty($_POST['passwordConfirm'])){
            $passwordConfirmationError = "Please enter a valid password.";
        }   
        if(empty($_POST['email'])){
            $emailError = "Please enter a valid E-Mail";
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
    
    <title>iMovieRatings | Edit User</title>

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
                            <h3 class="title">Create Account</h3>
                            <div class="form-group">
                                <label class="fs-3" for="Username">Enter New User Name</label>
                                <input type="text" class="form-control" name="username" type="text" placeholder="username">
                                <?php if(isset($userNameError)): ?>
                                    <p class="fs-5"><?= $userNameError ?></p>
                                <?php endif ?>
                            </div>
                            <div class="form-group">
                                <h2>Enter Password:</h2>
                                <input type="password" class="form-control" name="password" placeholder="password">
                                <?php if(isset($passwordError)): ?>
                                    <p class="fs-5"><?= $passwordError ?></p>
                                <?php endif ?>
                            </div>
                            <div class="form-group">
                                <h2>Confirm Password</h2>
                                <input type="password" class="form-control" name="passwordConfirm" placeholder="confirm password">
                                <?php if(isset($passwordConfirmationError)): ?>
                                    <p class="fs-5"><?= $passwordConfirmationError ?></p>
                                <?php endif ?>
                            </div>
                            <div class="form-group">
                                <h2>Enter E-mail:</h2>
                                <input type="email" class="form-control" name="email" placeholder="email">
                                <?php if(isset($emailError)): ?>
                                    <p class="fs-5"><?= $emailError ?><p>
                                <?php endif ?>
                            </div>
                                <input class ="btn signin bg-light text-danger" type="submit" name="login" value="Create Account">
                                
                            </div>
                        </div>          
                    </form>
                </div>
            </div>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        </section>
    </main>
</body>