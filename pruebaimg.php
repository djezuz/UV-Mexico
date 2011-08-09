<?php
// define a constant for the maximum upload size
define ('MAX_FILE_SIZE', 1024 * 50);

if (array_key_exists('upload', $_POST)) {
  // define constant for upload folder
  define('UPLOAD_DIR', '/path/to/images/');
  // replace any spaces in original filename with underscores
  $file = str_replace(' ', '_', $_FILES['image']['name']);
  // create an array of permitted MIME types
  $permitted = array('image/gif', 'image/jpeg', 'image/pjpeg',
'image/png');
  
  // upload if file is OK
  if (in_array($_FILES['image']['type'], $permitted)
      && $_FILES['image']['size'] > 0 
      && $_FILES['image']['size'] <= MAX_FILE_SIZE) {
    switch($_FILES['image']['error']) {
      case 0:
        // check if a file of the same name has been uploaded
        if (!file_exists(UPLOAD_DIR . $file)) {
          // move the file to the upload folder and rename it
          $success =
move_uploaded_file($_FILES['image']['tmp_name'], UPLOAD_DIR .
$file);
        } else {
          $result = 'A file of the same name already exists.';
        }
        if ($success) {
          $result = "$file uploaded successfully.";
        } else {
          $result = "Error uploading $file. Please try again.";
        }
        break;
      case 3:
      case 6:
      case 7:
      case 8:
        $result = "Error uploading $file. Please try again.";
        break;
      case 4:
        $result = "You didn't select a file to be uploaded.";
    }
  } else {
    $result = "$file is either too big or not an image.";
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<form action="" method="post" enctype="multipart/form-data"
name="uploadImage" id="uploadImage">
<p>
  <input type="hidden" name="MAX_FILE_SIZE" 
    value="<?php echo MAX_FILE_SIZE; ?>" />
  <label for="image">Upload image:</label>
  <input type="file" name="image" id="image" />
</p>
<p>
  <input type="submit" name="upload" id="upload" 
value="Upload" />
</p>
</form>
</body>
</html>