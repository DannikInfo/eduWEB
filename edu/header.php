<?
	if(!isset($_SESSION)){
		session_start();
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>SibSAU students</title>
		<link href="files/system/css/bootstrap.min.css" rel="stylesheet"> 
		<link href="//wolfeco.ru/files/admin/css/styles.css" rel="stylesheet">
		<link href="//wolfeco.ru/files/admin/css/font-awesome.min.css" rel="stylesheet">
		<link href="files/system/css/styles.css" rel="stylesheet">
		<script src="files/system/js/jquery-3.2.1.min.js"></script>
		<script src="files/profile/profile.js"></script>
	</head>
	<body>
		<?if(isset($_SESSION['login']) && $_SESSION['login']){?>
		<div class="wrapper navFix header">
			<nav class="nav navfix" role="navigation">
				<h4>
					<div class='navbar-form navbar-left'>
						
							<?=$_SESSION['fio']?>
					
					</div>	
					<div class='navbar-form navbar-right navRFix'>
					
							<?
							if($_SESSION['status'] == 1 || $_SESSION['status'] == 2)
								echo "<a href='/adm/main' class='btn btn-default'>Панель управления</a>";
							?>
							<a class='btn btn-default' onClick="modalView('<?=$_SESSION['hash']?>', '<?=$_SESSION['admin']?>', 'profile')">Профиль</a>
							<a class='btn btn-default' href="/?exit=1">Выход</a>
					
					</div>
				</h4>
			</nav>
		</div>
		<?}?>
		<div class="all"></div>
		<div id="mod"></div>
		<a href="/"><img class="logo" width="250px" src="https://www.sibsau.ru/sibgu/static/src/images/sibgu/img/main_logo.svg" alt="SibSAU"></a>