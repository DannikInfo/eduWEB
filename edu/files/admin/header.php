<!DOCTYPE html>
<html lang="ru">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>edu.wolfeco.ru - Панель управления</title>
		<link href="//wolfeco.ru/files/admin/css/bootstrap.min.css" rel="stylesheet"> 
		<link href="//wolfeco.ru/files/admin/css/styles.css" rel="stylesheet">
		<link href="//wolfeco.ru/files/admin/css/font-awesome.min.css" rel="stylesheet">
		<script src="//wolfeco.ru/files/admin/js/jquery-2.1.0.min.js"></script>
		<script src="//wolfeco.ru/files/admin/js/bootstrap.min.js"></script>
		<script src="//wolfeco.ru/files/admin/js/ajax.js"></script>
		<script src="/files/admin/ajax.js"></script>
	</head>
	<body>
		<div class="header">
			<nav class="navbar nav-fix navbar-default navfix" role="navigation">
			  	<div class="container-fluid nav-width">
			   	 	<div class="navbar-header">
				     	<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
				            <span class="sr-only">Меню</span>
				            <span class="icon-bar"></span>
				            <span class="icon-bar"></span>
				            <span class="icon-bar"></span>
				        </button>
				      	<a class="navbar-brand" href="/adm/main">EDU</a>
			    	</div>
				    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				    <?php
				      	if(isset($_SESSION['login']) && $_SESSION['login'] == true){
				      		print'
						      	<ul class="nav navbar-nav">
						      	';
						      	if($_SESSION['status'] == 2)
						    		print '<li><a href="/adm/stats">Статистика</a></li>';
						    print '
						      		<li><a href="/adm/timetable">Расписание</a></li>
						      		<li><a href="/adm/progress">Успеваемость</a></li>
						      		<!--<li><a href="/adm/visits">Посещаемость</a></li>-->
						      		<li><a href="/adm/group">Группа</a></li>
						      		<li><a href="/">На сайт</a></li>
						      	</ul>
						      	<ul class="nav navbar-nav navbar-right">
						    ';
				        	print "
				        	<div class='navbar-form navbar-left'>
				        		<button class='btn btn-default' onClick='exitSession()'>Выход</button>
				        	</div>
				        	";
				        }
				        ?>
						</ul>
				    </div>
			  	</div>
			</nav>
		</div>
		<div class="wrapper">