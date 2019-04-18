<?
/**
*  _ 		 _   __________   ___________    ________ 		 	 _________   ___    ___   _________	
* | |		| | |  ______  | |____   ____| |  ______  | 		|  _______|	|   \  /   | | ________|
* | |_______| | | |		 | |	  | | 	   | |______| |			| |			| |\ \/	/| | | |_______		  
* |  _______  | | |    	 | |	  | |      |  ______  |			| |			| |	\_/	 | | |_______  |
* | |		| | | |______| |      | |      | |		| |			| |_______  | |		 | |  _______| |
* |_|		|_| |__________|      |_|      |_|      |_|			|_________| |_|		 |_| |_________|
*
* WolfEco Public License v1.0
*
* The software of WolfEco team can be released of 3 types - full public, mixed public, closed.
*
* HOTA CMS - it's a mixed public sofware
* WolfEco team can close a part of code from public access (or make obfuscation of this part)  at own discretion.
* You are not allowed to access the closed part of the code, nor modify it.
*
* @author WoflEco team
* @link http://wolfeco.ru/page/cms
*
* /files/profile/login.php - login handler
* -Last update: 29.01.2018
* 
*
*/
	if(!isset($_SESSION)){
		session_start();
	}
	function check_pass($login, $gpass){
		require_once 'sequrity.php';
		global $connect;
		if($login != ''){
			$login = mysqli_real_escape_string($connect, $login);
			$query = "SELECT * FROM students WHERE login='".$login."'";
			$stmt = mysqli_query($connect, $query)or die(mysqli_error($connect));
			$result = mysqli_fetch_assoc($stmt);
			if($stmt == true){
				$real_pass = $result['password'];
				$hash_pass = sha1(md5(md5($gpass)));
				if($hash_pass == $real_pass || $gpass == $result['hash']){
					$hash = getHash($login);
					$_SESSION['fio'] = $result['FIO'];
					$_SESSION['admin'] = $result['login'];
					$_SESSION['login'] = true;
					$_SESSION['status'] = $result['status'];
					$_SESSION['group'] = $result['grup'];
					$_SESSION['id'] = $result['id'];
					$_SESSION['email'] = $result['email'];
					$_SESSION['hash'] = $hash;
					setcookie('login', $result['login'], time()+2592000);
					setcookie('hash', $hash, time()+2592000);
					print '<script>window.location.href = "/";</script>';

				}else{
					?>
						<script>setTimeout(function(){$('.alert').fadeOut('fast')},5000);</script><div class='alert alert-danger al'>Неверный логин или пароль!</div>
					<?
				}
			}
		}else{
			?>
				<script>setTimeout(function(){$('.alert').fadeOut('fast')},5000);</script><div class='alert alert-danger al'>Введите логин!</div>
			<?
		}
	}
	//обработчики запросов js

	function unLogin(){
		$_SESSION['login'] = false;
		$_SESSION['admin'] = false;
		$_SESSION['hash'] = false;
		$_SESSION['fio'] = false;
		$_SESSION['status'] = false;
		$_SESSION['id'] = false;
		$_SESSION['email'] = false;
		$_SESSION['group'] = false;
		setcookie('login', false, 0);
		setcookie('hash', false, 0);
		print '<script>window.location.href = "/";</script>';
	}
?>