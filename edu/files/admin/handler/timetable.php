<?
	session_start();
	function groupList(){
		require './../../lib/db.php';
		$query = "SELECT * FROM timeTable";
		$stmt = mysqli_query($connect, $query) or die(mysqli_error($connect));
		$result = mysqli_fetch_assoc($stmt);
		$g = '';
		do{
			if($g != $result['grup']){
				print '<a href="#" class="list-group-item file" onClick="groupSel(\''.$_SESSION['hash'].'\', \''.$_SESSION['admin'].'\', \''.$result['grup'].'\', 1)">1 Неделя</a>';
				print '<a href="#" class="list-group-item file" onClick="groupSel(\''.$_SESSION['hash'].'\', \''.$_SESSION['admin'].'\', \''.$result['grup'].'\', 2)">2 Неделя</a>';
			}
			$g = $result['grup'];
		}while($result = mysqli_fetch_assoc($stmt));
	}

	function days($group, $week){
		$dayW = array(
			'1' => 'Понедельник',
			'2' => 'Вторник',
			'3' => 'Среда',
			'4' => 'Четверг',
			'5' => 'Пятница',
			'6' => 'Суббота',
			'7' => 'Воскресенье'
		);
		print '<button class="btn btn-default" title="Назад" onClick="groupList(\''.$_SESSION['hash'].'\', \''.$_SESSION['admin'].'\')"><i class="fa fa-arrow-left"></i></button>';
		for($i = 1; $i < count($dayW); $i++){
			print '<a href="#" class="list-group-item file" onClick="daySel(\''.$_SESSION['hash'].'\', \''.$_SESSION['admin'].'\', \''.$group.'\',\''.$week.'\',\''.$i.'\')">'.$dayW[$i].'</a>';
		}
	}

	function lines($group, $week, $day){
		require './../../lib/db.php';
		$type = array(
			'0' => 'Лекция',
			'1' => 'Практика',
			'2' => 'Лаб.р'
		);
		$query = "SELECT * FROM timeTable WHERE grup='".$group."' AND week=".$week." AND dayW=".$day;
		$stmt = mysqli_query($connect, $query) or die(mysqli_error($connect));
		$result = mysqli_fetch_assoc($stmt);
		print '<button class="btn btn-default" title="Назад" onClick="groupSel(\''.$_SESSION['hash'].'\', \''.$_SESSION['admin'].'\',\''.$group.'\',\''.$week.'\')"><i class="fa fa-arrow-left"></i></button>';
		print '<button class="btn btn-default" title="Добавить" onClick="modalView(\''.$_SESSION['hash'].'\', \''.$_SESSION['admin'].'\', \'lineAdd\', \'0\', \'timetable\', \''.$group.'\', \''.$week.'\', \''.$day.'\')"><i class="fa fa-plus"></i></button>';
		if($result['id'] != ''){
			do{
				$tS = explode(':', $result['timeS']);
        		$tE = explode(':', $result['timeE']);
				print '
					<li class="list-group-item file">'.$result['subject'].' '.$tS[0].':'.$tS[1].'-'.$tE[0].':'.$tE[1].' '.$result['tutor'].' '.$result['corps'].' '.$result['aud'].' '.$type[$result['type']].' 
					<button class="btn btn-warning btn-sm pull-right" style="margin-left:5px;" title="Удалить" onClick="modalView(\''.$_SESSION['hash'].'\', \''.$_SESSION['admin'].'\', \'lineRemove\', \''.$result['id'].'\', \'timetable\', \''.$group.'\', \''.$week.'\', \''.$day.'\')"><i class="fa fa-trash"></i></button> 
					<button class="btn btn-success btn-sm pull-right" title="Изменить" onClick="modalView(\''.$_SESSION['hash'].'\', \''.$_SESSION['admin'].'\', \'lineEdit\', \''.$result['id'].'\', \'timetable\', \''.$group.'\', \''.$week.'\', \''.$day.'\')"><i class="fa fa-pencil"></i></button>
					</li>
				';
			}while($result = mysqli_fetch_assoc($stmt));
		}else{
			print '<li class="list-group-item file text-center"><br>Пусто. Добавьте ленты</li>';
		}
	}

	function lineEditView($id, $group, $week, $day){
		require './../../lib/db.php';
		$query = "SELECT * FROM timeTable WHERE id=".$id;
		$stmt = mysqli_query($connect, $query)or die(mysqli_error($connect));
		$result = mysqli_fetch_assoc($stmt);
		$lines = array(
			"1" => "8:00:00",
			"2" => "9:40:00",
			"3" => "11:30:00",
			"4" => "13:30:00",
			"5" => "15:10:00"
		);
		$a1='';$a2='';$a3='';$a4='';$a5='';$t1='';$t2='';$t3='';
		switch($result['type']){
			case 0:
				$t1 = "selected";
				break;
			case 1:
				$t2 = "selected";
				break;
			case 2:
				$t3 = "selected";
				break;
		}
		for($i = 1; $i <= count($lines); $i++){
			if($result['timeS'] == $lines[$i]){
				switch($i){
					case 1:
						$a1 = "selected";
						break;
					case 2:
						$a2 = "selected";
						break;
					case 3:
						$a3 = "selected";
						break;
					case 4:
						$a4 = "selected";
						break;
					case 5:
						$a5 = "selected";
						break;
				}
			}
		}
			
		print '
			<div id="lineEdit" class="modal fade">
				<div class="modal-dialog" role="document">
			    	<div class="modal-content">
			      		<div class="modal-header">
			        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			         			<span aria-hidden="true">&times;</span>
			        		</button>
			        		<h4 class="modal-title">Изменить ленту</h4>
			      		</div>
				     	<div class="modal-body">
				        	<input id="subject" type="text" class="form-control input-fix" placeholder="Предмет" value="'.$result['subject'].'"><br>
				        	<select id="line" class="form-control input-fix">
								<option '.$a1.' value="1">1 Лента 8:00 - 9:30</option>
								<option '.$a2.' value="2">2 Лента 9:40 - 11:10</option>
								<option '.$a3.' value="3">3 Лента 11:30 - 13:00</option>
								<option '.$a4.' value="4">4 Лента 13:30 - 15:00</option>
								<option '.$a5.' value="5">5 Лента 15:10 - 16:40</option>
							</select><br>
				        	<input id="tutor" type="text" class="form-control input-fix" placeholder="Преподаватель" value="'.$result['tutor'].'"><br>
				        	<input id="corps" type="text" class="form-control input-fix" placeholder="Корпус" value="'.$result['corps'].'"><br>
				        	<input id="aud" type="int" class="form-control input-fix" placeholder="Аудитория" value="'.$result['aud'].'"><br>
				        	<select id="type" class="form-control input-fix">
				        		<option '.$t1.' value="0">Лекция</option>
				        		<option '.$t2.' value="1">Практика</option>
				        		<option '.$t3.' value="2">Лаб.р</option>
				        	</select>
				      	</div>
				      	<div class="modal-footer">
				        	<button type="button" class="btn btn-success" onClick="lineHandle(\''.$_SESSION['hash'].'\', \''.$_SESSION['admin'].'\', \''.$id.'\', \''.$group.'\', \''.$week.'\', \''.$day.'\', \'lineEdit\')">Изменить</button>
				      	</div>
			    	</div>
			  	</div>
			</div>
		';
	}

	function lineEdit($id, $subject, $line, $tutor, $corps, $aud, $type){
		require './../../lib/db.php';
		$lines = array(
			"1" => "8:00:00",
			"2" => "9:40:00",
			"3" => "11:30:00",
			"4" => "13:30:00",
			"5" => "15:10:00"
		);
		$lines2 = array(
			"1" => "9:30:00",
			"2" => "11:10:00",
			"3" => "13:00:00",
			"4" => "15:00:00",
			"5" => "16:40:00"
		);
		$query = "UPDATE timeTable SET subject='".$subject."', timeS='".$lines[$line]."', timeE='".$lines2[$line]."', tutor='".$tutor."', corps='".$corps."', aud='".$aud."', type='".$type."' WHERE id='".$id."'";
		$stmt = mysqli_query($connect, $query)or die(mysqli_error($connect));
		if($stmt == true){
			?><script>setTimeout(function(){$('.alert').fadeOut('fast')},5000);</script><div class='alert alert-success al'>Лента обновлена успешно!</div><?php
		}else{
			?><script>setTimeout(function(){$('.alert').fadeOut('fast')},5000);</script><div class='alert alert-danger al'>Ошибка 2!</div><?php
		}
	}

	function lineAddView($group, $week, $day){
		print '
			<div id="lineAdd" class="modal fade">
				<div class="modal-dialog" role="document">
			    	<div class="modal-content">
			      		<div class="modal-header">
			        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			         			<span aria-hidden="true">&times;</span>
			        		</button>
			        		<h4 class="modal-title">Добавить ленту</h4>
			      		</div>
				     	<div class="modal-body">
				        	<input id="subject" type="text" class="form-control input-fix" placeholder="Предмет"><br>
				        	<select id="line" class="form-control input-fix">
								<option value="1">1 Лента 8:00 - 9:30</option>
								<option value="2">2 Лента 9:40 - 11:10</option>
								<option value="3">3 Лента 11:30 - 13:00</option>
								<option value="4">4 Лента 13:30 - 15:00</option>
								<option value="5">5 Лента 15:10 - 16:40</option>
							</select><br>
				        	<input id="tutor" type="text" class="form-control input-fix" placeholder="Преподаватель"><br>
				        	<input id="corps" type="text" class="form-control input-fix" placeholder="Корпус"><br>
				        	<input id="aud" type="int" class="form-control input-fix" placeholder="Аудитория"><br>
				        	<select id="type" class="form-control input-fix">
				        		<option value="0">Лекция</option>
				        		<option value="1">Практика</option>
				        		<option value="2">Лаб.р</option>
				        	</select>
				      	</div>
				      	<div class="modal-footer">
				        	<button type="button" class="btn btn-success" onClick="lineHandle(\''.$_SESSION['hash'].'\', \''.$_SESSION['admin'].'\', 0, \''.$group.'\', \''.$week.'\', \''.$day.'\', \'lineAdd\')"> Добавить</button>
				      	</div>
			    	</div>
			  	</div>
			</div>
		';
	}

	function lineAdd($subject, $line, $tutor, $corps, $aud, $type, $dayW, $week, $group){
		require './../../lib/db.php';
		$lines = array(
			"1" => "8:00:00",
			"2" => "9:40:00",
			"3" => "11:30:00",
			"4" => "13:30:00",
			"5" => "15:10:00"
		);
		$lines2 = array(
			"1" => "9:30:00",
			"2" => "11:10:00",
			"3" => "13:00:00",
			"4" => "15:00:00",
			"5" => "16:40:00"
		);
		$query = "INSERT INTO timeTable (subject,timeS,timeE,tutor,corps,aud,type,dayW,week,grup) VALUES ('".$subject."','".$lines[$line]."','".$lines2[$line]."','".$tutor."','".$corps."','".$aud."','".$type."','".$dayW."','".$week."','".$group."')";
		$stmt = mysqli_query($connect, $query)or die(mysqli_error($connect));
		if($stmt == true){
			?><script>setTimeout(function(){$('.alert').fadeOut('fast')},5000);</script><div class='alert alert-success al'>Лента добавлена успешно!</div><?php
		}else{
			?><script>setTimeout(function(){$('.alert').fadeOut('fast')},5000);</script><div class='alert alert-danger al'>Ошибка 2!</div><?php
		}
	}

	function lineRemoveView($group, $week, $day, $id){
		print '
			<div id="lineRemove" class="modal fade">
				<div class="modal-dialog" role="document">
			    	<div class="modal-content">
			      		<div class="modal-header">
			        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			         			<span aria-hidden="true">&times;</span>
			        		</button>
			        		<h4 class="modal-title">Удалить ленту</h4>
			      		</div>
				      	<div class="modal-footer">
				        	<button type="button" class="btn btn-success" onClick="lineHandle(\''.$_SESSION['hash'].'\', \''.$_SESSION['admin'].'\', \''.$id.'\', \''.$group.'\', \''.$week.'\', \''.$day.'\', \'lineRemove\')">Удалить</button>
				      	</div>
			    	</div>
			  	</div>
			</div>
		';
	}

	function lineRemove($id){
		require './../../lib/db.php';
		$query = "DELETE FROM timeTable WHERE id=".$id;
		$stmt = mysqli_query($connect, $query)or die(mysqli_error($connect));
		if($stmt == true){
			?><script>setTimeout(function(){$('.alert').fadeOut('fast')},5000);</script><div class='alert alert-success al'>Лента удалена успешно!</div><?php
		}else{
			?><script>setTimeout(function(){$('.alert').fadeOut('fast')},5000);</script><div class='alert alert-danger al'>Ошибка 2!</div><?php
		}
	}


	if(isset($_POST['hash']) && isset($_POST['login']) && isset($_SESSION['status']) && ($_SESSION['status'] == 1 || $_SESSION['status'] == 2)){
		require 'sequrity.php';

		if(checkHash($_POST['hash'], $_POST['login'])){

			if(isset($_POST['view'])){
				if($_POST['view'] == 'group')
					groupList();
				if($_POST['view'] == 'days')
					days($_POST['group'], $_POST['week']);
				if($_POST['view'] == 'lines')
					lines($_POST['group'], $_POST['week'], $_POST['day']);
				if($_POST['view'] == 'lineEdit')
					lineEditView($_POST['id'], $_POST['group'], $_POST['week'], $_POST['day']);
				if($_POST['view'] == 'lineAdd')
					lineAddView($_POST['group'], $_POST['week'], $_POST['day']);
				if($_POST['view'] == 'lineRemove')
					lineRemoveView($_POST['group'], $_POST['week'], $_POST['day'], $_POST['id']);
			}

			if(isset($_POST['handle'])){
				if($_POST['handle'] == 'lineEdit')
					lineEdit($_POST['id'], $_POST['subject'], $_POST['line'], $_POST['tutor'], $_POST['corps'], $_POST['aud'], $_POST['type']);
				if($_POST['handle'] == 'lineAdd')
					lineAdd($_POST['subject'], $_POST['line'], $_POST['tutor'], $_POST['corps'], $_POST['aud'], $_POST['type'], $_POST['day'], $_POST['week'], $_POST['group']);
				if($_POST['handle'] == 'lineRemove')
					lineRemove($_POST['id']);
			}
		}else{
			?><script>setTimeout(function(){$('.alert').fadeOut('fast')},5000);</script><div class='alert alert-danger al'>Ошибка 0!</div><?
		}
	}
?>