<?
	if($_GET['page'] == 'main')
		$_GET['page'] = 'group';
	if($_GET['page'] == 'timetable' || $_GET['page'] == 'stats' || $_GET['page'] == 'group' || $_GET['page'] == 'visits' || $_GET['page'] == 'progress'){
		require 'header.php';
		require 'pages/'.$_GET['page'].'.php';
	}else{
		print '<!DOCTYPE html>
				<html>
				<head>
					<meta charset="UTF-8">
					<meta http-equiv="X-UA-Compatible" content="IE=edge">
					<meta name="viewport" content="width=device-width, initial-scale=1">
					<title></title>
					<link href="//wolfeco.ru/files/templates/WolfEco/system/css/bootstrap.min.css" rel="stylesheet">
					<script src="//wolfeco.ru/files/templates/WolfEco/system/js/jquery-3.2.1.min.js"></script>
					<script src="//wolfeco.ru/files/templates/WolfEco/system/js/bootstrap.min.js"></script>
				    <link href="//wolfeco.ru/files/admin/css/font-awesome.min.css" rel="stylesheet">
				    <link href="//wolfeco.ru/files/templates/WolfEco/css/styles.css" rel="stylesheet">
				  </head>
				  <body class="error">
			    	404 Error
			      	<p class="lead">упсс ошибочка...</p>
			      		<div class="error-content">
			        		<p>Произошла ошибка при попытке перейти на неизвестную страницу.<br>
							Проверьте адрес страницы или вернитесь назад.<br>
							Если вы считаете, что допущена ошибка на странице сайта, то сообщите нам:<br></p>
							<a href="//vk.com/dannikinfo"><i class="fa fa-2x fa-vk" aria-hidden="true"></i></a>
							<a href="//te.me/dannikinfo"><i class="fa fa-2x fa-telegram" aria-hidden="true"></i></a>
							<a href="//twitter.com/dannikinfo"><i class="fa fa-2x fa-twitter" aria-hidden="true"></i></a>
			      		</div>
			  		</body>
				</html>';
		exit();
	}