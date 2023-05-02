<?php
    session_start();
    print_r($_SESSION['user_info']);
    


?>

<!DOCTYPE html>
<html>
<head>
	<title>Profile - my website</title>
    <link rel="stylesheet" href="css/style.css" >
</head>
<body>

	<?php require "header.php";?>
    <?php if(!empty($_GET['action']) && $_GET['action'] == 'edit'):?>

    <h2 style="text-align: center;">Edit profile</h2>

    <form method="post"  enctype="multipart/form-data" style="margin: auto;padding:10px;">
        <img src="<?php echo $_SESSION['user_info']['image']?>" style="width: 100px;height: 100px;object-fit: cover;margin: auto;display: block;">
        image: <input type="file" name="image"><br>
        <input value="<?php echo $_SESSION['user_info']['name']?>" type="text" name="username" placeholder="Username" required><br>
        <input value="<?php echo $_SESSION['user_info']['email']?>" type="email" name="email" placeholder="Email" required><br>
        <input value="<?php echo $_SESSION['user_info']['pass']?>" type="text" name="password" placeholder="Password" required><br>

        <button>Save</button>
        <a href="profile.php">
            <button type="button">Cancel</button>
        </a>
    </form>

    <?php elseif(!empty($_GET['action']) && $_GET['action'] == 'delete'):?>
        <form method="post" style="margin: auto;padding:10px;">
                
                <img src="<?php echo $_SESSION['user_info']['image']?>" style="width: 100px;height: 100px;object-fit: cover;margin: auto;display: block;">
                <div><?php echo $_SESSION['user_info']['name']?></div>
                <div><?php echo $_SESSION['user_info']['email']?></div>
                <input type="hidden" name="action" value="delete">
                <button>Delete</button>
                <a href="profile.php">
                    <button type="button">Cancel</button>
                </a>
            </form>
        </div>
    <?php else:?>

    <h2 style="text-align: center;">User Profile</h2>
				<br>
				<div style="margin: auto;max-width: 600px;text-align: center;">
					<div>
						<td><img src="<?php echo $_SESSION['user_info']['image']?>" style="width: 150px;height: 150px;object-fit: cover;"></td>
					</div>
                    <br><br>
					<div>
						<td><?php echo $_SESSION['user_info']['name']?></td>
					</div>
                    <br>
                    <br>
					
					<div>
						<td><?php echo $_SESSION['user_info']['email']?></td>
					</div>

					<a href="profile.php?action=edit">
						<button>Edit profile</button>
					</a>

					<a href="profile.php?action=delete">
						<button>Delete profile</button>
					</a>

				</div>
				<br>
                <?php endif;?>

    <?php require "footer.php";?>

</body>
</html>
