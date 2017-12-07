<?php include("config.php");
@session_start();

  if($_SERVER["REQUEST_METHOD"] == "POST") {
    if($_POST['passwd'] == $_POST['passwd2']){
      $uname = mysqli_real_escape_string($db,$_POST['uname']);
      $hash = password_hash($_POST['passwd'], PASSWORD_DEFAULT);
      $password = mysqli_real_escape_string($db, $hash);
      $Name = mysqli_real_escape_string($db,$_POST['Name']);
      $sql = "INSERT INTO Users (Username, Password, Name, Level) VALUES ('$uname', '$password', '$Name', 0)";
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
        <form method="post">
          <div class="row">
          <div class="u-full-width">
              <label>Navn</label>
              <p>Indtast Navn</p>
              <input class="addufield" type="text" 
                     <?php if(!empty($pwerror)){$Name = $_POST['Name']; echo 'value="'.$Name.'"';}?> maxlength="100" name="Name" required>
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

<!-- End Document
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
</body>
</html>