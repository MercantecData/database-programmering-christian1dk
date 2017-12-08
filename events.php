<?php
ob_start();
@session_start();
include('./config.php');
?>
<html>
<head>
<title></title>
<link rel="stylesheet" href="css/style.css">
</head>
<body>
<div id="Header">
    <div id ="Menu">
<?php
    include('menu.php');
?>
    </div>
</div>
<div id="Page">
    <div id="Left">
        <div id="MenuBox">
            <a class="floatLeft" href="./add.php?event">Create Event</a>
        </div>

    </div>
    <div id="Middle">
        <div id="FullContent">
<?php
        if (isset($_SESSION['bruger_info']))
        {
            $sqlEvents = "select Events.ID, Events.Title, Events.Start_Date, Events.End_Date, Users.Name from Events INNER JOIN Users ON Events.UserID = Users.ID ORDER BY Start_Date";
            $sqlQueryEvents = mysqli_query($db,$sqlEvents);
            while($dbFetchEvents = mysqli_fetch_array($sqlQueryEvents))
            {
                echo '<a href="event.php?id='.$dbFetchEvents['ID'].'">
                <div id="Box">
                    <div>Title: '.$dbFetchEvents['Title'].'</div>
                    <div>Created By: '.$dbFetchEvents['Name'].'</div>
                    <div>Start Date: '.$dbFetchEvents['Start_Date'].'</div>
                    ';
                if(!empty($dbFetchEvents['End_Date'])){
                    echo '<div>End Date: '.$dbFetchEvents['End_Date'].'</div>';
                }
                echo '
                </div></a>  
                ';
            }
        }
        else
        {
            header('Location: ./login.php');
            exit();
        }
        ?>
    </div></div>
    <div id="Right">
    </div>
</div>
</body>
</html>