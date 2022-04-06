<?php
    session_start();
    require('connect.php');
    $user_id = $_SESSION['user_id'];
    $uploadError ="";

    //Finds the current profile picture
    $findImageQuery = "SELECT * FROM profileimage WHERE user_id = :user_id";
    $findImageStatement = $db->prepare($findImageQuery);
    $findImageStatement->bindValue(':user_id', $user_id);
    $findImageStatement->execute();
    $imageRow = $findImageStatement->fetch();

    //If submitted, run the file upload function
    if(isset($_POST['submit']))
    {
        $image = $_FILES['image']['name'];
        file_upload_path($image);        
    }

    $image_upload_detected = isset($_FILES['image']) && ($_FILES['image']['error'] === 0);
    // If an image upload is detected, store the file name and temporary image path
    if ($image_upload_detected) 
    {
         $image_filename       = $_FILES['image']['name'];
         $temporary_image_path = $_FILES['image']['tmp_name'];
         $new_image_path       = file_upload_path($image_filename);
         $imageType            = $_FILES['image']['type'];
        
         /*If the file passes the imageNess test insert the name of the image into
           the profile image table where the user id matches the current user that is logged in.*/
         if(file_is_an_image($temporary_image_path, $new_image_path))
         {
            $modifyQuery = "UPDATE profileimage SET image_name = (:image_name) WHERE user_id = :user_id";
            $modifyStatement = $db->prepare($modifyQuery);
            $modifyStatement->bindValue(':image_name', $image);
            $modifyStatement->bindValue(':user_id', $user_id);
            $modifyStatement->execute();
            $row = $modifyStatement->fetch();
            
            move_uploaded_file($temporary_image_path, $new_image_path);
            $_SESSION['image_name'] = $image_filename;
            resizeImage($new_image_path);
            $redirect = "Location: editprofilepicture.php?id=".$user_id;

            header($redirect);
         }
         else
         {
             $uploadError = "Only file types JPG, JPEG, PNG are allowed.";
         }
    }

    //Query to delete profile picture.
    //This query modifies the image_name value of the profile picture table to the default image.
    if(isset($_POST['updateImage'])){
        $updateQuery = "UPDATE profileimage SET image_name = 'default.png' WHERE user_id = :user_id";
        $updateStatement = $db->prepare($updateQuery);
        $updateStatement->bindValue(':user_id', $_SESSION['user_id']);
        $updateStatement->execute();

        //Delete the users current image from the uploads folder
        $unlinkPath = "uploads/".$_SESSION['image_name'];
        unlink($unlinkPath);

        //Update the session variable of the currently logged in user
        $_SESSION['image_name'] = "default.jpeg";

        header("Location: editprofilepicture.php?id=".$_SESSION['user_id']);
        exit;
    }

    //Takes in the original file name, and the upload folder name, and moves it to the upload floder.
    function file_upload_path($original_filename, $upload_subfolder_name = 'uploads') 
    {
        $current_folder = dirname(__FILE__);
        $path_segments = [$current_folder, $upload_subfolder_name, basename($original_filename)];
        return join(DIRECTORY_SEPARATOR, $path_segments);
    }

    //Checks for imageness
    function file_is_an_image($temporary_path, $new_path) 
    {
        $allowed_mime_types      = ['image/jpeg', 'image/png'];
        $allowed_file_extensions = ['jpg', 'jpeg', 'png'];

        $actual_file_extension   = pathinfo($new_path, PATHINFO_EXTENSION);
        $actual_mime_type        = getimagesize($temporary_path)['mime'];

        $file_extension_is_valid = in_array($actual_file_extension, $allowed_file_extensions);
        $mime_type_is_valid      = in_array($actual_mime_type, $allowed_mime_types);

        return $file_extension_is_valid && $mime_type_is_valid;
    }

    function resizeImage($file)
    {
        $imageType = $_FILES['image']['type'];
        
        if(file_exists($file))
        {
            if($imageType = "image/jpeg")
            {
                $originalImage = imagecreatefromjpeg($file);
                $newImage = imagecreatetruecolor(200, 200);

                //Resolution
                $originalWidth = imagesx($originalImage);
                $originalHeight = imagesy($originalImage);

                imagecopyresampled($newImage, $originalImage,0,0,0,0,200,200,$originalWidth,$originalHeight);
                imagejpeg($newImage,$file,100);
            }
            elseif($imageType = "image/png")
            {
                $originalImage = imagecreatefrompng($file);
                $newImage = imagecreatetruecolor(200, 200);

                //Resolution
                $originalWidth = imagesx($originalImage);
                $originalHeight = imagesy($originalImage);

                imagecopyresampled($newImage, $originalImage,0,0,0,0,200,200,$originalWidth,$originalHeight);
                imagepng($newImage,$file,100);
            }
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
             <span class="span-navbar-toggler-icon"><i class="bi bi-list"></i></span>
            </button>

            <div class="collapse navbar-collapse" id="navmenu">
                <ul class="navbar-nav ms-auto">
                    <?php if($_SESSION['username']): ?>
                        <li class="nav-item">
                            <h5 class="text-light">Hello, <?= $_SESSION['username'] ?></h5>
                        </li>
                        <li class="nav-item">
                            <a href="userpanel.php?id=<?= $_SESSION['user_id'] ?>" class="nav-link">User Settings</a>
                        </li>
                        <li class="nav-item">
                            <a href="logout.php" class="nav-link">Logout</a>
                        </li>
                    <?php else : ?>
                        <li class="nav-item">
                            <a href="login.php" class="nav-link">Login</a>
                        </li>
                    <?php endif ?>
                    <?php if($_SESSION['username'] == "admin"): ?>
                        <li class="nav-item">
                            <a href="adminpanel.php" class="nav-link">Admin Panel</a>
                        </li>
                    <?php endif ?>
                </ul>
                <input class = "search" type="text">
                <button type="button" class="btn btn-danger">Search</button>
                <button type="button" class="btn btn-danger">Enter a Movie</button>
            </div>
        </div>
    </nav> 

    <section class="bg-dark text-dark p-5 text-left">
            <div class="form_bg">
                <div class="container">
                    <form class="form_horizontal" method="post" enctype="multipart/form-data">
                        <div class="form_icon">
                            <img src="uploads/<?= $_SESSION['image_name']?>">
                        </div>
                            <h3 class="title">Edit User</h3>
                            <div class="form-group">
                                <label class="fs-3" for="Username">Edit Profile Picture</label>
                                <input type="file" name="image" id="image">
                                <input type="submit" name="submit" value="Upload Image">
                                <?php if($uploadError): ?>
                                    <p class="fs-5"><?= $uploadError ?></p>
                                <?php endif ?>
                                <?php if ($_POST): ?>
                                    <h1><?= print_r($_FILES) ?></h1>
                                <?php endif ?>
                                <input type="submit" name="updateImage" value="Delete Image" onclick="return confirm('Are you sure you wish to delete your profile image?')" />
                            </div>
                    </form>
                </div>
            </div>
    </section>
</body>