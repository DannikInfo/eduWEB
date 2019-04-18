<?

	$is = fopen("input.txt", 'r');

	$str = array();  
	while(!feof($is)){
		$str[] = fgets($is);
	}

	fclose($is);

	$intArray = explode(' ', $str[1]);
	$summ = 0;
	for($i = 0; $i < count($intArray); $i++){
		for($j = 0; $j < count($intArray); $j++){
			if($i != $j)
				if($intArray[$i] == $intArray[$j])
					$intArray[$i] = 0;
		}
		$summ += $intArray[$i];
	}

	$os = fopen("output.txt", 'w');
	fwrite($os, $summ);
	fclose($os);
/*	
	$code = 'A15BA5';
	$decode = '';
	$codeB = '';

	preg_match_all('/(\d)|(\w)/', $code, $codeA);

	for($i = 0; $i < count($codeA['2']); $i++){
		if($codeA['1'][$i] != '')
			$codeB .= $codeA['1'][$i];
		else
			$codeB .= ':';
	}

	print $codeB;
*/
	//print $encode;
?>