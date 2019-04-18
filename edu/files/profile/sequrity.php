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
* /files/admin/handler/sequrity.php - it's a check - have user permission or not 
* -Last update: 27.01.2018
* 
*
*/

	function checkHash($hash, $login){
		global $connect;
		$query = "SELECT * FROM students WHERE login='".$login."'";
		$stmt = mysqli_query($connect, $query)or die(mysqli_error($connect));
		$result = mysqli_fetch_assoc($stmt);
		$realHash = $result['hash'];
		//if($result['timed'] >= time()){
			if($hash == $realHash)
				return true;
			else
				return false;
		//}else
		//	return false;
	}

	function getHash($login){
		global $sconfig, $connect;
		$query = "SELECT * FROM students WHERE login='".$login."'";
		$stmt = mysqli_query($connect, $query)or die(mysqli_error($connect));
		$result = mysqli_fetch_assoc($stmt);
		if($stmt == true){
			if($result['hash'] != ''){
				//if($result['timed'] >= time())
					return $result['hash'];
				//else
				//	return createHash($login);	
			}else
				return createHash($login);
		}else
			return false;
	}

	function createHash($login){
		global $sconfig, $connect;
		$time = time();
		$timed = ($time+86400);
		$hash = md5($login.$time);
		$query = "UPDATE students SET hash='".$hash."' WHERE login='".$login."'";
		$stmt = mysqli_query($connect, $query)or die(mysqli_error($connect));
		if($stmt == true)
			return $hash;
		else
			return 'error';
	}

?>