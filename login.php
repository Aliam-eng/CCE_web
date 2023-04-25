<!DOCTYPE html>
<html>
<head>
	<title>Login - my website</title>
    <link rel="stylesheet" href="css/style.css" >
</head>
<body>

	<?php require "header.php";?>

		<div style="margin: auto;max-width: 600px">

  <?php

        if(isset($_GET['flag'])){
            if($_GET['flag']==1)
                echo "<b>email or pass is wrong !!<b>";
                
        } 
     

    ?>
			<h2 style="text-align: center;">Login</h2>
			
			<form method="post" action="login_action.php" style="margin: auto;padding:10px;">
				
				<input type="email" name="email" placeholder="Email" required><br>
				<input type="password" name="password" placeholder="Password" required><br>

				<button>Login</button>
			</form>	
		</div>
	<?php require "footer.php";?>

</body>
</html>