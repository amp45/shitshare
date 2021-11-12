<html>
<head>
<title><?php echo $pagetitle; ?></title>
<meta name="title" content="ShitShare">
<meta name="description" content="Simple photo, video and forum website.">
<link rel="stylesheet" href="/stylesheet.css">
</head>
<body>
<div class="HeaderPic">
<div class="LoginStatus">
<?php
if(isset($_COOKIE["username"])) {
	echo "Hello, <a class='logged' href='profile.php?user=$username'>$username</a>! | <a href='logout.php' class='logged'>Log out</a>";
} else {
	echo "You are not logged in, please <a href='login.php' class='logged'>Log in</a> or <a href='signup.php' class='logged'>Sign up</a>";
}
?>
</div>
</div>
<div class="HeaderLinks">
<a href="">Home</a> | <a href="">Images</a> | <a href="">Videos</a> | <a href="">Blogs</a> | <a href="">Users</a>
</div>