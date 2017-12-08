<?php
ob_start();
session_start();
include('config.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, shrink-to-fit=no, initial-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <link rel="stylesheet" href="/css/style.css" />
</head>

<body>
<?php
if(isset($_SESSION['bruger_info']) && $_SESSION['bruger_info']['Level'] == "1")
{
	
}
else if(isset($_SESSION['bruger_info']) && $_SESSION['bruger_info']['Level'] == "2")
{

}
else
{
	//@header('Location: ./index.php');
	//exit;
}

if(isset($_GET['post']))
{
    $StatusID = $_GET['post'];
}
if(isset($_GET['comment']))
{
    $CommentID = $_GET['comment'];
}
	
	
if(isset($_GET['post']))
{ 
    $sql = "select * from Status where ID =".$StatusID;
    $query = mysqli_query($db,$sql);
    $intQuery = mysqli_num_rows($query);
    if($intQuery== true){
        $row=mysqli_fetch_array($query);
 
        if($_SESSION['bruger_info']['ID'] == $row['UserID'])
        {
        $sql = "delete from Status where ID = ".$StatusID;
        mysqli_query($db,$sql);
        

        $sql = "delete from Comments where StatusID = ".$StatusID;
        mysqli_query($db,$sql);

        @header('Location: ./index.php');
        exit;
        }
        else
        {
            @header('Location: ./index.php');
            exit;
        }
    }
}
else if (isset($_GET['comment']))
{
    $sql = "select * from Comment where ID =".$CommentID;
    $query = mysqli_query($db,$sql);
    $intQuery = mysqli_num_rows($query);
    if($intQuery== true){
        $row=mysqli_fetch_array($query);        

        if($_SESSION['bruger_info']['ID'] == $row['UserID'])
        {
        $sql = "delete from Comment where ID = ".$CommentID;
        mysqli_query($db,$sql);

        @header('Location: ./index.php');
        exit;
        }
        else
        {
            @header('Location: ./index.php');
            exit;
        }
    }
}

?>
</body>

</html>