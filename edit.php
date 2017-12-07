<?php
@session_start();
ob_start();
include('config.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>

  <!-- Basic Page Needs
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <meta charset="utf-8">
  <title>Rediger</title>
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

  <!-- Primary Page Layout
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <div class="feedbox">
<h1><p><b>Rediger</b></p></h1>

<?php
//if(isset($_SESSION['bruger_info']) && $_SESSION['bruger_info']['Level'] == "1")
if(isset($_SESSION['bruger_info']))
{
    if(isset($_GET['Status']))
    {
        $StatusID = (int)$_GET['Status'];
        $sql = "select * from Status where ID =".$StatusID;
        $query = mysqli_query($db,$sql);
        $intQuery = mysqli_num_rows($query);
        
        if(isset($_POST['postStatus'])){
		$Content = mysqli_real_escape_string($db,$_POST['Content']);

		
		if(!empty($err)) {
				echo "<p>".implode("<br />",$err)."</p>";

		} else {
			$sql = "update Status set 
                                Content = '".$Content."'
								where ID = ".$StatusID;
								
		mysqli_query($db,$sql);
		@header('Location: ./index.php');
		//exit;
        }
    }
        if($intQuery== true){
            $row=mysqli_fetch_array($query);

            $Content = $row['Content'];

            echo '<div id="feedbox">';

            echo "
            <form method='post'  enctype='multipart/form-data'>
                <input type='hidden' name='ID' value='".$StatusID."' />

                <textarea name='Content' placeholder='Write your post here...'>".$row['Content']."</textarea>
                
                <hr>
                <input class='admbtn'type='submit' name='postStatus' value='Gem'>
                <a href='./index.php' class='admbtn'>Tilbage</a>
        
            </form>";

            echo '</div>';
        }
    }

    if(isset($_GET['Comment']))
    {
        $CommentID = (int)$_GET['Comment'];
        $sql = "select * from Comments where ID =".$CommentID;
        $query = mysqli_query($db,$sql);
        $intQuery = mysqli_num_rows($query);
        
        if(isset($_POST['postComment'])){
		$Content = mysqli_real_escape_string($db,$_POST['Content']);

		
		if(!empty($err)) {
				echo "<p>".implode("<br />",$err)."</p>";

		} else {
			$sql = "update Comments set 
                                Content = '".$Content."'
								where ID = ".$CommentID;
								
		mysqli_query($db,$sql);
		@header('Location: ./index.php');
		//exit;
        }
    }
        if($intQuery== true){
            $row=mysqli_fetch_array($query);

            $Content = $row['Content'];

            echo '<div id="feedbox">';

            echo "
            <form method='post'  enctype='multipart/form-data'>
                <input type='hidden' name='ID' value='".$CommentID."' />

                <textarea name='Content' placeholder='Write your post here...'>".$row['Content']."</textarea>
                
                <hr>
                <input class='admbtn'type='submit' name='postComment' value='Gem'>
                <a href='./index.php' class='admbtn'>Tilbage</a>
        
            </form>";

            echo '</div>';
        }
    }
}


 if(!empty($_REQUEST['back'])) 
{
	@header('Location: ./index.php');
	exit;
}
	?>
  </div>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" ></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script  src="js/codepen.js"></script>
</body>
</html>