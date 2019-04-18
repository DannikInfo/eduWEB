function registerView(){
	$.ajax({
		type: "POST",
		url: 'index.php',
		success: function(result){
			$('#register').modal('show');
		}
	});
}
function register(){
	var login, pass1, pass2, email, status, group, fio;
	login = $('#Sname').val();
	pass1 = $('#Spass').val();
	pass2= $('#Spass2').val();
	email = $('#Semail').val();
	status = $('input[name=status]:checked').val()
	group = $('#Sgroup').val();
	fio = $('#SFIO').val();
	if(pass1 == pass2){
		$.ajax({
			type: "POST",
			url: 'files/profile/reg.php',
			data: {
				login: login,
				pass1: pass1,
				pass2: pass2,
				email: email,
				status: status,
				group: group,
				fio: fio
			},
			success: function(result){
				$('#register').modal('hide');
				$('.all').html("<script>setTimeout(function(){$('.alert').fadeOut('fast')},5000);</script>" + result);
			}
		});
	}else{
		$('.all').html("<script>setTimeout(function(){$('.alert').fadeOut('fast')},5000);</script><div class='alert alert-warning al'>Пароли должны совпадать!</div>");
	}
}
function search(student){
	var request;
	request = $('#search_text').val();
	if($('#search_text').val().match(/^[0-9]{2}.[0-9]{2}.[0-9]{4}$/)){
		$.ajax({
			type: "POST",
			url: 'files/pages/handler.php',
			data: {
				login: student,
				request: request
			},
			success: function(result){
				$('.searchResult').html(result);
			}
		});
	}else{
		$('.all').html("<script>setTimeout(function(){$('.alert').fadeOut('fast')},5000);</script><div class='alert alert-warning al'>Неверный формат даты! (ДД.ММ.ГГГГ)!!</div>");
	}
}

function modalView(ghash, glogin, type){
	$.ajax({
		type: "POST",
		url: '/files/profile/profile.php',
		data: {
			hash: ghash,
			login: glogin,
			view: type
		},
		success: function(result){
			$('#mod').html(result);
			$('#'+type).modal('show');
		}
	});
}

function peEdit(ghash, glogin){
	var fio, login, email, opass, pass1, pass2;
	fio = $('#fio').val();
	login = $('#login').val();
	email = $('#email').val();
	opass = $('#oldPass').val();
	pass1 = $('#pass1').val();
	pass2 = $('#pass2').val();
	if(pass1 == pass2){
		$.ajax({
			type: "POST",
			url: '/files/profile/profile.php',
			data: {
				hash: ghash,
				login: glogin,
				fio: fio,
				login2: login,
				email: email,
				opass: opass,
				pass: pass1,
				handle: 'peEdit'
			},
			success: function(result){
				$('.all').html(result);
				$('#profile').modal('hide');
			}
		});
	}else{
		$('.all').html("<script>setTimeout(function(){$('.alert').fadeOut('fast')},5000);</script><div class='alert alert-warning al'>Пароли должны совпадать!</div>");
	}
}