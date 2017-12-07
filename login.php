<?php
ob_start();
@session_start();
include('./config.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>

  <!-- Basic Page Needs
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <meta charset="utf-8">
  <title>Login</title>
  <meta name="description" content="">
  <meta name="author" content="">

  <!-- CSS
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <link rel="stylesheet" href="css/style.css">

  <!-- Favicon
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <link rel="icon" type="image/png" href="images/favicon.png">
</head>
<!--<header style="font-size: 30px; margin-left: 55px;"><b>Login</b></header> -->

<body>
<!-- background-color: darkgrey; border-radius: 5px-->
<?php
  ob_start();
if(!isset($_SESSION['bruger_info']['ID'])){
		echo "
          <div class='feedbox'>
    <div class='row' id='header'>
      <div class='one-third column u-pull-left'><a href='om.php'><p class='headbtn'>Opret Bruger</p></a></div>
      <div class='one-third column'>
        <div id='logobox'><a href='./index.php'><p id='logo'>Home</p></a></div>
      </div>
    </div>
	  <div name='login_form' style='margin-top: 90px; text-align: center;'>
		<form class='login-form' method='post' style='padding: 12px 20px; border-radius: 5px; width: 450px; margin: 0 auto;'>
		  <h1 class='login-title' style='text-align:center;'><b>Log ind</b></h1>
		  <div class='form-group'>
		  <input type='text' name='Username' style='width: 200px' value='' placeholder='Username' required autofocus /> 
		  </div>
		  <div class='form-group'>
		  <input type='password' name='Password' style='width: 200px;' value='' placeholder='Password' required /> 
		  </div>
		  <input type='submit' class='button button-primary login-submit' name='loginsubmit' value='Login' />
		  </form><br />
		</div>
      </div>
		";
	}else{
		header('Location: ./index.php');
		exit();	
	}
	
	if(isset($_POST['loginsubmit'])){
		$Username = mysqli_real_escape_string($db,$_POST['Username']);
		
		$sqlVerify = "select Password from Users where Username = '".$Username."'";
		$sqlQueryVerify = mysqli_query($db,$sqlVerify);
		$dbFetchVerify = mysqli_fetch_array($sqlQueryVerify);
		if (password_verify($_POST['Password'], $dbFetchVerify['Password']))
		{
		
			$sql = "select * from Users where Username = '".$Username."'";
			$sqlQuery = mysqli_query($db,$sql);
			
			$intQuery = mysqli_num_rows($sqlQuery);
			if($intQuery == true){

				$_SESSION['bruger_info'] = mysqli_fetch_array($sqlQuery);
				unset($_SESSION['bruger_info']['Password']);

				header('Location: ./index.php');
				exit();

			}
		}
	}
?>
</body>

</html>