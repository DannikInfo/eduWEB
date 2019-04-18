function groupList(shash, slogin){
	$.ajax({
		type: "POST",
		url: '/files/admin/handler/timetable.php',
		data: {
			hash: shash,
			login: slogin,
			view: 'group'
		},
		success: function(result){
			$('.timetable').html(result);
		}
	});
}
function groupSel(shash, slogin, sgroup, sweek){
	$.ajax({
		type: "POST",
		url: '/files/admin/handler/timetable.php',
		data: {
			hash: shash,
			login: slogin,
			group: sgroup,
			week: sweek,
			view: 'days'
		},
		success: function(result){
			$('.timetable').html(result);
		}
	});
}
function daySel(shash, slogin, sgroup, sweek, sday){
	$.ajax({
		type: "POST",
		url: '/files/admin/handler/timetable.php',
		data: {
			hash: shash,
			login: slogin,
			group: sgroup,
			week: sweek,
			day: sday,
			view: 'lines'
		},
		success: function(result){
			$('.timetable').html(result);
		}
	});
}
function lineHandle(ghash, glogin, gid, sgroup, sweek, sday, type){
	var subject, line, tutor, corps, aud, type;
	gsubject = $('#subject').val();
	gline = $('#line').val();
	gtutor = $('#tutor').val();
	gcorps = $('#corps').val();
	gaud = $('#aud').val();
	gtype = $('#type').val();
	$.ajax({
		type: "POST",
		url: '/files/admin/handler/timetable.php',
		data: {
			hash: ghash,
			login: glogin,
			subject: gsubject,
			line: gline,
			tutor: gtutor,
			corps: gcorps,
			group: sgroup,
			aud: gaud,
			week: sweek,
			day: sday,
			type: gtype,
			id: gid,
			handle: type
		},
		success: function(result){
			$('.all').html(result);
			$('#'+type).modal('hide');
			daySel(ghash, glogin, sgroup, sweek, sday);
			sSynch(ghash, glogin);
		}
	});
}
function fileListHandler(gdir, func, htm){
	$.ajax({
		type: "POST",
		url: '/files/pages/handler.php',
		data: {
			dir:gdir,
			function:func
		},
		success: function(result){
			$(htm).html(result);
		}
	});
}
//----
function groupInfo(ghash, glogin){
	$.ajax({
		type: "POST",
		url: '/files/admin/handler/group.php',
		data: {
			login:glogin,
			hash:ghash,
			view: 'info'
		},
		success: function(result){
			$(".group").html(result);
		}
	});
}

function modalView(ghash, glogin, type, stID=0, file='group', sgroup='', sweek='', sday=''){
	$.ajax({
		type: "POST",
		url: '/files/admin/handler/'+file+'.php',
		data: {
			hash: ghash,
			login: glogin,
			id: stID,
			group: sgroup,
			week: sweek,
			day: sday,
			view: type
		},
		success: function(result){
			$('#mod').html(result);
			$('#'+type).modal('show');
		}
	});
}
function cloudEdit(ghash, glogin){
	var link;
	link = $('#link').val();
	$.ajax({
		type: "POST",
		url: '/files/admin/handler/group.php',
		data: {
			login: glogin,
			hash: ghash,
			link: link,
			handle: 'cloud'
		},
		success: function(result){
			$('.all').html(result);
			$('#cloud').modal('hide');
			groupInfo(ghash, glogin);
		}
	});
}
function stEdit(ghash, glogin){
	var login, fio, status1, status2, id;
	login = $('#login').val();
	id = $('#id').val();
	fio = $('#FIO').val();
	status1 = $('input[id=1dayStatus]:checked').val();
	status2 = $('input[id=moveStatus]:checked').val();
	$.ajax({
		type: "POST",
		url: '/files/admin/handler/group.php',
		data: {
			login: glogin,
			hash: ghash,
			id: id,
			newLogin: login,
			fio: fio,
			status1: status1,
			status2: status2,
			handle: 'stEdit'
		},
		success: function(result){
			$('.all').html(result);
			$('#stEdit').modal('hide');
			groupInfo(ghash, glogin);
		}
	});
}
function stAdd(ghash, glogin){
	var login, fio;
	login = $('#login').val();
	fio = $('#FIO').val();
	$.ajax({
		type: "POST",
		url: '/files/admin/handler/group.php',
		data: {
			login: glogin,
			hash: ghash,
			login2: login,
			fio: fio,
			handle: 'stAdd'
		},
		success: function(result){
			$('.all').html(result);
			$('#stAdd').modal('hide');
			groupInfo(ghash, glogin);
		}
	});
}
function stRemove(ghash, glogin, gid){
	$.ajax({
		type: "POST",
		url: '/files/admin/handler/group.php',
		data: {
			login: glogin,
			hash: ghash,
			stID: gid,
			handle: 'stRemove'
		},
		success: function(result){
			$('.all').html(result);
			$('#stRemove').modal('hide');
			groupInfo(ghash, glogin);
		}
	});
}
function sSynch(ghash, glogin){
	$.ajax({
		type: "POST",
		url: '/files/admin/handler/subjects.php',
		data: {
			login: glogin,
			hash: ghash,
			handle: 'sSync'
		},
		success: function(result){
			$('.all').html(result);
		}
	});
}
//---------------
function groupProgress(ghash, glogin){
	$.ajax({
		type: "POST",
		url: '/files/admin/handler/progress.php',
		data: {
			login: glogin,
			hash: ghash,
			view: 'progress'
		},
		success: function(result){
			$(".progres").html(result);
		}
	});
}
function psEdit(ghash, glogin, sCount, stID){
	var pointsArray, dat;
	pointsArray = [[], [], []];
	dat = $("#data").val();
	for(j = 0; j < 3; j++){
		for(i = 0; i < sCount; i++){
			pointsArray[j][i] = $('#points_'+j+'_'+i).val();
		}
	}
	$.ajax({
		type: "POST",
		url: '/files/admin/handler/progress.php',
		data: {
			login: glogin,
			hash: ghash,
			stID: stID,
			pointsArray: pointsArray,
			dat: dat,
			handle: 'psEdit'
		},
		success: function(result){
			$('.all').html(result);
			$('#psEdit').modal('hide');
			groupProgress(ghash, glogin);
		}
	});
}
//----------
function vsMain(ghash, glogin){
	$.ajax({
		type: "POST",
		url: '/files/admin/handler/visits.php',
		data: {
			login: glogin,
			hash: ghash,
			view: 'vsMain'
		},
		success: function(result){
			$(".visits").html(result);
		}
	});
}
function exitSession(){
	$.ajax({
	  	type: "GET",
	  	url: "/",
	 	data: "exit=1",
	  	success: function(){
	  		window.location.href = "/";
		}
	});
}
