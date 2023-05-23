<?php
    include('db_config/connect.php');
    session_start();
    print_r($_SESSION['user_info']);

    if($_SERVER['REQUEST_METHOD'] == "POST" && !empty($_POST['action']) && $_POST['action'] == 'delete')
	{
		//delete your profile
		$id = $_SESSION['user_info']['id'];
		$query = "delete from users where id = '$id' limit 1";
		$result = mysqli_query($con,$query);

		if(file_exists($_SESSION['user_info']['image'])){
			unlink($_SESSION['user_info']['image']);
		}

		$query = "delete from posts where user_id = '$id'";
		$result = mysqli_query($con,$query);

		header("Location: index.php");
		die;

	}
elseif($_SERVER['REQUEST_METHOD'] == "POST" && !empty($_POST['username']))
{
    //profile edit
    $image_added = false;
    if(!empty($_FILES['image']['name']) && $_FILES['image']['error'] == 0 && $_FILES['image']['type'] == "image/jpeg"
    ){
        //file was uploaded
        $folder = "images/";
        if(!file_exists($folder))
        {
            mkdir($folder,0777,true);
        }

        $image = $folder . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], $image);

        if(file_exists($_SESSION['user_info']['image'])){
            unlink($_SESSION['user_info']['image']);
        }

        $image_added = true;
    }

    $username = addslashes($_POST['username']);
    $email = addslashes($_POST['email']);
    $password = addslashes($_POST['password']);
    $id = $_SESSION['user_info']['id'];

    if($image_added == true){
        $query = "update users set name = '$username',email = '$email',pass = '$password',image = '$image' where id = '$id' limit 1";
    }else{
        $query = "update users set name = '$username',email = '$email',pass = '$password' where id = '$id' limit 1";
    }

    $result = mysqli_query($con,$query);

    $query = "select * from users where id = '$id' limit 1";
    $result = mysqli_query($con,$query);

    if(mysqli_num_rows($result) > 0){

        $_SESSION['user_info'] = mysqli_fetch_assoc($result);
    }

    header("Location: profile.php");
    die;
}
elseif($_SERVER['REQUEST_METHOD'] == "POST" && !empty($_POST['post']))
{
    //adding post
    $image = "";
    if(!empty($_FILES['image']['name']) && $_FILES['image']['error'] == 0 && $_FILES['image']['type'] == "image/jpeg"){
        //file was uploaded
        $folder = "images/";
        if(!file_exists($folder))
        {
            mkdir($folder,0777,true);
        }

        $image = $folder . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], $image);

    }

    $post = addslashes($_POST['post']);
    $user_id = $_SESSION['user_info']['id'];
    $date = date('Y-m-d H:i:s');

    $query = "insert into posts (user_id, desc1 , image, date) values ('$user_id','$post','$image','$date')";

    $result = mysqli_query($con,$query);

    header("Location: profile.php");
    die;
}




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
                <hr>
                <hr>
                <h5>Create a post</h5>
				<form method="post" enctype="multipart/form-data" style="margin: auto;padding:10px;">
					
					image: <input type="file" name="image"><br>
					<textarea name="post" rows="8"></textarea><br>

					<button>Post</button>
				</form>

				<hr>
                <hr>
                <posts>
					<?php 
						$id = $_SESSION['user_info']['id'];
						$query = "select * from posts where user_id = '$id' order by id desc limit 10";

						$result = mysqli_query($con,$query);
					?>

					<?php if(mysqli_num_rows($result) > 0):?>

						<?php while ($row = mysqli_fetch_assoc($result)):?>

							<?php 
								$user_id = $row['user_id'];
								$query = "select name,image from users where id = '$user_id' limit 1";
								$result2 = mysqli_query($con,$query);

								$user_row = mysqli_fetch_assoc($result2);
							?>
							<div style="background-color:white;display: flex;border:solid thin #aaa;border-radius: 10px;margin-bottom: 10px;margin-top: 10px;">
								<div style="flex:1;text-align: center;">
									<img src="<?=$user_row['image']?>" style="border-radius:50%;margin:10px;width:100px;height:100px;object-fit: cover;">
									<br>
									<?=$user_row['name']?>
								</div>
								<div style="flex:8">
									<?php if(file_exists($row['image'])):?>
										<div style="">
											<img src="<?=$row['image']?>" style="width:100%;height:200px;object-fit: cover;">
										</div>
									<?php endif;?>
									<div>
										<div style="color:#888"><?=date("jS M, Y",strtotime($row['date']))?></div>
										<?php echo nl2br(htmlspecialchars($row['desc1']))?>

										<br><br>

										<a href="profile1.php?action=post_edit&id=<?= $row['id']?>">
											<button>Edit</button>
										</a>

										<a href="profile1.php?action=post_delete&id=<?= $row['id']?>">
											<button>Delete</button>
										</a>
										<br><br>
									</div>
								</div>
								
							</div>
						<?php endwhile;?>
					<?php endif;?>
				</posts> 

                <?php endif;?>

    <?php require "footer.php";?>

</body>
</html>
