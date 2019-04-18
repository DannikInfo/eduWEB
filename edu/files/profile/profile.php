<?

	session_start();

	function profileView(){
		$status = '';
		if($_SESSION['status'] == 1)
			$status = '(Староста)';
		print '
			<div id="profile" class="modal fade">
				<div class="modal-dialog" role="document">
			    	<div class="modal-content">
			      		<div class="modal-header">
			        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			         			<span aria-hidden="true">&times;</span>
			        		</button>
			        		<h4 class="modal-title">Профиль</h4>
			      		</div>
				     	<div class="modal-body">
				     		<h4>'.$_SESSION['group'].' '.$status.'</h4>
				     		<input type="text" class="form-control input-fix" id="fio" value="'.$_SESSION['fio'].'" placeholder="ФИО"><br>
				     		<input type="integer" class="form-control input-fix" id="login" value="'.$_SESSION['admin'].'" placeholder="№ зачетки"><br>
				     		<input type="email" class="form-control input-fix" id="email" value="'.$_SESSION['email'].'" placeholder="EMail"><br>
				     		<input type="password" class="form-control input-fix" id="oldPass" placeholder="Старый пароль"><br>
				     		<input type="password" class="form-control input-fix" id="pass1" placeholder="Новый пароль"><br>
				     		<input type="password" class="form-control input-fix" id="pass2" placeholder="Повтор пароля"><br>
				      	</div>
				      	<div class="modal-footer">
				        	<button type="button" class="btn btn-success" onClick="peEdit(\''.$_SESSION['hash'].'\', \''.$_SESSION['admin'].'\')">Изменить</button>
				      	</div>
			    	</div>
			  	</div>
			</div>
		';
	}

	function profileEdit($fio, $login, $email, $opass, $pass){
		require './../lib/db.php';
		if($opass != '' && $pass != ''){
			$query_pass = "SELECT password FROM students WHERE id=".$_SESSION['id']." AND grup='".$_SESSION['group']."'";
			$stmt_pass = mysqli_query($connect, $query_pass) or die(mysqli_error($connect));
			$result_pass = mysqli_fetch_assoc($stmt_pass);
			
			$oHash = sha1(md5(md5($opass)));
			$nHash = sha1(md5(md5($pass)));

			if($oHash == $result_pass['password']){
				$query = "UPDATE students SET fio='".$fio."', login=".$login.", email='".$email."', password='".$nHash."' WHERE id=".$_SESSION['id']." AND grup='".$_SESSION['group']."'";
			}else{
				?><script>setTimeout(function(){$('.alert').fadeOut('fast')},5000);</script><div class='alert alert-danger al'>Неверный пароль!</div><?php
			}
		}else{
			$query = "UPDATE students SET fio='".$fio."', login=".$login.", email='".$email."' WHERE id=".$_SESSION['id']." AND grup='".$_SESSION['group']."'";
		}
		$stmt = mysqli_query($connect, $query) or die(mysqli_error($connect));
		if($stmt == true){
			$_SESSION['fio'] = $fio;
			$_SESSION['admin'] = $login;
			$_SESSION['email'] = $email;
			?><script>setTimeout(function(){$('.alert').fadeOut('fast')},5000);</script><div class='alert alert-success al'>Профиль обновлен успешно!</div><?php
		}else{
			?><script>setTimeout(function(){$('.alert').fadeOut('fast')},5000);</script><div class='alert alert-danger al'>Ошибка mysql!</div><?php
		}
	}


	if(isset($_POST['hash']) && isset($_POST['login'])){
		require_once './../lib/db.php';
		require 'sequrity.php';

		if(checkHash($_POST['hash'], $_POST['login'])){

			if(isset($_POST['view'])){
				if($_POST['view'] == 'profile')
					profileView();
			}

			if(isset($_POST['handle'])){
				if($_POST['handle'] == 'peEdit')
					profileEdit($_POST['fio'], $_POST['login2'], $_POST['email'], $_POST['opass'], $_POST['pass']);
			}
		}else{
			?><script>setTimeout(function(){$('.alert').fadeOut('fast')},5000);</script><div class='alert alert-danger al'>Ошибка доступа!</div><?
		}
	}

?>