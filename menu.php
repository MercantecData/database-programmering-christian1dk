<?php
    if (isset($_SESSION['bruger_info']))
    {
        echo '<a class="floatLeft" href="./">Home</a>';
        echo '<a class="floatLeft" href="./profile.php">Profile</a>';
        echo '<a class="floatLeft" href="./events.php">Events</a>';
    }
    else
    {
       echo '<a class="floatLeft" href="./">Home</a>';
       echo '<a class="floatLeft" href="./add.php?user">Join</a>';
    }

    if (isset($_SESSION['bruger_info']))
    {
        echo '<a class="floatRight" href="./logud.php">Logud</a>';
    }
    else
    {
       echo '<a class="floatRight" href="./login.php">Login</a>';
    }
?>