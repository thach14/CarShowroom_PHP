<?php 
extract($_POST);

$countfiles = count($_FILES['file']['name']);



?>

<form method='post' action='' enctype='multipart/form-data'>
 
 <input type="file" name="file[]" id="file" multiple>
 <input type='submit' name='submit' value='Upload'>

</form>