<?
/*{
	"subjects": {
		"1": "Физика",
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

	function sortData($subjects, $dataEnc){
		$data = json_decode($dataEnc);
		$newData = new stdClass;
		$newDataCheck = array();
		$j = 0;
		for($i = 0; $i < count($subjects); $i++){
			$check = false;
			for($j = 0; isset($data->$j); $j++){
				if($subjects[$i] == $data->$j){
					$newData->$j = $subjects[$i];
					$check = true;
				}
			}
			if(!$check){
				$newDataCheck[] = $subjects[$i];
			}
		} 
		for($i = 0; $i < count($newDataCheck); $i++){
			$newData->{$j++} = $newDataCheck[$i];
		}
		return $newData;
	}

	function subjectsSynch(){
		require './../../lib/db.php';
		$semester = semester();
		$query = "SELECT * FROM timetable WHERE grup='".$_SESSION['group']."'";//TODO:AND semester=".$semester;
		$stmt = mysqli_query($connect, $query) or die(mysqli_error($connect));
		$result = mysqli_fetch_assoc($stmt);
		//---
		$query_ss = "SELECT * FROM subjects WHERE grup='".$_SESSION['group']."' AND semester=".$semester;
		$stmt_ss = mysqli_query($connect, $query_ss) or die(mysqli_error($connect));
		$result_ss = mysqli_fetch_assoc($stmt_ss);
		$subjects = array();
		do{
			$subject = false;
			for($i = 0; $i < count($subjects); $i++){
				if($subjects[$i] == $result['subject']){
					$subject = true;
					break;
				}
			}
			if(!$subject){
				$subjects[] = $result['subject'];
			}
		}while($result = mysqli_fetch_assoc($stmt));

		$subjects = sortData($subjects, $result_ss['data']);

		$data = json_encode($subjects, JSON_UNESCAPED_UNICODE);
		$query_u = "UPDATE subjects SET data='".$data."' WHERE grup='".$_SESSION['group']."' AND semester=".$semester;
		$stmt_u = mysqli_query($connect, $query_u) or die(mysqli_error($connect));
		if($stmt_u == true){
			?><script>setTimeout(function(){$('.alert').fadeOut('fast')},5000);</script><div class='alert alert-success al'>Синхронизация прошла успешно!</div><?php
		}else{
			?><script>setTimeout(function(){$('.alert').fadeOut('fast')},5000);</script><div class='alert alert-danger al'>Ошибка mysql!</div><?php
		}
	}

	if(isset($_POST['hash']) && isset($_POST['login']) && isset($_SESSION['status']) && ($_SESSION['status'] == 1 || $_SESSION['status'] == 2)){
		require 'sequrity.php';

		if(checkHash($_POST['hash'], $_POST['login'])){

			if(isset($_POST['handle'])){
				if($_POST['handle'] == 'sSync')
					subjectsSynch();
			}
		}else{
			?><script>setTimeout(function(){$('.alert').fadeOut('fast')},5000);</script><div class='alert alert-danger al'>Ошибка доступа!</div><?
		}
	}
?>