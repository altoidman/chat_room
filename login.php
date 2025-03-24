<?php
session_start();
include('db.php');
if($_SERVER['REQUEST_METHOD'] == "POST"){
	$username = trim(htmlspecialchars($_POST['username']));
	$password = trim(htmlspecialchars($_POST['password']));
	$select = $conn->prepare("SELECT password FROM users WHERE username = :username LIMIT 1");
	$select->bindParam(':username',$username);
	$select->execute();
	$get = $select->fetch(PDO::FETCH_ASSOC);
	if($get && password_verify($password, $get['password'])){
		$_SESSION['user'] = $username;
		session_regenerate_id(true);
	    header("location: index.php");
		exit();
		} else {
	echo "<p style='color:red;'>username or password not right!</p>";
    }
}
?>

<form method="POST">
	<h1>login page</h1>
	<input type="text" name="username" placeholder="username" required>
	<input type="password" name="password" placeholder="password" required>
	<button type="submit">login</button>
</form>