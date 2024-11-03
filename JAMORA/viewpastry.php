<?php require_once 'core/models.php'; ?>
<?php require_once 'core/dbConfig.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<link rel="stylesheet" href="styles.css">
</head>
<body>
	<a href="index.php">Return to home</a>
	<h1>Add New Pastry</h1>
	<form action="core/handleForms.php?Chef_ID=<?php echo $_GET['Chef_ID'] ?>" method="POST">
		
    <p><label for="Pastry Category">Pastry Category</label> 
			<input type="text" name="pastryCat"> </p>
		<p>
			<label for="Pastry Price">Pastry Price</label> 
			<input type="text" name="pastryPri">
		</p>
		<p>
			<label for="Adder"> Added by </label>
			<input type="text" name="Added">
			<input type="submit" name="insertPASTRYbtn">
		</p>
	</form>

	<table style="width:100%; margin-top: 50px;">
	  <tr>
	    <th>Pastry ID</th>
	    <th>Pastry Category</th>
	    <th>Pastry Price</th>
	    <th>Pastry Chef</th>
	    <th>Date Added</th>
		<th>Added By</th>
		<th>Last Updated</th>
	    <th>Action</th>
	  </tr>
	  <?php $GetPastryByChefID = GetPastryByChefID($pdo, $_GET['Chef_ID']); ?>
	  <?php foreach ($GetPastryByChefID as $row) { ?>
	  <tr>
	  	<td><?php echo $row['Pastry_ID']; ?></td>	  	
	  	<td><?php echo $row['Pastry_Category']; ?></td>	  	
	  	<td><?php echo $row['Pastry_Price']; ?></td>	  	
	  	<td><?php echo $row['Pastry_Chef']; ?></td>	  	
	  	<td><?php echo $row['date_added']; ?></td>
		<td><?php echo $row['Added_by']; ?></td>
		<td><?php echo $row['Last_updated']; ?></td>
	  	<td>
            <a href="editpastry.php?Pastry_ID=<?php echo $row['Pastry_ID']; ?>&Chef_ID=<?php echo $_GET['Chef_ID']; ?>">Edit</a>

            <a href="deletepastry.php?Pastry_ID=<?php echo $row['Pastry_ID']; ?>&Chef_ID=<?php echo $_GET['Chef_ID']; ?>">Delete</a>
        </td>
	  </tr>
	<?php } ?>
	</table>

	
</body>
</html>