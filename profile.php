<?php
ob_start();
@session_start();
include('./config.php');
$UserID = $_SESSION['bruger_info']['ID'];
$Name = $_SESSION['bruger_info']['Name'];
if($_SERVER["REQUEST_METHOD"] == "POST") {
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
?>
<html>
<head>
<title></title>
<link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php
if (isset($_SESSION['bruger_info']))
{
    if(isset($_GET['Person'])||isset($_GET['person']))
    {
        if(isset($_GET['Person']))
        {
            $PersonID = (int)$_GET['Person'];
        }
        else if (isset($_GET['person']))
        {
            $PersonID = (int)$_GET['person'];
        }

        $sqlPerson = "select * from Users WHERE ID = '".$PersonID."'";
        $sqlQueryPerson = mysqli_query($db,$sqlPerson);
        $dbFetchPerson = mysqli_fetch_array($sqlQueryPerson);

        echo '<div id="feedbox">';
        echo "<h2>". $dbFetchPerson['Name']."</h2>";

        if ($PersonID != $UserID)
        {
            $sqlFriend = "select * from Friends WHERE UserID = '".$UserID."' AND FriendID = '".$PersonID."'";
            $sqlQueryFriend = mysqli_query($db,$sqlFriend);
            if ($dbFetchFriend = mysqli_fetch_array($sqlQueryFriend))
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
            else
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
        $sqlStatus = "select Status.ID, Status.UserID, Status.Content, Users.Name from Status INNER JOIN Users ON Status.UserID = Users.ID where UserID = '".$PersonID."' ORDER BY Status.ID desc";
        $sqlQueryStatus = mysqli_query($db,$sqlStatus);
        while($dbFetchStatus = mysqli_fetch_array($sqlQueryStatus))
        {
            echo '
                <div id="postbox">
                <div id="post">
                    <div id="name">
                    '.$dbFetchStatus['Name'].'
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
            $sqlComments = "select Comments.ID, Comments.Content, Comments.StatusID, Comments.UserID, Users.Name from Comments INNER JOIN Users ON Comments.UserID = Users.ID WHERE StatusID = ".$dbFetchStatus['ID']." ORDER BY Comments.ID asc";
            $sqlQueryComments = mysqli_query($db,$sqlComments);
            while($dbFetchComments = mysqli_fetch_array($sqlQueryComments))
            {

                echo '
                    <div id="comment">
                        <div id="name">
                            '.$dbFetchComments['Name'].'
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
        echo '<div id="feedbox">';
        echo "<h2>". $Name."</h2>";

        echo "
            <form method='post'>
                <textarea name='post' placeholder='Write your post here...'></textarea>
                <input class='button' type='submit' name='posting' value='Post'>   
            </form>
        ";

        //$sqlStatus = "select * from Status ORDER BY ID desc";
        $sqlStatus = "select Status.ID, Status.UserID, Status.Content, Users.Name from Status INNER JOIN Users ON Status.UserID = Users.ID where UserID = '".$UserID."' ORDER BY Status.ID desc";
        $sqlQueryStatus = mysqli_query($db,$sqlStatus);
        while($dbFetchStatus = mysqli_fetch_array($sqlQueryStatus))
        {
            echo '
                <div id="postbox">
                <div id="post">
                    <div id="name">
                    '.$dbFetchStatus['Name'].'
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
            $sqlComments = "select Comments.ID, Comments.Content, Comments.StatusID, Comments.UserID, Users.Name from Comments INNER JOIN Users ON Comments.UserID = Users.ID WHERE StatusID = ".$dbFetchStatus['ID']." ORDER BY Comments.ID asc";
            $sqlQueryComments = mysqli_query($db,$sqlComments);
            while($dbFetchComments = mysqli_fetch_array($sqlQueryComments))
            {

                echo '
                    <div id="comment">
                        <div id="name">
                            '.$dbFetchComments['Name'].'
                        </div>
                        <div id="content">
                            '.$dbFetchComments['Content'].'
                        </div>
                    </div>
                ';

                if($dbFetchComments['UserID'] == $UserID)
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
</body>
</html>