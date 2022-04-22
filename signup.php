<?php
    session_start();
    require('connect.php');
    
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
      if($_POST && !empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['passwordConfirm']) && !empty($_POST['email']) && !empty($_POST['captcha']))
        { 
          if($_POST['captcha'] != $_SESSION['captcha_text'])
          {
            $captchaError = "Robot alert! Your guess did not match the captcha. Please try again.";
            $_SESSION['attemptedUsername'] = $_POST['username'];
            $_SESSION['attemptedEmail'] = $_POST['email'];
          }
          else
          {
            // Filter, Saniitize and set variables.
            $hasErrors = false;
            $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
            $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);
            $passwordConfirm = filter_input(INPUT_POST, 'passwordConfirm', FILTER_SANITIZE_SPECIAL_CHARS);
            $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
            
            //Hash password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            
            //Validate Email
            if(!filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL))
            {
              $hasErrors = true;
              $emailError = "Email was invalid, please try again.";
            }

            //Confirm passwords match
            if($password != $passwordConfirm)
            {
              $hasErrors = true;
              $passwordError = "Passwords did not match. Please try again.";
            }

            // If no errors, exectue the database insert of the new user.
            if(!$hasErrors)
            {
              //Inserts the new user into the user table
              $insertQuery = "INSERT INTO user (user_name, password, email) VALUES (:username, :password, :email)";
              $insertStatement = $db->prepare($insertQuery);
              $insertStatement->bindValue(':username', $username);
              $insertStatement->bindValue(':password', $hashedPassword);
              $insertStatement->bindValue(':email', $email);
              $insertStatement->execute();
            
              $selectQuery = "SELECT * FROM user WHERE user_name = :user_name";
              $selectStatement = $db->prepare($selectQuery);
              $selectStatement->bindValue(':user_name', $username);
              $selectStatement->execute();
              $selectRow = $selectStatement->fetch();
            
              $userid = $selectRow['user_id'];
              $image_name = "default.jpeg";
            
              //Sets the new users current profile picture to default
              $profileImageQuery = "INSERT INTO profileimage (user_id, image_name) VALUES (:user_id, :image_name)";
              $profileImageStatement = $db->prepare($profileImageQuery);
              $profileImageStatement->bindValue(':user_id', $userid);
              $profileImageStatement->bindValue(':image_name', $image_name);
              $profileImageStatement->execute();
              
              $_SESSION['attemptedUsername'] = "";
              $_SESSION['attemptedEmail'] = "";

              header('Location: index.php');
              }
              else
              {
                $passwordConfirmationError = "Passwords didnt match";
              }
          }         
        }
        if(empty($_POST['username']))
        {
          $userNameError = "Please enter a user name.";
        }
        if(empty($_POST['password']))
        {
          $passwordError = "Please enter a password.";
        }
        if(empty($_POST['passwordConfirm']))
        {
          $passwordConfirmationError = "Please enter a password matching the previous.";
        }   
        if(empty($_POST['email']))
        {
          $emailError = "Please enter an E-Mail";
        }
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="style.css">
    
    <title>iMovieRatings | Sign Up</title>

</head>
<body>
  <?php include('nav.php')?>
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
                <label class="fs-3">Enter your User Name</label>
                <input type="text" class="form-control" name="username" placeholder="username" value="<?= $_SESSION['attemptedUsername']?>">
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
                <input type="email" class="form-control" name="email" placeholder="email" value="<?= $_SESSION['attemptedEmail']?>">
                <?php if(isset($emailError)): ?>
                  <p class="fs-5"><?= $emailError ?><p>
                <?php endif ?>
              </div>
              <input type="text" id="captcha" name="captcha">
              <img id="captcha_image" src="captcha.php" alt="Captcha"><br>
              <?php if(isset($captchaError)): ?>
                <p class="fs-5"><?= $captchaError ?><p>
              <?php endif ?>
              <input class ="btn signin bg-light text-danger" type="submit" name="login" value="Create Account">
              </form>
            </div>
          </div>      
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</section>
</main>
</body>
</html>