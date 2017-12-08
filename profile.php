<?php
ob_start();
@session_start();
include('./config.php');
$UserID = $_SESSION['bruger_info']['ID'];
$Name = $_SESSION['bruger_info']['Name'];
if($_SERVER["REQUEST_METHOD"] == "POST") {
    if(!empty($_POST['posting']))
    {
      $Post = mysqli_real_escape_string($db,$_POST['post']);
      $PlaceID = 1;
      $sql = "INSERT INTO Status (Content, UserID, PlaceID) VALUES ('$Post', '$UserID', '$PlaceID')";
      $result = mysqli_query($db,$sql);
      //header('Location: ./index.php');
    }
    
    if(!empty($_POST['commenting'])) 
    {
        $Comment = mysqli_real_escape_string($db,$_POST['comment']);
        $StatusID = mysqli_real_escape_string($db,$_POST['StatusID']);
        $sql = "INSERT INTO Comments (Content, UserID, StatusID) VALUES ('$Comment', '$UserID', '$StatusID')";
        $result = mysqli_query($db,$sql);
        //header('Location: ./index.php');
    }
    if(!empty($_POST['addFriend']))
    {
        $PersonID = mysqli_real_escape_string($db,$_POST['PersonID']);
        $sql = "INSERT INTO Friends (UserID, FriendID) VALUES ('$UserID', '$PersonID')";
        $result = mysqli_query($db,$sql);
    }
    if(!empty($_POST['removeFriend']))
    {
        $PersonID = mysqli_real_escape_string($db,$_POST['PersonID']);
        $sql = "select * from Friends where UserID =".$UserID." AND FriendID =".$PersonID;
        $query = mysqli_query($db,$sql);
        $intQuery = mysqli_num_rows($query);
        if($intQuery== true){
            $row=mysqli_fetch_array($query);
     
            if($_SESSION['bruger_info']['ID'] == $row['UserID'])
            {
            $sql = "delete from Friends where ID = ".$row['ID'];
            mysqli_query($db,$sql);
            }
        }
    }
}
if (isset($_SESSION['bruger_info']))
{
    if(isset($_GET['Person']))
    {
        $PersonID = (int)$_GET['Person'];
    }
    else if (isset($_GET['person']))
    {
        $PersonID = (int)$_GET['person'];
    }
    else
    {
        $PersonID = $UserID;
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
</div>
<div id="Page">
    <div id="Left">
        <div id="infoBox">
        <div class="title">Info:</div>
<?php
            
?>
        </div>
        <div id="friendBox">
            <div class="title">Friends:</div>
            <div class="friendView">
<?php
                $sqlFriends = "select Friends.FriendID, Users.ProfilePhoto from Friends INNER JOIN Users ON Friends.UserID = Users.ID WHERE UserID = '".$PersonID."' ORDER BY RAND() limit 5";
                $sqlQueryFriends = mysqli_query($db,$sqlFriends);
                while($dbFetchFriends = mysqli_fetch_array($sqlQueryFriends))
                {
                    $sqlFriendCheck = "select * from Friends WHERE UserID = '".$dbFetchFriends['FriendID']."' AND FriendID = '".$PersonID."'";
                    $sqlQueryFriendCheck = mysqli_query($db,$sqlFriendCheck);
                    if ($dbFetchFriendCheck = mysqli_fetch_array($sqlQueryFriendCheck))
                    {
                    echo '<a href="./profile.php?person='.$dbFetchFriends['FriendID'].'"><div class="friend-profile-pic" style="background-image: url(//localhost/social/uploads/photos/profile/' . $dbFetchFriends['ProfilePhoto'] . ')" >
                        </div></a>';
                    }
                }
?>      
            </div>
        </div>
    </div>
    <div id="Middle">
<?php
        if (isset($_SESSION['bruger_info']))
        {
            if(isset($PersonID))
            {
                $sqlPerson = "select * from Users WHERE ID = '".$PersonID."'";
                $sqlQueryPerson = mysqli_query($db,$sqlPerson);
                $dbFetchPerson = mysqli_fetch_array($sqlQueryPerson);

                echo '<div id="feedbox">';
                echo '
                <a href="#" class="profile-pic">
                <div id="profile-pic-box">
                <div class="profile-pic" style="background-image: url(//localhost/social/uploads/photos/profile/' . $dbFetchPerson['ProfilePhoto'] . ')" >
            
                    <span class="glyphicon glyphicon-camera"></span>
                    <span>Change Image</span>
            
                </div></div>
            </a>&nbsp;<div id="ProfileName">'. $dbFetchPerson['Name'].'</div>
                ';

                if ($PersonID != $UserID)
                {
                    $sqlFriend = "select * from Friends WHERE UserID = '".$UserID."' AND FriendID = '".$PersonID."'";
                    $sqlQueryFriend = mysqli_query($db,$sqlFriend);
                    $dbFetchFriend = mysqli_fetch_array($sqlQueryFriend);

                    $sqlFriendCheck = "select * from Friends WHERE UserID = '".$PersonID."' AND FriendID = '".$UserID."'";
                    $sqlQueryFriendCheck = mysqli_query($db,$sqlFriendCheck);
                    $dbFetchFriendCheck = mysqli_fetch_array($sqlQueryFriendCheck);

                    if ($dbFetchFriend && $dbFetchFriendCheck)
                    {
                            echo "
                            <form method='post'>
                            <input type='hidden' name='PersonID' value='".$dbFetchPerson['ID']."'>
                            <div id='buttonbox'>
                            <input class='button' type='submit' name='removeFriend' value='Remove Friend'> 
                            </div>
                            </form>
                            ";
                    }
                    else if ($dbFetchFriend && !$dbFetchFriendCheck)
                    {
                            echo "
                            <form method='post'>
                            <input type='hidden' name='PersonID' value='".$dbFetchPerson['ID']."'>
                            <div id='buttonbox'>
                            <input class='button' type='submit' name='removeFriend' value='UnFollow'> 
                            </div>
                            </form>
                            ";
                    }
                    else if (!$dbFetchFriend && $dbFetchFriendCheck)
                    {
                        echo "
                        <form method='post'>
                        <input type='hidden' name='PersonID' value='".$dbFetchPerson['ID']."'>
                        <div id='buttonbox'>
                        <input class='button' type='submit' name='addFriend' value='Accept Friend Request'> 
                        </div>
                        </form>
                        ";
                    }
                    else if (!$dbFetchFriend && !$dbFetchFriendCheck)
                    {
                        echo "
                        <form method='post'>
                        <input type='hidden' name='PersonID' value='".$dbFetchPerson['ID']."'>
                        <div id='buttonbox'>
                        <input class='button' type='submit' name='addFriend' value='Add Friend'> 
                        </div>
                        </form>
                        ";
                    }
                }

                echo "
                    <form method='post'>
                        <textarea name='post' placeholder='Write your post here...'></textarea>
                        <input class='button' type='submit' name='posting' value='Post'>   
                    </form>
                ";

                //$sqlStatus = "select * from Status ORDER BY ID desc";
                $sqlStatus = "select Status.ID, Status.UserID, Status.Content, Users.Name, Users.ProfilePhoto from Status INNER JOIN Users ON Status.UserID = Users.ID where UserID = '".$PersonID."' AND Status.PlaceID = 1 ORDER BY Status.ID desc";
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

                    if($dbFetchStatus['UserID'] == $PersonID)
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