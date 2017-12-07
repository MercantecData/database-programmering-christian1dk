<?php include("config.php");
@session_start();

  if($_SERVER["REQUEST_METHOD"] == "POST") {
    if($_POST['passwd'] == $_POST['passwd2']){
      $uname = mysqli_real_escape_string($db,$_POST['uname']);
      $hash = password_hash($_POST['passwd'], PASSWORD_DEFAULT);
      $password = mysqli_real_escape_string($db, $hash);
      $Name = mysqli_real_escape_string($db,$_POST['Name']);

      foreach($_FILES['fil']['name'] as $key => $value){
        $ProfilePhoto = upload_image($key);
      }

      $sql = "INSERT INTO Users (Username, Password, Name, ProfilePhoto, Level) VALUES ('$uname', '$password', '$Name', '$ProfilePhoto', 0)";
      $result = mysqli_query($db,$sql);
      }
    else {
        $pwerror = '<p style="color:red;">Kodeordene er ikke éns. Pr&oslash;v igen.</p>';
    }
}
$db->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>

  <!-- Basic Page Needs
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <meta charset="utf-8">
  <title>Opret Bruger</title>
  <meta name="description" content="">
  <meta name="author" content="">


  <!-- CSS
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <link rel="stylesheet" href="css/style.css">

  <!-- Favicon
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <link rel="icon" type="image/png" href="images/favicon.png">

</head>
<body>
      <div id="feedbox">
        <h5>Opret Bruger</h5>
        <form method="post" enctype="multipart/form-data">
          <div class="row">
          <div class="u-full-width">
              <label>Navn</label>
              <p>Indtast Navn</p>
              <input class="addufield" type="text" 
                     <?php if(!empty($pwerror)){$Name = $_POST['Name']; echo 'value="'.$Name.'"';}?> maxlength="100" name="Name" required>
            </div>
            <div class="u-full-width">
              <label>Profile Image</label>
<?php
              echo '<input type="file" id="id" name="fil[]" />
                    <p id="id">Drag din file her eller klik i denne område.</p>';
?>
              </div>
              <div class="u-full-width">
              <label>Brugernavn</label>
              <p>Indtast brugernavn</p>
              <input class="addufield" type="text" 
                     <?php if(!empty($pwerror)){$uname = $_POST['uname']; echo 'value="'.$uname.'"';}?> maxlength="100" name="uname" required>
            </div>
            <div class="u-full-width">
              <label>Password</label>
              <p>Indtast password</p>
              <input class="addufield" type="password" maxlength="50" name="passwd" required>
                <?php if(!empty($pwerror)){echo $pwerror;}?>
            </div>
            <div class="u-full-width">
              <label>Password</label>
              <p>Indtast password igen</p>
              <input class="addufield" type="password" maxlength="50" name="passwd2" required>
            </div>
            <input class="button" type="submit" value="Gem">
          </div>
        </form>
        <a class="button button-primary" href="index.php">Tilbage</a>
      </div>
    </div>
  </div>

  <?php
function upload_image($key){
  $filetypes = array('jpg','png','gif','jpeg');
  $folder = "uploads/photos/profile/";
  if(is_uploaded_file($_FILES['fil']['tmp_name'][$key])){
    $file_ext = strtolower(pathinfo($_FILES['fil']['name'][$key],PATHINFO_EXTENSION));
    if(in_array($file_ext,$filetypes)){
      $locktime = microtime();
      if(move_uploaded_file($_FILES['fil']['tmp_name'][$key],$folder.md5(basename($locktime.$_FILES['fil']['name'][$key])).".".$file_ext)){
        return md5(basename($locktime.$_FILES['fil']['name'][$key])).".".$file_ext;
      }
    }
  }
}


function open_image($file){
  $im = @imagecreatefromjpeg($file);
  if($im !== false){
    return $im;
  }
  $im = @imagecreatefromgif($file);
  if($im !== false){
    return $im;
  }
  $im = @imagecreatefrompng($file);
  if($im !== false){
    return $im;
  }
  $im = @imagecreatefromstring($file);
  if($im !== false){
    return $im;
  }
  return false;
}
?>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" ></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>

<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<!-- End Document
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
</body>
</html>