<?php
require_once 'dbConfig.php'; 
require_once 'models.php';

if (isset($_POST['insertCHEFbtn'])) {

	$query = insertChef($pdo, $_POST['Cname'], $_POST['specialty']);

	if ($query) {
		header("Location: ../index.php");
	}
	else {
		echo "Insertion failed";
	}

}

if (isset($_POST['editCHEFbtn'])) {
	$query = updateChef($pdo, $_POST['Cname'], $_POST['specialty'], $_GET['Chef_ID']);

	if ($query) {
		header("Location: ../index.php");
	}

	else {
		echo "Edit failed";;
	}

}

if (isset($_POST['delCHEFbtn'])) {
	$query = delChef($pdo, $_GET['Chef_ID']);

	if ($query) {
		header("Location: ../index.php");
	}

	else {
		echo "Deletion failed";
	}
}

if (isset($_POST['insertPASTRYbtn'])) {
	$query = insertPastry($pdo, $_POST['pastryCat'], $_POST['pastryPri'],$_POST['Added'], $_GET['Chef_ID']);

	if ($query) {
		header("Location: ../viewpastry.php?Chef_ID=" .$_GET['Chef_ID']);
	}
	else {
		echo "Insertion failed";
	}
}


if (isset($_POST['editPASTRYbtn'])) {
	$query = updatePastry($pdo, $_POST['Pastry_Category'], $_POST['Pastry_Price'],$_POST['added'], $_GET['Pastry_ID']);

	if ($query) {
		header("Location: ../viewpastry.php?Chef_ID=" .$_GET['Chef_ID']);
	}
	else {
		echo "Update failed";

	}

}

if (isset($_POST['deletePASTRYBtn'])) {
	$query = deletePastry($pdo, $_GET['Pastry_ID']);

	if ($query) {
		header("Location: ../viewpastry.php?Chef_ID=" .$_GET['Chef_ID']);
	}
	else {
		echo "Deletion failed";
	}
}

if (isset($_POST['registerUserBtn'])) {

	$username = $_POST['username'];
	$password = sha1($_POST['password']);

	if (!empty($username) && !empty($password)) {

		$insertQuery = insertNewUser($pdo, $username, $password);

		if ($insertQuery) {
			header("Location: ../login.php");
		}
		else {
			header("Location: ../register.php");
		}
	}

	else {
		$_SESSION['message'] = "Please make sure the input fields 
		are not empty for registration!";

		header("Location: ../login.php");
	}

}

if (isset($_POST['loginUserBtn'])) {

	$username = $_POST['username'];
	$password = sha1($_POST['password']);

	if (!empty($username) && !empty($password)) {

		$loginQuery = loginUser($pdo, $username, $password);
	
		if ($loginQuery) {
			header("Location: ../index.php");
		}
		else {
			header("Location: ../login.php");
		}

	}

	else {
		$_SESSION['message'] = "Please make sure the input fields 
		are not empty for the login!";
		header("Location: ../login.php");
	}
 
}

if (isset($_GET['logoutAUser'])) {
	unset($_SESSION['username']);
	header('Location: ../login.php');
}
?>