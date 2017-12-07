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

</head>
<body>
<?php
if (isset($_SESSION['bruger_info']))
{
    echo "Welcome ". $Name;

    echo "
        <form method='post'>
            <textarea name='post' placeholder='Write your post here...'></textarea>
            <input class='button' type='submit' value='Post'>   
        </form>
    ";

    $sqlPosts = "select * from Posts where UserID = '".$User."'";
    $sqlQueryPosts = mysqli_query($db,$sqlPosts);
    while($dbFetchPosts = mysqli_fetch_array($sqlQueryPosts))
    {
        echo "<div>";
        echo "$Name: <br>";
        echo $dbFetchPosts['Content'];
        echo "</div><br>";
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
