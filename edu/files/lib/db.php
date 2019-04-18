<?
/**
*  _ 		 _   __________   ___________    ________		 	 _________   ___    ___   _________	
* | |		| | |  ______  | |____   ____| |  ______  | 		|  _______|	|   \  /   | |  _______|
* | |_______| | | |		 | |	  | | 	   | |______| |			| |			| |\ \/	/| | | |_______		  
* |  _______  | | |    	 | |	  | |      |  ______  |			| |			| |	\__/ | | |_______  |
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
* /files/lib/db.php - library for connection to data base (modifed for edu.wolfeco.ru)
* -Last update: 28.02.2019
* 
*
*/
	$sconfig = array(
		'DBHost' => 'localhost',
		'DBUser' => 'root',
		'DBPass' => 'root',
		'DB'	 => 'wolfeco',
		'DBTablePrefix'=> 'Hota_'
	);

	$connect = mysqli_connect($sconfig['DBHost'],$sconfig['DBUser'],$sconfig['DBPass'],$sconfig['DB']);//conecting to mysqli host
	if(!$connect){
	    require_once 'files/handler/error.php';
	    error_send('mysql');
	}else{
		mysqli_set_charset($connect, 'utf8');
	}
?>