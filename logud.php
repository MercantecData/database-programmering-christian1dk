<?php
ob_start();
@session_start();
include('config.php');
?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="da">
<head>

    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, shrink-to-fit=no, initial-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title></title>
    <link rel="stylesheet" href="css/style.css" />
	<style> 
</style>
</head>
<body>

<?php
if(isset($_SESSION['bruger_info']['ID'])){
	session_unset();
	session_destroy();
	@header('location: ./index.php');
	exit();
}
else
{
	@header('location: ./index.php');
	exit();
}
?>
</body>

</html>