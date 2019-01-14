<?php session_start();?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>URL Shotener</title>
	<link rel="stylesheet" type="text/css" href="css/main.css">
</head>
<body>
	<div class="container">
		<h1 class="title"> Shorten a URL. </h1>
		<?php
			if ( isset($_SESSION['success']) ) {
			?>
				<p class="msg success"> <?= $_SESSION['success'] ?> </p>			
			<?php
				unset($_SESSION['success']);
			} elseif ( isset($_SESSION['error']) ) {
			?>
				<p class="msg error"> <?= $_SESSION['error'] ?> </p>			
			<?php
				unset($_SESSION['error']);
			}
		?>
		<form action="shorten.php" method="post">
			<input type="url" name="url" autocomplete="off" placeholder="Enter a URL here.">
			<input type="submit" value="Shorten">
		</form>
	</div>
</body>
</html>