<?php
 $date = $tittle = $comment =  "";
	if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		$date = $_POST["date"];
		$tittle = $_POST["tittle"];
		$comment = $_POST["comment"];
		
	
	
		$servername = "localhost";
		$username = "root";
		$dbpass = "";
		$dbname = "social";
	
		$conn = new mysqli($servername, $username, $dbpass, $dbname);
	
		if($conn->connect_error)
		{
			die("Connection failed:" .$conn->connect_error);
		}
		else
		{
			echo("Connected to Database");
		}
		$sql = "INSERT INTO notice(date,tittle,comment) VALUES 
		('".$date."','".$tittle."','".$comment."')";
		if($conn->query($sql) == TRUE)
		{
			header("Location: noticeboard.php");

		}
		else
		{
			echo "Error:" .$sql."<br>".$conn->error;
		}
		$conn->close();
	}
	
?>
