function toggleTab(tab){
	if(tab == 1){
		$("#week_1_tab").attr('class', "tab-pane fade in active");
		$("#week_2_tab").attr('class', "tab-pane fade");
	}else if(tab == 2){
		$("#week_2_tab").attr('class', "tab-pane fade in active");
		$("#week_1_tab").attr('class', "tab-pane fade");
	}
}