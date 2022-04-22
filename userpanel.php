<?php
    session_start();
    require('connect.php');

    //Sanatize the ID
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    
    if(!filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT) || !filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT))
    {
      header("location: index.php");
    }  
    
        $selectQuery = "SELECT * FROM user WHERE user_id = :user_id";
        $selectStatement = $db->prepare($selectQuery);
        $selectStatement->bindValue(':user_id', $id);
        $selectStatement->execute();
        $row = $selectStatement->fetch();

        if($_POST && isset($_POST['username']) && isset($_POST['username']))
        {
            $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
            $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $file = $_FILES['file'];
        
            // Build the parameterized SQL query and bind to the above sanitized values.
            $updateQuery = "UPDATE user SET user_name = :user_name, email = :email WHERE user_id = :user_id";
            $updateStatement = $db->prepare($updateQuery);
            $updateStatement->bindValue(':user_name', $username);  
            $updateStatement->bindValue(':email', $email);
            $updateStatement->bindValue(':user_id', $userID); 

            $modifyCommand = $_POST['modifyCommand'];
            if($modifyCommand)
            {   
                $updateStatement->execute();
                $_SESSION['username'] = $username;
                header("Location: index.php");
                exit;
            }

            // Delete the selected user
            $deleteQuery = "DELETE FROM user WHERE user_id = :user_id";
            $deleteStatement = $db->prepare($deleteQuery);
            $deleteStatement->bindValue(':user_id', $userID);

            $deleteCommand = $_POST['deleteCommand'];
            if($deleteCommand){
                $deleteStatement->execute();
                header("Location: logout.php");
                exit;
            }
        
        }

        if (isset($_FILES['image']))
        {
            file_upload_path($_FILES['image']['tmp_name'], $upload_subfolder_name = 'uploads');
            header("Location: index.php");
            exit;
        }
        
        function file_upload_path($original_filename, $upload_subfolder_name = 'uploads') {
            $current_folder = dirname(__FILE__);
            $path_segments = [$current_folder, $upload_subfolder_name, basename($original_filename)];
            return join(DIRECTORY_SEPARATOR, $path_segments);
         }

        function file_is_an_image($temporary_path, $new_path) {
            $allowed_mime_types      = ['image/gif', 'image/jpeg', 'image/png'];
            $allowed_file_extensions = ['gif', 'jpg', 'jpeg', 'png'];

            $actual_file_extension   = pathinfo($new_path, PATHINFO_EXTENSION);
            $actual_mime_type        = getimagesize($temporary_path)['mime'];

            $file_extension_is_valid = in_array($actual_file_extension, $allowed_file_extensions);
            $mime_type_is_valid      = in_array($actual_mime_type, $allowed_mime_types);

            return $file_extension_is_valid && $mime_type_is_valid;
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
    
    <title>iMovieRatings | Edit User</title>

</head>
<body>
	<?php include('nav.php')?>
		<main>
			<section class="bg-dark text-dark p-5 text-left">
				<div class="form_bg">
					<div class="container">
						<form class="form_horizontal" method="post">
							<div class="form_icon">
								<img src="uploads/<?=$_SESSION['image_name']?>" alt="profile picture">
							</div>
							<h3 class="title">Edit User</h3>
							<div class="form-group">
								<a href="editprofilepicture.php?id=<?= $row['user_id'] ?>" class="btn btn-info">Change Profile Picture</a>                            </div>
								<div class="form-group">
									<label class="fs-3">Edit Username</label>
									<input type="text" class="form-control" name="username" value="<?=$row['user_name']?>">
								</div>
								<div class="form-group">
								    <h2>Edit Email</h2>
								    <input type="text" class="form-control" name="email" value="<?=$row['email']?>">
							    </div>
							    <input class ="btn signin bg-light text-danger" type="submit" name="modifyCommand" value="Modify">
							    <input class ="btn signin bg-danger text-light" name="deleteCommand" type="submit" value="Delete" onclick="return confirm('Are you sure you wish to delete this user?')">
						    </div>
                        </form>                             
                </div>
            </section>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    </main>
</body>
</html>