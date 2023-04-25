<!DOCTYPE html>
<html>
<head>
	<title>Signup - my website</title>
    <link rel="stylesheet" href="css/style.css" >
</head>
<body>

	<?php require "header.php";?>




		<div style="margin: auto;max-width: 600px">

			<h2 style="text-align: center;">Signup</h2>

			<form method="post" action="signup_action.php" style="margin: auto;padding:10px;">
				
				<input type="text" name="username" placeholder="Username" required><br>
				<input type="email" name="email" placeholder="Email" required><br>
				<input type="text" name="password" placeholder="Password" required><br>

				<button>Signup</button>
			</form>	
		</div>
	<?php require "footer.php";?>

</body>
</html>