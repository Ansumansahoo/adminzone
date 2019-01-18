<!DOCTYPE HTML>  
<html>
<head>
<style>
.error {color: #FF0000;}
</style>
</head>
<body>  

<?php
// define variables and set to empty values
$date = $tittle = $comment =  "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["date"])) {
   $date = "";
  } else {
    $date = test_input($_POST["date"]);
    // check if name only contains letters and whitespace
    
  }
    if (empty($_POST["tittle"])) {
    $tittle = "";
  } else {
    $tittle = test_input($_POST["tittle"]);
  }
  
  if (empty($_POST["comment"])) {
    $comment = "";
  } else {
    $comment = test_input($_POST["comment"]);
  }

  
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>
<div id="id01" class="a">
  <form class="" action="storenotice.php" method="post">
    <div class="container">
<h2>notice text board</h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 

date: <input type="date" name="date" value="<?php echo $date;?>"><br><br>

  tittle: <textarea name="tittle" rows="10" cols="20"><?php echo $tittle;?></textarea>
  <br><br>
 
  Comment: <textarea name="comment" rows="50" cols="100"><?php echo $comment;?></textarea>
  <br><br>
  
</form>
  </p>
  <input type="submit" name="submit" value="Submit">  
</form>
<script>
function myFunction() {
  var checkBox = document.getElementById("myCheck");
  var text = document.getElementById("text");
  if (checkBox.checked == true){
    text.style.display = "block";
  } else {
     text.style.display = "none";
  }
}
</script>
</body>
</html>