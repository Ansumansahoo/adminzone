<?php
			session_start();
			$adminid = $password1= "";
			if($_SERVER["REQUEST_METHOD"] == "POST") {
				$adminid = $_POST["adminid"];
				$password1 = $_POST["password1"];
			
			// Initialize the parameters
				$servername = "localhost";
				$username = "root";
				$dbname = "social";
				
				//Create Connection
				$conn = new mysqli($servername, $username,null, $dbname);
				
				// Check connection
				if ($conn->connect_error) {
					die("Connection failed: " . $conn->connect_error);
				}
				
				$sql = "SELECT * FROM register WHERE adminid ='$adminid' AND password1 = '$password1'";
				$result = $conn->query($sql);

				if ($result->num_rows > 0) {
					//converting the result to associative array
					$record = $result->fetch_assoc();
					//setting session for login
					$_SESSION["loggedIn"] = true;
					//setting the session for user id
					$_SESSION["loggedInUserId"] = $record["id"];
					header("Location: noticetextboard.php");
				} else {
					$message = "Invalid Credentials";
					echo "<script type='text/javascript'>alert('$message');</script>";
					
				}
				
			}
		?>