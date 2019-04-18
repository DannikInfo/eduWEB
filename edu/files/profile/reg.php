<?

	function semester($group){
		require './../lib/db.php';
		$query = "SELECT * FROM groups WHERE grup='".$group."'";
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

	function register($login, $pass1, $email, $status, $group, $FIO){
		if(checkGroup($status, $group)){
			if(checkLogin($login, $status)){
				require './../lib/db.php';
				$hash = sha1(md5(md5($pass1)));
				if($status == 0)
					$query = "UPDATE students SET FIO='".$FIO."', password='".$hash."', email='".$email."', status='".$status."' WHERE login='".$login."' AND grup='".$group."'";
				else if($status == 1)
					$query = "INSERT INTO students (FIO, password, email, status, login, grup) VALUES ('".$FIO."','".$hash."','".$email."','".$status."','".$login."', '".$group."')";
				$stmt = mysqli_query($connect, $query)or die(mysqli_error($connect));
				if($stmt){					
					$query2 = "SELECT * FROM students WHERE login=".$login;
					$stmt2 = mysqli_query($connect, $query2)or die(mysqli_error($connect));
					$result2 = mysqli_fetch_assoc($stmt2);
					$data = '{"progress": {}}';
					$query_ps = "INSERT INTO progress (studentID, semester, data, grup) VALUES ('".$result2['id']."','".semester($group)."','".$data."','".$group."')";
					$stmt_ps = mysqli_query($connect, $query_ps)or die(mysqli_error($connect));
					if($stmt_ps)
						echo "<div class='alert alert-success al'>Регистрация прошла успешно</div>";
					else
						echo "<div class='alert alert-danger al'>Ошибка! Сообщите администратору!</div>";
				}else
					echo "<div class='alert alert-danger al'>Ошибка! Сообщите администратору!</div>";
				return;
			}
		}else{
			return;
		}
	}

	function checkLogin($login, $status){
		require './../lib/db.php';
		if($status == 0){
			$query = "SELECT * FROM students WHERE login=".$login;
			$stmt = mysqli_query($connect, $query);
			$result = mysqli_fetch_assoc($stmt);
			if($result['login'] == ''){
				echo "<div class='alert alert-warning al'>Вы не внесены в список группы, попросите старосту!</div>";
				return false;
			}
			return true;
		}
		return true;
	}

	function checkGroup($status, $group){
		require './../lib/db.php';
		$query = "SELECT * FROM students WHERE grup='".$group."'";
		$stmt = mysqli_query($connect, $query);
		if($stmt){
			if($status == 1){
				echo "<div class='alert alert-warning al'>Группа уже внесена в базу, староста может быть только 1!</div>";
				return false;
			}else{
				return true;
			}
		}else if(!$stmt){
			if($status == 1)
				return true;
			else{
				echo "<div class='alert alert-warning al'>Группа еще не внесена в базу, попросите старосту зарегистрироваться!</div>";
				return false;
			}
		}
	}

	if(isset($_POST['login']) && isset($_POST['pass1']) && isset($_POST['email']) && isset($_POST['status']) && isset($_POST['group']) && isset($_POST['fio']))
		register($_POST['login'], $_POST['pass1'], $_POST['email'], $_POST['status'], $_POST['group'], $_POST['fio']);
?>