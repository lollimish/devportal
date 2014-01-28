<html>
<head>
<title>File Uploading Form</title>
</head>
<body>
<h3>File Upload:</h3>
Select a file to upload: <br />
<form action="upload.php" method="post" enctype="multipart/form-data"> 
 <input type="file" name="myFile">
 <br>
 <input type="submit" value="Upload">
</form>
<?php
if(isset($_POST["msg"])){
    var_dump($_POST);
}
?>
</body>
</html>