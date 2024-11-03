<?php

function insertChef($pdo, $Cname, $Specialty) {

	$sql = "INSERT INTO chefs (Chef_Name, Chef_Specialty) VALUES(?,?)";

	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$Cname, $Specialty]);

	if ($executeQuery) {
		return true;
	}
}

function GetAllChef($pdo) {
	$sql = "SELECT * FROM chefs";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute();

	if ($executeQuery) {
		return $stmt->fetchAll();
	}
}

function GetChefByID($pdo, $Chef_ID) {
	$sql = "SELECT * FROM chefs WHERE Chef_ID = ?";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$Chef_ID]);

	if ($executeQuery) {
		return $stmt->fetch();
	}
}

function updateChef($pdo, $Cname, $Specialty, $Chef_ID) {

	$sql = "UPDATE chefs
				SET Chef_Name = ?,
					Chef_Specialty = ?
				WHERE Chef_ID = ?
			";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$Cname, $Specialty, $Chef_ID]);
	
	if ($executeQuery) {
		return true;
	}

}

function delChef($pdo, $Chef_ID) {
	$delChefPastry = "DELETE FROM pastry WHERE Chef_ID = ?";
	$deleteStmt = $pdo->prepare($delChefPastry);
	$executeDeleteQuery = $deleteStmt->execute([$Chef_ID]);

	if ($executeDeleteQuery) {
		$sql = "DELETE FROM chefs WHERE Chef_ID = ?";
		$stmt = $pdo->prepare($sql);
		$executeQuery = $stmt->execute([$Chef_ID]);

		if ($executeQuery) {
			return true;
		}

	}
	
}

function GetPastryByChefID($pdo, $Chef_ID) {
	
	$sql = "SELECT 
				pastry.Pastry_ID AS Pastry_ID,
				pastry.Pastry_Category AS Pastry_Category,
				pastry.Pastry_Price AS Pastry_Price,
				pastry.Date_addedd AS date_added,
				chefs.Chef_Name AS Pastry_Chef,
				pastry.added_by AS Added_by,
				pastry.last_updated AS Last_updated
			FROM pastry
			JOIN chefs ON pastry.Chef_ID = chefs.Chef_ID
			WHERE pastry.Chef_ID = ? 
			GROUP BY pastry.Pastry_Category;
			";

	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$Chef_ID]);
	if ($executeQuery) {
		return $stmt->fetchAll();
	}
}


function insertPastry($pdo, $pastry_Cat, $pastry_price, $added_by, $Chef_ID) {
	$sql = "INSERT INTO pastry (Pastry_Category, Pastry_Price, added_by, Chef_ID) VALUES (?,?,?,?)";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$pastry_Cat, $pastry_price, $added_by, $Chef_ID]);
	if ($executeQuery) {
		return true;
	}

}

function getPastryByID($pdo, $Pastry_ID) {
	$sql = "SELECT 
				pastry.Pastry_ID AS Pastry_ID,
				pastry.Pastry_Category AS Pastry_Category,
				pastry.Pastry_Price AS Pastry_Price,
				pastry.Date_addedd AS date_added,
				chefs.Chef_Name AS Pastry_Chef,
				pastry.added_by AS Added_by,
				pastry.last_updated AS Last_updated
			FROM pastry
			JOIN chefs ON pastry.Chef_ID = chefs.Chef_ID
			WHERE pastry.Pastry_ID  = ? 
			GROUP BY pastry.Pastry_Category";

	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$Pastry_ID]);
	if ($executeQuery) {
		return $stmt->fetch();
	}
}
 
function updatePastry($pdo, $Pastry_Category, $Pastry_Price, $Added_by, $Pastry_ID) {
	$sql = "UPDATE pastry
			SET Pastry_Category = ?,
				Pastry_Price = ?,
				added_by = ?
			WHERE Pastry_ID = ?
			";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$Pastry_Category, $Pastry_Price, $Added_by, $Pastry_ID]);

	if ($executeQuery) {
		return true;
	}
}

function deletePastry($pdo, $Pastry_ID) {
	$sql = "DELETE FROM pastry WHERE Pastry_ID = ?";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$Pastry_ID]);
	if ($executeQuery) {
		return true;
	}
}


function insertNewUser($pdo, $username, $password) {

	$checkUserSql = "SELECT * FROM users WHERE username = ?";
	$checkUserSqlStmt = $pdo->prepare($checkUserSql);
	$checkUserSqlStmt->execute([$username]);

	if ($checkUserSqlStmt->rowCount() == 0) {

		$sql = "INSERT INTO users (username,password) VALUES(?,?)";
		$stmt = $pdo->prepare($sql);
		$executeQuery = $stmt->execute([$username, $password]);

		if ($executeQuery) {
			$_SESSION['message'] = "User successfully inserted";
			return true;
		}

		else {
			$_SESSION['message'] = "An error occured from the query";
		}

	}
	else {
		$_SESSION['message'] = "User already exists";
	}

	
}

function getAllUsers($pdo) {
	$sql = "SELECT * FROM users";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute();

	if ($executeQuery) {
		return $stmt->fetchAll();
	}

}

function getUserByID($pdo, $user_id) {
	$sql = "SELECT * FROM users WHERE user_ID = ?";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$user_id]);
	if ($executeQuery) {
		return $stmt->fetch();
	}
}

function loginUser($pdo, $username, $password) {
	$sql = "SELECT * FROM users WHERE username=?";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([$username]); 

	if ($stmt->rowCount() == 1) {
		$userInfoRow = $stmt->fetch();
		$usernameFromDB = $userInfoRow['username']; 
		$passwordFromDB = $userInfoRow['password'];

		if ($password == $passwordFromDB) {
			$_SESSION['username'] = $usernameFromDB;
			return true;
		}

			else {
				$_SESSION['message'] = "Password is invalid, but user exists";
		}
	}

	
	if ($stmt->rowCount() == 0) {
		$_SESSION['message'] = "Username doesn't exist from the database. You may consider registration first";
	}

}


?>