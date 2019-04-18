<?
	if(!isset($_SESSION)){
		session_start();
	}
	if(isset($_POST['login'])){
		require 'files/lib/db.php';
		require_once 'files/profile/login.php';
		check_pass($_POST['login'], $_POST['password']);
	}

	if(!isset($_SESSION['login']) && isset($_COOKIE['login'])){
		require 'files/lib/db.php';
		require_once 'files/profile/login.php';
		check_pass($_COOKIE['login'], $_COOKIE['hash']);
	}

	if(isset($_GET['exit']) && $_GET['exit'] == 1){
		require_once 'files/profile/login.php';
		unLogin();
	}
require_once('header.php');
require_once('files/pages/handler.php');
if(isset($_SESSION['login']) && $_SESSION['login']){?>
			<div class="wrapper navFix">
				<div class="container-fluid adm-main-block" style="background-color: rgb(238, 238, 238);">
				<a href=<?=getCloudLink();?>><div class="col-md-4 adm-block"><i class="fa fa-cloud fa-5" style="color:rgb(127, 126, 124);" aria-hidden="true"></i><h1 class="text-center">Облако</h1></div></a>
				<a href="/timetable"><div class="col-md-4 adm-block"><i class="fa fa-table fa-5" style="color:rgb(115, 205, 86); "aria-hidden="true"></i><h1 class="text-center">Расписание</h1></div></a>
				<a href="/progress"><div class="col-md-4 adm-block"><i class="fa fa-check fa-5" style="color:rgb(76, 108, 191); "aria-hidden="true"></i><h1 class="text-center">Успеваемость</h1></div></a>
				<!-- hidden for fix)) for Future
				<div class="col-md-4 adm-block"></div>
				<a href="/visits"><div class="col-md-4 adm-block"><i class="fa fa-calendar-check-o fa-5" style="color:rgb(115, 205, 86); "aria-hidden="true"></i><h1 class="text-center">Посещаемость</h1></div></a>-->
				</div>
			</div>
			<?}else{?>
				<div id="register" class="modal fade">
					<div class="modal-dialog" role="document">
				    	<div class="modal-content">
				      		<div class="modal-header">
				        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				         			<span aria-hidden="true">&times;</span>
				        		</button>
				        		<h4 class="modal-title">Регистрация</h4>
				      		</div>
					     	<div class="modal-body">
					        	<input id="Sname" type="text" class="form-control input-fix" placeholder="Логин(номер зачетки)"><br>
					        	<input id="SFIO" type="text" class="form-control input-fix" placeholder="ФИО"><br>
					        	<input id="Spass" type="password" class="form-control input-fix" placeholder="Пароль"><br>
					        	<input id="Spass2" type="password" class="form-control input-fix" placeholder="Повтор пароля"><br>
					        	<input id="Sgroup" type="text" class="form-control input-fix" placeholder="Группа"><br>
					        	<input id="Semail" type="email" class="form-control input-fix" placeholder="e-mail"><br>
					        	<input id="Sstatus" name="status" type="radio" class="input-fix" value="1"> Статорста
					        	<input id="Sstatus" checked name="status" type="radio" class="input-fix" value="0"> Студент<br>
					      	</div>
					      	<div class="modal-footer">
					        	<button type="button" class="btn btn-success" onClick="register()">Продолжить</button>
					      	</div>
				    	</div>
				  	</div>
				</div>
				<form class="form-signin" role="form" action="#" method="post">
					<h2 class="form-signin-heading">Войдите</h2>
					<input name="login" type="login" class="form-control input-fix" placeholder="Логин (номер зачетки)" required autofocus><br>
					<input name="password" type="password" class="form-control input-fix passFix" placeholder="Пароль" required>
					<button class="btn btn-lg btn-primary btn-block" type="submit">Вход</button>
					<button class="btn btn-lg btn-success btn-block" type="button" onClick="registerView()">Регистрация</button>
				</form>
			<?}?>
		<!-- Yandex.Metrika counter -->
		<script type="text/javascript" >
		   (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
		   m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
		   (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

		   ym(52974043, "init", {
		        clickmap:true,
		        trackLinks:true,
		        accurateTrackBounce:true
		   });
		</script>
		<noscript><div><img src="https://mc.yandex.ru/watch/52974043" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
		<!-- /Yandex.Metrika counter -->
	    <script src="files/system/js/bootstrap.min.js"></script>
    </body>
</html>