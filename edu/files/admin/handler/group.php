<?
	session_start();

	function groupInfo(){
		require './../../lib/db.php';
		$query = "SELECT * FROM groups WHERE grup='".$_SESSION['group']."'";
		$stmt = mysqli_query($connect, $query) or die(mysqli_error($connect));
		$result = mysqli_fetch_assoc($stmt);
		print '
			<h3><a href="'.$result['cloud'].'"><i class="fa fa-cloud"> Облако</i></a> 
				<button class="pull-right btn btn-default" title="Изменить" onClick="modalView(\''.$_SESSION['hash'].'\', \''.$_SESSION['admin'].'\', \'cloud\')"><i class="fa fa-pencil"></i></button>
				</h3>';

		$query2 = "SELECT * FROM students WHERE grup='".$_SESSION['group']."' ORDER BY FIO";
		$stmt2 = mysqli_query($connect, $query2) or die(mysqli_error($connect));
		$result2 = mysqli_fetch_assoc($stmt2);
		$stTable = '<table class="table table-striped">
			<tr><th class="table-thl-fix">№ зачетки</th><th>ФИО</th><th>Email</th><th>Действия</th></tr>
		';
		$stCount = 0;

		do{
			$admin = '';
			$disabled = '';
			if($result2['status'] == 1){
				$admin = "<b>(староста)</b>";
				$disabled = "disabled";
			}
			$stTable .= '<tr><td>'.$result2['login'].'</td><td>'.$result2['FIO'].' '.$admin.'</td><td>'.$result2['email'].'</td><td>
					<button class="btn btn-success btn-xs" title="Изменить" '.$disabled.' onClick="modalView(\''.$_SESSION['hash'].'\', \''.$_SESSION['admin'].'\', \'stEdit\', \''.$result2['id'].'\')"><i class="fa fa-pencil"></i></button>
					<button class="btn btn-warning btn-xs" title="Удалить" '.$disabled.' onClick="modalView(\''.$_SESSION['hash'].'\', \''.$_SESSION['admin'].'\', \'stRemove\', \''.$result2['id'].'\')"><i class="fa fa-trash"></i></button> 
					</td></tr>';
			$stCount++;
		}while($result2 = mysqli_fetch_assoc($stmt2));
		$stTable .= '</table>';
		print '<h3>Студентов: '.$stCount.' <button class="btn btn-default pull-right" title="Добавить" onClick="modalView(\''.$_SESSION['hash'].'\', \''.$_SESSION['admin'].'\', \'stAdd\')"><i class="fa fa-plus"></i></button></h3>';
		print $stTable;
	}

	function cloudEditView(){
		require './../../lib/db.php';
		$query = "SELECT * FROM groups WHERE grup='".$_SESSION['group']."'";
		$stmt = mysqli_query($connect, $query) or die(mysqli_error($connect));
		$result = mysqli_fetch_assoc($stmt);
		print '
			<div id="cloud" class="modal fade">
				<div class="modal-dialog" role="document">
			    	<div class="modal-content">
			      		<div class="modal-header">
			        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			         			<span aria-hidden="true">&times;</span>
			        		</button>
			        		<h4 class="modal-title">Изменить ссылку</h4>
			      		</div>
				     	<div class="modal-body">
				        	<input id="link" type="text" class="form-control input-fix" placeholder="Ссылка на облако" value="'.$result['cloud'].'">
				      	</div>
				      	<div class="modal-footer">
				        	<button type="button" class="btn btn-success" onClick="cloudEdit(\''.$_SESSION['hash'].'\', \''.$_SESSION['admin'].'\')">Изменить</button>
				      	</div>
			    	</div>
			  	</div>
			</div>
		';
	}

	function cloudEdit($link){
		require './../../lib/db.php';
		$query = "UPDATE groups SET cloud='".$link."' WHERE grup='".$_SESSION['group']."'";
		$stmt = mysqli_query($connect, $query) or die(mysqli_error($connect));
		if($stmt == true){
			?><script>setTimeout(function(){$('.alert').fadeOut('fast')},5000);</script><div class='alert alert-success al'>Ссылка обновлена успешно!</div><?php
		}else{
			?><script>setTimeout(function(){$('.alert').fadeOut('fast')},5000);</script><div class='alert alert-danger al'>Ошибка mysql!</div><?php
		}
	}

	function studentEditView($id){
		require './../../lib/db.php';
		$query = "SELECT * FROM students WHERE id='".$id."'";
		$stmt = mysqli_query($connect, $query) or die(mysqli_error($connect));
		$result = mysqli_fetch_assoc($stmt);
		print '
			<div id="stEdit" class="modal fade">
				<div class="modal-dialog" role="document">
			    	<div class="modal-content">
			      		<div class="modal-header">
			        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			         			<span aria-hidden="true">&times;</span>
			        		</button>
			        		<h4 class="modal-title">Изменить студента</h4>
			      		</div>
				     	<div class="modal-body">
				        	<input id="login" type="text" class="form-control input-fix" placeholder="№ зачетки" value="'.$result['login'].'"><br>
				        	<input id="FIO" type="text" class="form-control input-fix" placeholder="ФИО" value="'.$result['FIO'].'"><br>
				        	';
				        	if($result['status'] == 0)
				        		print '
				      		Выдать полномочия старосты на 1 день: 
				      		<input id="1dayStatus" type="checkbox" class="checkFix"><br><br>
				      		Передать полномочия старосты навсегда: 
				      		<input id="moveStatus" type="checkbox">
				      		';
				      		print '
				      		<input id="id" type="hidden" value="'.$result['id'].'">
				      	</div>
				      	<div class="modal-footer">
				        	<button type="button" class="btn btn-success" onClick="stEdit(\''.$_SESSION['hash'].'\', \''.$_SESSION['admin'].'\')">Изменить</button>
				      	</div>
			    	</div>
			  	</div>
			</div>
		';
	}

	function studentEdit($id, $login, $fio, $st1, $st2){
		require './../../lib/db.php';
		$st = 0;
		$timed = 0;
		if($st1){
			$timed = time()+86400;
			$st = 1;
		}else if($st2){
			$st = 1;
			$query = "UPDATE students SET status='0' WHERE id=".$_SESSION['id']." AND grup='".$_SESSION['group']."'";
			$stmt = mysqli_query($connect, $query) or die(mysqli_error($connect));
			$_SESSION['status'] = 0;
			print '<script>relocation(\'/\')</script>';
		}
		$query = "UPDATE students SET login='".$login."', fio='".$fio."', status='".$st."', timed='".$timed."' WHERE id=".$id." AND grup='".$_SESSION['group']."'";
		$stmt = mysqli_query($connect, $query) or die(mysqli_error($connect));
		if($stmt == true){
			?><script>setTimeout(function(){$('.alert').fadeOut('fast')},5000);</script><div class='alert alert-success al'>Cтуден обновлен успешно!</div><?php
		}else{
			?><script>setTimeout(function(){$('.alert').fadeOut('fast')},5000);</script><div class='alert alert-danger al'>Ошибка mysql!</div><?php
		}
	}

	function studentAddView(){
		print '
			<div id="stAdd" class="modal fade">
				<div class="modal-dialog" role="document">
			    	<div class="modal-content">
			      		<div class="modal-header">
			        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			         			<span aria-hidden="true">&times;</span>
			        		</button>
			        		<h4 class="modal-title">Добавить студента</h4>
			      		</div>
				     	<div class="modal-body">
				        	<input id="login" type="text" class="form-control input-fix" placeholder="№ зачетки"><br>
				        	<input id="FIO" type="text" class="form-control input-fix" placeholder="ФИО"><br>
				      	</div>
				      	<div class="modal-footer">
				        	<button type="button" class="btn btn-success" onClick="stAdd(\''.$_SESSION['hash'].'\', \''.$_SESSION['admin'].'\')">Добавить</button>
				      	</div>
			    	</div>
			  	</div>
			</div>
		';
	}

	function studentAdd($login, $fio){
		require './../../lib/db.php';
		$query = "INSERT INTO students (login,password,hash,time,timed,fio,status,email,grup) VALUES ('".$login."','0','0','0','0','".$fio."','0','student@university.com','".$_SESSION['group']."')";
		$stmt = mysqli_query($connect, $query) or die(mysqli_error($connect));
		if($stmt == true){
			?><script>setTimeout(function(){$('.alert').fadeOut('fast')},5000);</script><div class='alert alert-success al'>Cтуден добавлен успешно!</div><?php
		}else{
			?><script>setTimeout(function(){$('.alert').fadeOut('fast')},5000);</script><div class='alert alert-danger al'>Ошибка mysql!</div><?php
		}
	}

	function studentRemoveView($id){
		print '
			<div id="stRemove" class="modal fade">
				<div class="modal-dialog" role="document">
			    	<div class="modal-content">
			      		<div class="modal-header">
			        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			         			<span aria-hidden="true">&times;</span>
			        		</button>
			        		<h4 class="modal-title">Удалить студента</h4>
			      		</div>
				     	<div class="modal-body">
				        	Вы действительно хотите удалить студента?
				        </div>
				      	<div class="modal-footer">
				        	<button type="button" class="btn btn-success" onClick="stRemove(\''.$_SESSION['hash'].'\', \''.$_SESSION['admin'].'\', \''.$id.'\')">Удалить</button>
				      	</div>
			    	</div>
			  	</div>
			</div>
		';
	}

	function studentRemove($id){
		require './../../lib/db.php';
		$query = "DELETE FROM students WHERE id=".$id;
		$stmt = mysqli_query($connect, $query) or die(mysqli_error($connect));
		if($stmt == true){
			?><script>setTimeout(function(){$('.alert').fadeOut('fast')},5000);</script><div class='alert alert-success al'>Cтудент удален успешно!</div><?php
		}else{
			?><script>setTimeout(function(){$('.alert').fadeOut('fast')},5000);</script><div class='alert alert-danger al'>Ошибка mysql!</div><?php
		}
	}

	if(isset($_POST['hash']) && isset($_POST['login']) && isset($_SESSION['status']) && ($_SESSION['status'] == 1 || $_SESSION['status'] == 2)){
		require 'sequrity.php';

		if(checkHash($_POST['hash'], $_POST['login'])){

			if(isset($_POST['view'])){
				if($_POST['view'] == "info")
					groupInfo();
				if($_POST['view'] == 'cloud')
					cloudEditView();
				if($_POST['view'] == 'stEdit')
					studentEditView($_POST['id']);
				if($_POST['view'] == 'stAdd')
					studentAddView();
				if($_POST['view'] == 'stRemove')
					studentRemoveView($_POST['id']);
			}

			if(isset($_POST['handle'])){
				if($_POST['handle'] == 'cloud')
					cloudEdit($_POST['link']);
				if($_POST['handle'] == 'stEdit'){
					$status1 = 0; $status2 = 0;
					if(isset($_POST['status1']))
						$status1 = $_POST['status1'];
					if(isset($_POST['status2']))
						$status2 = $_POST['status2'];
					studentEdit($_POST['id'], $_POST['newLogin'], $_POST['fio'], $status1, $status2);

				}
				if($_POST['handle'] == 'stAdd')
					studentAdd($_POST['login2'],$_POST['fio']);
				if($_POST['handle'] == 'stRemove')
					studentRemove($_POST['stID']);
			}
		}else{
			?><script>setTimeout(function(){$('.alert').fadeOut('fast')},5000);</script><div class='alert alert-danger al'>Ошибка доступа!</div><?
		}
	}
?>