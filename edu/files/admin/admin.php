<?
	if(!isset($_SESSION))
		session_start();
	require './../lib/db.php';
	if(isset($_SESSION['login']) && $_SESSION['login'] == true && isset($_SESSION['status']) && ($_SESSION['status'] == 1 || $_SESSION['status'] == 2)){
		require 'panel.php';
	}else{
		header('Location:/');
	}
	mysqli_close($connect);
?>