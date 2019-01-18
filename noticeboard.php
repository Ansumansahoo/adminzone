<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body {
  margin: 0;
  font-size: 28px;
  font-family: Arial, Helvetica, sans-serif;
}

.header {
  position: fixed;
  top: 0;
  z-index: 0.1;
  width: 100%;
  background-color: #f1f1f1;
}

.header h2 {
  text-align: center;
}

.progress-container {
  width: 100%;
  height: 600px;
  background: #4caf50;
}

.progress-bar {
  height: 300px;
  background: #4caf50;
  width: 100%;
  text-align: center;
}

.content {
  padding: 10px 0;
  margin: 50px auto 1  auto;
  width: 80%;
}
</style>
</head>
<body>
   

<div class="header">
   <div action="noticeboarddisplay.php" method="post">
  <h2>notice board</h2>
  <marquee direction="down" behavior=scroll scrollamount="15" onmouseleave="this.start();" onmouseover="this.stop();">
  <div class="progress-container">
    <div class="progress-bar" id="myBar">
       This text will scroll from bottom to up
        <br/>
        This text will scroll from bottom to up
        <br/>
        This text will scroll from bottom to up
        <br/>
        This text will scroll from bottom to up
        <br/>
        This text will scroll from bottom to up
        <br/>
        This text will scroll from bottom to up
        <br/>
        This text will scroll from bottom to up
        <br/>
        This text will scroll from bottom to up
        <br/>
        This text will scroll from bottom to up
        <br/>
        This text will scroll from bottom to up
        <br/>
        This text will scroll from bottom to up
        <br/>
        This text will scroll from bottom to up
        <br/>
        </div>
  </div>  
</div>
</marquee>

<div class="content">
  
</div>


<script>
// When the user scrolls the page, execute myFunction 
window.onscroll = function() {myFunction()};

function myFunction() {
  var winScroll = document.body.scrollTop || document.documentElement.scrollTop;
  var height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
  var scrolled = (winScroll / height) * 100;
  document.getElementById("myBar").style.width = scrolled + "%";
}
</script>

</body>
</html> 
