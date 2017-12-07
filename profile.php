<?php
ob_start();
@session_start();
include('./config.php');
$User = $_SESSION['bruger_info']['ID'];
$Name = $_SESSION['bruger_info']['Name'];

if($_SERVER["REQUEST_METHOD"] == "POST") {
      $Post = mysqli_real_escape_string($db,$_POST['post']);
      $sql = "INSERT INTO Posts (Content, UserID) VALUES ('$Post', '$User')";
      $result = mysqli_query($db,$sql);
      //header('Location: ./index.php');
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
    echo '<div id="feedbox">';
    echo "Welcome ". $Name;

    echo "
        <form method='post'>
            <textarea name='post' placeholder='Write your post here...'></textarea>
            <input class='button' type='submit' name='posting' value='Post'>   
        </form>
    ";

    //$sqlStatus = "select * from Status ORDER BY ID desc";
    $sqlStatus = "select Status.ID, Status.UserID, Status.Content, Users.Name from Status INNER JOIN Users ON Status.UserID = Users.ID where UserID = '".$User."' ORDER BY Status.ID desc";
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

        if($dbFetchStatus['UserID'] == $User)
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

            if($dbFetchComments['UserID'] == $User)
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
</body>
</html>