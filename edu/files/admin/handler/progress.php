<?
/**{
	"progress": {
		"1": {
			"subjects": {
				"0": {
					"points": 20,
					"subjectID": 1
				}, 
				"1": {
					"points": 25,
					"subjectID": 2
				}
			}
		},
		"2": {
			"subjects": {
				"0": {
					"points": 20,
					"subjectID": 1
				}, 
				"1": {
					"points": 25,
					"subjectID": 2
				}
			}
		},
		"3": {
			"subjects": {
				"0": {
					"points": 20,
					"subjectID": 1
				}, 
				"1": {
					"points": 25,
					"subjectID": 2
				}
			}
		}
	}
}*/

	session_start();

	function semester(){
		require './../../lib/db.php';
		$query = "SELECT * FROM groups WHERE grup='".$_SESSION['group']."'";
		$stmt = mysqli_query($connect, $query) or die(mysqli_error($connect));
		$result = mysqli_fetch_assoc($stmt);
		$year = date('Y',time()); 
		$month = date('m',time());
		$time = strtotime($result['yearStartStudy']);
		$year2 = date('Y', $time);
		//-----
		$dYear = $year - $year2;
		$semester = $dYear * 2;
		if($semester == 0)
			$semester = 1;
		if($month <= 1 || $month >= 9)
			$semester++;
		return $semester;
	}

	function groupProgress(){
		require './../../lib/db.php';
		//---
		$query = "SELECT * FROM progress WHERE grup='".$_SESSION['group']."'";
		$stmt = mysqli_query($connect, $query) or die(mysqli_error($connect));
		$result = mysqli_fetch_assoc($stmt);
		$stTable = '<table class="table table-striped">
			<tr><th class="table-thl-fix">№ зачетки</th><th>ФИО</th><th>1 аттестация ср.</th><th>2 аттестация ср.</th><th>3 аттестация ср.</th><th>Действия</th></tr>
		';
		$stCount = 0;

		do{
			$query_st = "SELECT * FROM students WHERE grup='".$_SESSION['group']."' AND id=".$result['studentID'];
			$stmt_st = mysqli_query($connect, $query_st) or die(mysqli_error($connect));
			$result_st = mysqli_fetch_assoc($stmt_st);
			$att = array(
				'0' => 0,
				'1' => 0,
				'2' => 0
			);
			$data = json_decode($result['data']);
			for($i = 0; $i < 3; $i++){
				$j = 0;
				while(isset($data->{'progress'}->{$i}->{'subjects'}->{$j})){
					$att[$i] += $data->{'progress'}->{$i}->{'subjects'}->{$j}->points;
					$j++;
				}
				if($j != 0)
					$att[$i] /= $j;
			}
			
			$stTable .= '<tr><td>'.$result_st['login'].'</td><td>'.$result_st['FIO'].'</td><td>'.round($att[0], 2).'</td><td>'.round($att[1], 2).'</td><td>'.round($att[2], 2).'</td><td>
					<button class="btn btn-success btn-xs" title="Изменить" onClick="modalView(\''.$_SESSION['hash'].'\', \''.$_SESSION['admin'].'\', \'psEdit\', \''.$result['studentID'].'\', \'progress\')"><i class="fa fa-pencil"></i></button>
					</td></tr>';
			$stCount++;
		}while($result = mysqli_fetch_assoc($stmt));
		$stTable .= '</table>';
		print $stTable;
	}

	function progressEditView($id){
		require './../../lib/db.php';
		$query = "SELECT * FROM students WHERE id=".$id;
		$stmt = mysqli_query($connect, $query) or die(mysqli_error($connect));
		$result = mysqli_fetch_assoc($stmt);
		//--
		$query_ss = "SELECT * FROM subjects WHERE grup='".$_SESSION['group']."' AND semester=".semester();
		$stmt_ss = mysqli_query($connect, $query_ss) or die(mysqli_error($connect));
		$result_ss = mysqli_fetch_assoc($stmt_ss);	
		//--
		$query_ps = "SELECT * FROM progress WHERE studentID=".$id;
		$stmt_ps = mysqli_query($connect, $query_ps) or die(mysqli_error($connect));
		$result_ps = mysqli_fetch_assoc($stmt_ps);
		$data = json_decode($result_ps['data']);
		print '
			<div id="psEdit" class="modal fade">
				<div class="modal-dialog" role="document">
			    	<div class="modal-content">
			      		<div class="modal-header">
			        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			         			<span aria-hidden="true">&times;</span>
			        		</button>
			        		<h4 class="modal-title">Изменить успеваемость</h4>
			      		</div>
				     	<div class="modal-body">
				     		<h4>'.$result['FIO'].'</h4>
				        	<ul class="nav nav-tabs">
							 	<li class="active"><a data-toggle="tab" href="#panel0">1 аттестация</a></li>
							  	<li><a data-toggle="tab" href="#panel1">2 аттестация</a></li>
							  	<li><a data-toggle="tab" href="#panel2">3 аттестация</a></li>    
							</ul>
							 
							<div class="tab-content">
							  	
							    ';
							    $i = 0;
							    for($a = 0; $a < 3; $a++){
							    	//----
							    	$active = '';
							    	if($a == 0)
							    		$active = 'active';
							    	print '<div id="panel'.$a.'" class="tab-pane fade in '.$active.'">';
								    $data2 = json_decode($result_ss['data']);
								    for($i = 0; isset($data2->{$i}); $i++){
								    	$j = 0;
								    	$points = 0;
								    	while(isset($data->{'progress'}->{$a}->{'subjects'}->{$j})){
								    		if($data->{'progress'}->{$a}->{'subjects'}->{$j}->subjectID == $i){
								    			$points = $data->{'progress'}->{$a}->{'subjects'}->{$j}->points;
								    			break;
								    		}
								    		$j++;
								    	}
								    	print '<br><label>'.$data2->$i.':</label> <input type="integer" class="form-control input-fix" id="points_'.$a.'_'.$i.'" value="'.$points.'">';
								    }
								    print '</div>';
							    }
							   print '
							   <input type="hidden" id="data" value="'.$result_ps['data'].'">
							</div>
				      	</div>
				      	<div class="modal-footer">
				        	<button type="button" class="btn btn-success" onClick="psEdit(\''.$_SESSION['hash'].'\', \''.$_SESSION['admin'].'\', \''.$i.'\', \''.$id.'\')">Изменить</button>
				      	</div>
			    	</div>
			  	</div>
			</div>
		';
	}

	function progressEdit($id, $pointsArray){
		require './../../lib/db.php';
		$data = new stdClass;
		$data->{'progress'} = new stdClass();
		for($i = 0; $i < 3; $i++){
			$data->{'progress'}->{$i} = new stdClass();
			$data->{'progress'}->{$i}->{'subjects'} = new stdClass();
			for($j = 0; $j < count($pointsArray[$i]); $j++){
				$data->{'progress'}->{$i}->{'subjects'}->{$j} = new stdClass();
				$data->{'progress'}->{$i}->{'subjects'}->{$j}->points = $pointsArray[$i][$j];
				$data->{'progress'}->{$i}->{'subjects'}->{$j}->subjectID = $j;
			}
		}
		$json = json_encode($data);
		$query = "UPDATE progress SET data='".$json."' WHERE grup='".$_SESSION['group']."' AND semester=".semester();
		$stmt = mysqli_query($connect, $query) or die(mysqli_error($connect));
		if($stmt == true){
			?><script>setTimeout(function(){$('.alert').fadeOut('fast')},5000);</script><div class='alert alert-success al'>Успеваемость обновлена успешно!</div><?
		}else{
			?><script>setTimeout(function(){$('.alert').fadeOut('fast')},5000);</script><div class='alert alert-danger al'>Ошибка mysql!</div><?
		}
	}

	if(isset($_POST['hash']) && isset($_POST['login']) && isset($_SESSION['status']) && ($_SESSION['status'] == 1 || $_SESSION['status'] == 2)){
		require 'sequrity.php';

		if(checkHash($_POST['hash'], $_POST['login'])){

			if(isset($_POST['view'])){
				if($_POST['view'] == "progress")
					groupProgress();
				if($_POST['view'] == "psEdit")
					progressEditView($_POST['id']);
			}

			if(isset($_POST['handle'])){
				if($_POST['handle'] == "psEdit")
					progressEdit($_POST['id'], $_POST['pointsArray']);
			}
		}else{
			?><script>setTimeout(function(){$('.alert').fadeOut('fast')},5000);</script><div class='alert alert-danger al'>Ошибка доступа!</div><?
		}
	}
?>