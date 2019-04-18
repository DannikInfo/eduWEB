<?
	
	function getCloudLink(){
		require 'files/lib/db.php';
		$query = "SELECT * FROM groups WHERE grup='".$_SESSION['group']."'";
		$stmt = mysqli_query($connect, $query) or die(mysqli_error($connect));
		$result = mysqli_fetch_assoc($stmt);
		return $result['cloud'];
	}

	function thisDir(){
		$cDir = getCwd();
		$aDirs = explode('/', $cDir);
		$j = 0;
		$i = count($aDirs);
		$i--;
		for($i; $i >= 0; $i--){
			$j++;
			if($aDirs[$i] == "edu"){
				$j--;
				break;
			}
		}
		for($j; $j > 0; $j--)
			chdir('../');
	}

	//Return list of template files or errors from data base 
	function fileList(){
		chdir('./../cloud/books/'); //Move to template directory
		
		if ($handle = opendir(getcwd())) { //Open dir
		    echo '<ul class="list-group">';
		    while (false !== ($entry = readdir($handle))) { //While directory not end - return files list
		    	if ($entry != "." && $entry != ".DS_Store" && $entry != "..") { //Filter trash
		    		if(is_dir($entry)){ //IF dir then return button with folder icon 
		       			echo '<a href="#" class="list-group-item cat"><i class="fa fa-folder-o" aria-hidden="true"></i> '.$entry.'</a>';
		       		}else{ //else return file button
		       			$FileInfo = new SplFileInfo($entry); //Get file info
		       			$ext = $FileInfo->getExtension(); //Get file extension
		       			if($ext == "png" or $ext == "jpg" or $ext == "bmp") //IF file is image then return button with image icon
		       				echo '<a href="/files/cloud/books/'.$entry.'" class="list-group-item file"><i class="fa fa-file-image-o" aria-hidden="true"></i> '.$entry.'</a>';
		       			else //Else return button with file-code icon
		       				echo '<a href="/files/cloud/books/'.$entry.'" class="list-group-item file"><i class="fa fa-file-o" aria-hidden="true"></i> '.$entry.'</a>';
		       		}
		    	}
		    }
		    echo '</ul>';
		    closedir($handle); //Close dir
		}
	}

	function timeTable($grup){
		require_once './../lib/db.php';
		$date = date('d.m.Y');
		$week = (date('W') % 2);
		$a1 = '';
		$a2 = '';
		if($week == 0){
			$week = "2 Неделя";
			$a2 = 'active';
		}
		else{
			$week = "1 Неделя";
			$a1 = 'active';
		}
		print ' 
 		<link rel="stylesheet" href="/files/system/css/time.css">
 		<h1 class="text-center">Расписание ('.$grup.')</h1>
		<div class="container">
            <h3 class="text-center bold">
                2 семестр 2018-2019г.
            </h3>
            <h4 class="text-center bold">
       			'.$date.' - '.$week.'
			</h4>
            <div class="row timetable">
                <div class="col-lg-10 col-md-10 col-sm-10  col-xs-12 col-lg-offset-1 col-md-offset-1 col-sm-offset-1">
                    <div class="tab-content">                    
			            <div id="timetable_tab" name="timetable_tab" class="tab-pane fade in active" role="tabpanel">
            
				            <ul class="nav nav-pills navbar-right n_week" role="tablist">
                
			                    <li class="'.$a1.'">
			                        <a data-toggle="tab" href="#week_1_tab" onClick="toggleTab(1)">
			                            1 неделя
				                    </a>
			                    </li>
                
			                    <li class="'.$a2.'">
			                        <a data-toggle="tab" href="#week_2_tab" onClick="toggleTab(2)">
			                            2 неделя
			                        </a>
			                    </li>
                
				            </ul>
				            <div class="tab-content">               
        ';
		$query = "SELECT * FROM timeTable WHERE grup='".$grup."'";
		$stmt = mysqli_query($connect, $query) or die(mysqli_error($connect));
		$result = mysqli_fetch_assoc($stmt);
		$dayW = array(
			'1' => 'Понедельник',
			'2' => 'Вторник',
			'3' => 'Среда',
			'4' => 'Четверг',
			'5' => 'Пятница',
			'6' => 'Суббота',
			'7' => 'Воскресенье'
		);
		$type = array(
			'0' => 'Лекция',
			'1' => 'Практика',
			'2' => 'Лаб.р'
		);
		$d = 0;
		$wB = false;

        do{
	        if($result['week'] == 1){
	        	if($d == $result['dayW'])
	        		continue;
	        	if(!$wB){	
	        		$wB = true;
	        		print '<div role="tabpanel" id="week_1_tab" name="week_1_tab" class="tab-pane fade';
	        		if((date('W') % 2) != 0)
	        			print ' in active">';
	        		else
	        			print '">';
				   	print '<div class="">';
	        	}
	        	line($dayW, $type, $result, $connect);
           		$d = $result['dayW'];
            }
    	}while($result = mysqli_fetch_assoc($stmt));
    	print '</div></div>';

		$d = 0;
		$wB = false;
		$stmt2 = mysqli_query($connect, $query) or die(mysqli_error($connect));
		$result2 = mysqli_fetch_assoc($stmt2);
    	do{
    		if($result2['week'] == 2){
	        	if($d == $result2['dayW'])
	        		continue;
	        	if(!$wB){	
	        		$wB = true;
	        		print '<div role="tabpanel" id="week_2_tab" name="week_2_tab" class="tab-pane fade';
	        		if((date('W') % 2) == 0)
	        			print ' in active">';
	        		else
	        			print '">';
				   	print '<div class="">';
	        	}
	    		line($dayW, $type, $result2, $connect);
	    		$d = $result2['dayW'];
            }
        }while($result2 = mysqli_fetch_assoc($stmt2));
        print '</div>
			</div>';

    	mysqli_close($connect);
    	print '				</div>
    					</div>
    				</div>
    			</div>
    		</div>
    	</div>';
	}

	function line($dayW, $type, $result, $connect){
		$today = '';
		$d = $result['dayW'];
        $w = $result['week'];
		$week = (date('W') % 2);
		if($week == 0)
			$week = 2;
		else
			$week = 1;
		if($result['dayW'] == date('w') && $w == $week)
			$today = '<span class="badge">сегодня</span>';
		print'          
            <div class="header">
                <div class="name text-center">
                    <div>'.$dayW[$result['dayW']].' '.$today.'</div>
                </div>
                <div class="bold time text-center">
                    <span>Время</span>
                </div>
                <div class="bold discipline">
                    <span>Дисциплина</span>
                </div>
            </div>
            <div class="body">';
        $query2 = "SELECT * FROM timeTable";
		$stmt2 = mysqli_query($connect, $query2) or die(mysqli_error($connect));
        $result2 = mysqli_fetch_assoc($stmt2);
        do{
        	if($d == $result2['dayW'] && $w == $result2['week']){
        		$tS = explode(':', $result2['timeS']);
        		$tE = explode(':', $result2['timeE']);
           		print '<div class="line">
                    <div class="time text-center">
                        <div class="hidden-xs">
                            <i class="fa fa-clock-o hidden-sm"></i>
                            '.$tS[0].':'.$tS[1].'-'.$tE[0].':'.$tE[1].'
                        </div>
                        <div class="visible-xs">
                        	'.$tS[0].':'.$tS[1].'-'.$tE[0].':'.$tE[1].'
                        </div>
                    </div>
                    <div class="discipline">
                        <div class="row">
                            <div class="col-md-12"><ul class="list-unstyled"><li><i class="fa fa-bookmark"></i><span class=\'name\'>'.$result2['subject'].'</span> ('.$type[$result2['type']].')<br/></li><li><i class="fa fa-user"></i>'.$result2['tutor'].'<br/></li><li><i class="fa fa-compass"></i>корп. "'.$result2['corps'].'" каб. "'.$result2['aud'].'"</a></li></ul></div>
                        </div>
                    </div>
                </div>';
            }
        }while($result2 = mysqli_fetch_assoc($stmt2));
        print '</div>';
	}
	//----progress------
	function semester($connect){
		$query_sr = "SELECT * FROM groups WHERE grup='".$_SESSION['group']."'";
		$stmt_sr = mysqli_query($connect, $query_sr) or die(mysqli_error($connect));
		$result_sr = mysqli_fetch_assoc($stmt_sr);
		$year = date('Y',time()); 
		$month = date('m',time());
		$time = strtotime($result_sr['yearStartStudy']);
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
	function progress($stID, $grup){
		require_once './../lib/db.php';
		$query = "SELECT * FROM progress WHERE studentID='".$stID."'";
		$stmt = mysqli_query($connect, $query) or die(mysqli_error($connect));
		$result = mysqli_fetch_assoc($stmt); 
		print '
			<div class="wrapper navfix">
			<table class="table table-striped">
				<tr><th class="table-thl-fix">Предмет</th><th>1 аттестация</th><th>2 аттестация</th><th>3 аттестация</th></tr>
		';
		$query_ss = "SELECT * FROM subjects WHERE grup='".$_SESSION['group']."' AND semester=".semester($connect);
		$stmt_ss = mysqli_query($connect, $query_ss) or die(mysqli_error($connect));
		$result_ss = mysqli_fetch_assoc($stmt_ss);	
		$subjects = json_decode($result_ss['data']);
		for($i = 0; isset($subjects->{$i}); $i++){
			$att = array(
				'0' => 0,
				'1' => 0,
				'2' => 0
			);
			$data = json_decode($result['data']);
			for($b = 0; $b < 3; $b++){
				if(isset($data->{'progress'}->{$b}->{'subjects'}->{$i})){
					$att[$b] = $data->{'progress'}->{$b}->{'subjects'}->{$i}->points;
				}
			}
			print '<tr><td>'.$subjects->$i.'</td><td>'.$att[0].'</td><td>'.$att[1].'</td><td>'.$att[2].'</td></tr>';
		}
		print '</table></div>';
	}
	//----progress-end---
	//----visits----
	function visits($stID, $grup){
		require_once './../lib/db.php';
		$query = "SELECT * FROM visits";
		$stmt = mysqli_query($connect, $query) or die(mysqli_error($connect));
		$result = mysqli_fetch_assoc($stmt);
		$data = array();
		$date = array();
		do{
			$date[] = $result['date'];
			$data[] = json_decode($result['data']);
		}while($result = mysqli_fetch_assoc($stmt));

		$visit = 0;
		$novisit = 0;
		for($i = 0; $i < count($data); $i++){
			for($j = 0; $j < 8; $j++){
				if(isset($data[$i]->{"students"}->{$stID}->{"visits"}->{$j}))
					if($data[$i]->{"students"}->{$stID}->{"visits"}->{$j}->visit)
						$visit++;
					else
						$novisit++;
			}
		}
		print'
			<h3 class="text-center">Посещений: '.$visit.' Пропусков: '.$novisit.'</h3>
                <div>
                    <div class="row">
                        <div class="col-lg-8 col-md-8 col-sm-10 col-xs-12 col-lg-offset-2 col-md-offset-2 col-sm-offset-1">
                            <div class="input-group">
                                <input id="search_text" name="query" type="text" class="form-control typeahead input-fix" placeholder="Дата (дд.мм.гггг)" data-provide="typeahead">
                                <span class="input-group-btn hidden-xs">
	                                <button id="search_btn" name="search" class="btn btn-primary" onClick="search(\''.$stID.'\')" title="Поиск">
    	                                <i class="fa font-icons-icon fa-search"></i>
        	                        </button>
                                </span>
                            </div>                                
                        </div>
                    </div>
                    <div class="col-xs-12 visible-xs text-center">
                        <button id="search_btn" name="search" class="btn btn-primary" onClick="search(\''.$stID.'\')" title="Поиск">
                            <i class="fa font-icons-icon fa-search"></i>
                            Поиск
                        </button>
                    </div>
                </div>
		';
	}

	function searchResult($request, $stID){
		$request2 = DateTime::createFromFormat('d.m.Y', $request);
		$request2 = $request2->format('Y-m-d');
		require_once './../lib/db.php';
		$query = "SELECT * FROM visits";
		$stmt = mysqli_query($connect, $query) or die(mysqli_error($connect));
		$result = mysqli_fetch_assoc($stmt);

		$data = array();
		$date = array();
		do{
			$date[] = $result['date'];
			$data[] = json_decode($result['data']);
		}while($result = mysqli_fetch_assoc($stmt));
		for($i = 0; $i < count($date); $i++){
			if($date[$i] == $request2)
				$data = $data[$i];
		}
		$visits = array(
			"1" => "+",
			"0" => "-"
		);
		
		print '<h3 class="text-center">'.$request.'</h3>';
		print '
		<div class="row">
			<div class="col-md-4"></div><div class="col-md-4">
			<table class="table table-striped">
				<tr><th class="table-thl-fix">Предмет</th><th>Посещал</th></tr>
		';

		for($i = 0; $i < 8; $i++){
			if(isset($data->{"students"}->{$stID}->{"visits"}->{$i})){
				//subjectsTable
				$query2 = "SELECT * FROM subjects WHERE id='".$data->{"students"}->{$stID}->{"visits"}->{$i}->subjectID."'";
				$stmt2 = mysqli_query($connect, $query2) or die(mysqli_error($connect));
				$result2 = mysqli_fetch_assoc($stmt2);
				print '<tr><td>'.$result2['subject'].'</td><td>'.$visits[$data->{"students"}->{$stID}->{"visits"}->{$i}->visit].'</td></tr>';
			}
		}
		print '</table></div></div>';
	}

	//----visits-end----
	if(isset($_POST['function'])){
		if($_POST['function'] == 2){
			fileList($_POST['dir'], '1');
		}
		if($_POST['function'] == 3){
			openFile($_POST['file']);
		}
	}
	if(isset($_POST['request'])){
		searchResult($_POST['request'], $_POST['login']);
	}

?>