<?
/**{
	"students":{
	 	"2": {
	 		"visits":{
	 			"1": {
	 				"visit": true,
	 				"subjectID": 1
	 			}, 
	 			"2": {
	 				"visit": false,
	 				"subjectID": 2
	 			}
	 		}
	 	}
	}
}*/

	function vsMain(){
		print '
   		<div class="row">
    		<div class="col-lg-8 col-md-8 col-sm-10 col-xs-12 col-lg-offset-2 col-md-offset-2 col-sm-offset-1">
            	<div class="input-group">
                	<input id="search_text" name="query" type="text" class="form-control typeahead input-fix" placeholder="Дата (дд.мм.гггг)" data-provide="typeahead">
                	<span class="input-group-btn hidden-xs">
                    	<button id="search_btn" name="search" class="btn btn-primary" title="Поиск">
                        	<i class="fa font-icons-icon fa-search"></i>
                    	</button>
                	</span>
            	</div>                                
        	</div>
    	</div>
    	<div class="col-xs-12 visible-xs text-center">
        	<button id="search_btn" name="search" class="btn btn-primary" title="Поиск">
            	<i class="fa font-icons-icon fa-search"></i>
            	Поиск
        	</button>
    	</div>
		';
		$today = date('d.m.Y', time());
		print '<h3 class="text-center">'.$today.'</h3>';
		
	}

	if(isset($_POST['hash']) && isset($_POST['login'])){
		require 'sequrity.php';

		if(checkHash($_POST['hash'], $_POST['login'])){

			if(isset($_POST['view'])){
				if($_POST['view'] == 'vsMain')
			//		vsMain();
			}

			if(isset($_POST['handle'])){
			}
		}else{
			?><script>setTimeout(function(){$('.alert').fadeOut('fast')},5000);</script><div class='alert alert-danger al'>Ошибка доступа!</div><?
		}
	}
?>
