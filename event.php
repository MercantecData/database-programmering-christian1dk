<?php
ob_start();
@session_start();
include('./config.php');
$UserID = $_SESSION['bruger_info']['ID'];
if (isset($_SESSION['bruger_info']))
{
    if(isset($_GET['id']))
    {
        $EventID = (int)$_GET['id'];
    }
    else if (isset($_GET['ID']))
    {
        $EventID = (int)$_GET['ID'];
    }
    else if (isset($_GET['Id']))
    {
        $EventID = (int)$_GET['Id'];
    }
    else if (isset($_GET['iD']))
    {
        $EventID = (int)$_GET['iD'];
    }
}
if($_SERVER["REQUEST_METHOD"] == "POST") {
    if(!empty($_POST['posting']))
    {
      $Post = mysqli_real_escape_string($db,$_POST['post']);
      $PlaceID = 3;
      $sql = "INSERT INTO Status (Content, UserID, PlaceID, EventID) VALUES ('$Post', '$UserID', '$PlaceID', '$EventID')";
      $result = mysqli_query($db,$sql);
      //header('Location: ./index.php');
    }
    
    if(!empty($_POST['commenting'])) 
    {
        $Comment = mysqli_real_escape_string($db,$_POST['comment']);
        $StatusID = mysqli_real_escape_string($db,$_POST['StatusID']);
        $sql = "INSERT INTO Comments (Content, UserID, StatusID) VALUES ('$Comment', '$User', '$StatusID')";
        $result = mysqli_query($db,$sql);
        //header('Location: ./index.php');
    }
}
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


    </div>
    <div id="Middle">
        <div id="feedbox">
<?php
        if (isset($_SESSION['bruger_info']))
        {
            $sqlEvents = "select Events.ID, Events.Title, Events.Description, Events.Start_Date, Events.End_Date, Users.Name from Events INNER JOIN Users ON Events.UserID = Users.ID WHERE Events.ID = '".$EventID."'";
            $sqlQueryEvents = mysqli_query($db,$sqlEvents);
            if($dbFetchEvents = mysqli_fetch_array($sqlQueryEvents))
            {
                echo '
                <div id="PageName">'. $dbFetchEvents['Title'].'</div>
                <div>'.$dbFetchEvents['Description'].'</div>
                <div>Created By: '.$dbFetchEvents['Name'].'</div>
                <div>Start Date: '.$dbFetchEvents['Start_Date'].'</div>
                ';
                if(!empty($dbFetchEvents['End_Date'])){
                    echo '<div>End Date: '.$dbFetchEvents['End_Date'].'</div>';
                }
                echo '
                </a>
                ';
            }

            echo "
            <br>
            <form method='post'>
                <textarea name='post' placeholder='Write your post here...'></textarea>
                <input class='button' type='submit' name='posting' value='Post'>   
            </form>
        ";

        //$sqlStatus = "select * from Status ORDER BY ID desc";
        $sqlStatus = "select Status.ID, Status.UserID, Status.Content, Users.Name, Users.ProfilePhoto from Status INNER JOIN Users ON Status.UserID = Users.ID where EventID = '".$EventID."' AND Status.PlaceID = 3 ORDER BY Status.ID desc";
        $sqlQueryStatus = mysqli_query($db,$sqlStatus);
        while($dbFetchStatus = mysqli_fetch_array($sqlQueryStatus))
        {
            echo '
                <div id="postbox">
                <div id="post">
                    <div id="name">
                    <div class="small-profile-pic" style="background-image: url(//localhost/social/uploads/photos/profile/' . $dbFetchStatus['ProfilePhoto'] . ')" >
                    </div>&nbsp;<a href="./profile.php?person='.$dbFetchStatus['UserID'].'">'.$dbFetchStatus['Name'].'</a>
                    </div>
                    <div id="content">
                    '.$dbFetchStatus['Content'].'
                    </div>
            ';

            if($dbFetchStatus['UserID'] == $UserID)
            {
                echo '<div id="buttonbox">';
                echo "
                <button><a href='./Edit.php?Status=".$dbFetchStatus['ID']."' class='editbtn'>Edit</a></button> 
        
                <button><a onClick=\"javascript: return confirm('Are you sure you want to delete this post?');\" 
                href='./delete.php?post=".$dbFetchStatus['ID']."' class='editbtn'>Delete</a></button>
                ";

                echo '</div>';
            }
            echo '
                </div>
            </div>
            <div id="commentbox">
                <div id="comment">
            ';

            echo "
            <form method='post'>
                <input type='hidden' name='StatusID' value='".$dbFetchStatus['ID']."'>
                <textarea name='comment' placeholder='Write your comment here...'></textarea>
                <div id='buttonbox'>
                <input class='button' type='submit' name='commenting' value='Post'> 
                </div>
            </form>
            ";
            $sqlComments = "select Comments.ID, Comments.Content, Comments.StatusID, Comments.UserID, Users.Name, Users.ProfilePhoto from Comments INNER JOIN Users ON Comments.UserID = Users.ID WHERE StatusID = ".$dbFetchStatus['ID']." ORDER BY Comments.ID asc";
            $sqlQueryComments = mysqli_query($db,$sqlComments);
            while($dbFetchComments = mysqli_fetch_array($sqlQueryComments))
            {

                echo '
                    <hr>
                    <div id="comment">
                        <div id="name">
                        <div class="small-profile-pic" style="background-image: url(//localhost/social/uploads/photos/profile/' . $dbFetchComments['ProfilePhoto'] . ')" >
                        </div>&nbsp;<a href="./profile.php?person='.$dbFetchComments['UserID'].'">'.$dbFetchComments['Name'].'</a>
                        </div>
                        <div id="content">
                            '.$dbFetchComments['Content'].'
                        </div>
                    </div>
                ';

                if($dbFetchComments['UserID'] == $PersonID)
                {
                    echo '<div id="commentbuttonbox">';
                    echo "
                    <button><a href='./Edit.php?Comment=".$dbFetchComments['ID']."' class='editbtn'>Edit</a></button> 
            
                    <button><a onClick=\"javascript: return confirm('Are you sure you want to delete this post?');\" 
                    href='./delete.php?post=".$dbFetchComments['ID']."' class='editbtn'>Delete</a></button>
                    ";

                    echo '</div>';
                }

            }

            echo "</div></div><br>";
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
<?php
    echo '<div id ="responseBox">';
    echo '<div class="title">Responses:</div>';

    echo '<div class="title">Going:</div>';
    $sqlResponses = "select Event_Users.EventID, Event_Users.ResponseID, Event_Users.UserID, Users.ID, Users.ProfilePhoto from Event_Users INNER JOIN Event_Responses ON Event_Users.ResponseID = Event_Responses.ID INNER JOIN Users ON Event_Users.UserID = Users.ID WHERE EventID = '".$EventID."' ORDER BY RAND() limit 5";
    $sqlQueryResponses = mysqli_query($db,$sqlResponses);
    while($dbFetchResponses = mysqli_fetch_array($sqlQueryResponses))
    {
        echo '<a href="./profile.php?person='.$dbFetchResponses['ID'].'"><div class="friend-profile-pic" style="background-image: url(//localhost/social/uploads/photos/profile/' . $dbFetchResponses['ProfilePhoto'] . ')" >
            </div></a>';
    }
    echo '</div>';
?>
    </div>
</div>
</body>
</html>