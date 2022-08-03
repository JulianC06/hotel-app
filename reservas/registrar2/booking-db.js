function searchEvent(event,input){
	if(event!=undefined){
		if(event.keyCode==13)
			input.nextElementSibling.onclick.call();
	}
}

function searchHolder(input){
	if(input.value!="")
		$.ajax({
			type: 'post',
			url: '/includes/get.php',
			data: 'entity=searchPerson&idPerson='+input.value
		}).then(function(ans){
			var data=ans.split(";");

			if(data.length==13){
				showAlert("alert-s","Se ha encontrado la información del cliente buscado");
				setHolderValues(data);
			}else{
				showAlert("alert-i","No se encontró ninguna persona con ese número de documento");
			}
		});
	else
		showAlert('alert-i','No hay ningún valor en el buscador');
}

function searchPerson(input){
	if(input.value!="")
		$.ajax({
			type: 'post',
			url: '/includes/get.php',
			data: 'entity=searchPerson&idPerson='+input.value
		}).then(function(ans){
			var data=ans.split(";");

			if(data.length==13){
				showAlert("alert-s","Se ha encontrado la información del cliente buscado");
				setPersonValues(data);
			}else{
				showAlert("alert-i","No se encontró ninguna persona con ese número de documento");
			}
		});
	else
		showAlert('alert-i','No hay ningún valor en el buscador');
}

function setPersonValues(data){
	document.getElementById('person-id').value=data[0];
	var inputs=document.getElementById('person-card-body').getElementsByTagName('input');
	inputs[0].value=data[4];
	inputs[1].value=data[5];
	inputs[3].value=data[11];
	inputs[4].value=data[12];
}

function setHolderValues(data){
	document.getElementById('holder-id').value=data[0];
	var inputs=document.getElementById('person-holder').getElementsByTagName('input');
	inputs[0].value=data[4];
	inputs[1].value=data[5];
	inputs[2].value=data[11];
	inputs[3].value=data[12];
}

function searchBizz(input){
	if(input.value!="")
		$.ajax({
			type: 'post',
			url: '/includes/get.php',
			data: 'entity=searchPerson&idPerson='+input.value
		}).then(function(ans){
			var data=ans.split(";");

			if(data.length==13){
				setValues(input,data);
			}else{
				showAlert("alert-i","No se encontró ningun cliente con ese número de documento");
			}
		});
	else
		showAlert('alert-i','No hay ningún valor en el buscador');
}

function showBizzInfo(select){
	if(select.value!="")
		$.ajax({
			type: 'post',
			url: 'get.php',
			data: 'action=bizz&id='+select.value
		}).then(function(ans){
			var data=ans.split(";");

			if(data.length==4){
				setBizzValues(data);
			}else{
				showAlert("alert-i","No se encontró ninguna empresa con ese NIT");
			}
		});
	else
		showAlert('alert-i','No hay ningún valor en el buscador');
}

function searchRegRoom(id){
	return $.ajax({
		type: 'post',
		url: 'get.php',
		data: 'action=regRoom&id='+id
	}).then(function(ans){
		var data=ans.split(";");
		
		if(data.length==6){
			setRegRoomValues(data);
		}
	});
}

function setRegRoomValues(data){
	var q=document.getElementById('room-quantity');
	var tp=document.getElementById('room-types');
	var n=document.getElementById('room-numbers');
	var tf=document.getElementById('room-tariffs');
	var op,p;

	q.value=data[0];

	new Promise(function(resolve){
		resolve(function(){
			q.onchange.call(q);
		});
	}).then(function(){
		tp.value=data[1];

		return new Promise(function(resolve){
			resolve(function(){
				tp.onchange.call(tp);
			});
		});
	}).then(function(){
		op= document.createElement('option');
		op.value=data[2];
		op.innerHTML=data[4];
		n.appendChild(op);

		n.value=data[2];

		op= document.createElement('option');
		op.value=data[3];
		op.innerHTML=data[5];
		tf.appendChild(op);
		tf.value=data[3];
	});
}

function setBizzValues(data){
	var bizzData=document.getElementById('bizz-data');
	bizzData.getElementsByTagName('input')[0].value=data[3];
	bizzData.hidden=false;
}

function updateRoomTypes(select){
	 $.ajax({
		type: 'post',
		url: '/includes/get.php',
		data: 'entity=roomQuantity&roomQuantity='+select.value
		+"&startDate='"+document.getElementById("check-in").value
		+"'&finishDate='"+document.getElementById("check-out").value+"'",
		success: function (ans) {
			document.getElementById('room-types').innerHTML=ans;
			updateRooms();
		}
	});
}

function updateRooms(){
	 $.ajax({
		type: 'post',
		url: '/includes/get.php',
		data: 'entity=roomType&roomType='+document.getElementById('room-types').value
		+"&startDate='"+document.getElementById("check-in").value
		+"'&finishDate='"+document.getElementById("check-out").value+"'",
		success: function (ans) {
			document.getElementById('room-numbers').innerHTML=ans;
			updateRoomTariff();
		}
	});
}

function updateRoomTariff(){
	 $.ajax({
		type: 'post',
		url: '/includes/get.php',
		data: 'entity=roomTariff&roomQuantity='+document.getElementById('room-quantity').value
		+'&roomType='+document.getElementById('room-types').value,
		success: function (ans) {
			document.getElementById('room-tariffs').innerHTML=ans;
		}
	});
}

function insert(data){
	return $.ajax({
		type: 'post',
		url: 'insert.php',
		data: data
	});
}

function update(data){
	return $.ajax({
		type: 'post',
		url: 'update.php',
		data: data
	});
}


function remove(data){
	return $.ajax({
		type: 'post',
		url: 'remove.php',
		data: data
	});
}

function insertHolder(form){
	var inputs=form.getElementsByTagName('input');
	var selects=form.getElementsByTagName('select');
	var data;

	if(inputs[0].value=='P'){
		data="entity=holder&id="+inputs[1].value
			+"&fname="+inputs[2].value
			+"&lname="+inputs[3].value
			+"&phone="+inputs[4].value
			+(inputs[5].value==''?'':"&email="+inputs[5].value);
	}else{
		data="entity=bizz&id="+selects[0].value+"&phone="+inputs[1].value;
	}

	insert(data).then(function(ans){
		var aux=ans.split(";");
		
		if(aux[0]!=='null'){
			if(inputs[0].value=='P')
				inputs[1].value=aux[0];
			showAlert('alert-s',aux[1]);
			location.href='?type='+inputs[0].value
			+'&holder-id='+(inputs[0].value=='P'?inputs[1].value:selects[0].value)
			+(document.getElementById('holder-stay').checked?'&holder-stay=on':'');
		}	
	});
}

function insertPerson(form){
	var inputs=form.getElementsByTagName('input');// 0 checkin,1 search, 2 id, 3 name, 4lname, 5 ndoc,6 phone, 7 email, 8 bdate
	var selects=form.getElementsByTagName('select');//0 tdoc, 1 countries, 2 cities, 3 gender, 4 blood, 5 rh, 6 prof, 7 nac 
	var data="entity=person"
			+(inputs[2].value==""?"":"&id="+inputs[2].value)
			+"&fname="+inputs[3].value
			+"&lname="+inputs[4].value
			+"&phone="+inputs[6].value.replace(/\ /g,"");
			+(inputs[7].value==''?'':"&email="+inputs[7].value);

	if(document.getElementById('check-in-state').checked){
		data+="&d-type="+selects[0].value
			+"&d-number="+inputs[5].value
			+"&d-city="+selects[2].value
			+"&gender="+selects[3].value
			+"&bloodRh="+selects[4].value+(selects[5].value=="+"?"p":"-")
			+"&bornDate="+inputs[8].value
			+(selects[6].value=="NULL"?"":"&prof="+selects[6].value)
			+"&nac="+selects[7].value;	
	}

	insert(data).then(function(ans){
		var aux=ans.split(";");

		if(aux[0]!=='null'){
			inputs[2].value=aux[0];
			showAlert('alert-s',aux[1]);
			insertRegPerson(aux[0]);
		}	
	});
}

function insertRegPerson(id){
	insert("entity=regPerson&id="+id+"&regRoom="+document.getElementById('room-id').value)
	.then(function(ans){
		console.log(ans);
		location.reload();
	});
}

function insertBooking(form,idu){
	var inputs=form.getElementsByTagName('input');
	
	insert("entity=booking&sdate="+inputs[3].value
		+"&fdate="+inputs[4].value
		+"&type="+inputs[1].value
		+"&id="+inputs[0].value
		+"&id-user="+idu
	).then(function(ans){
		var aux=ans.split(";");
		console.log(ans);
		if(aux[0]!=='null'){
			inputs[2].value=aux[0];
			showAlert('alert-s',aux[1]);
			location.href="?booking-id="+inputs[2].value+"&rooms="+inputs[6].value;
		}
	});
}

function insertRoom(form,bookingId){
	var inputs=form.getElementsByTagName('input');
	var selects=form.getElementsByTagName('select');

	insert("entity=room&id="+inputs[0].value
		+"&booking-id="+bookingId
		+"&room-id="+selects[2].value
		+(selects[3].value=='O'?"":"&tariff-id="+selects[3].value)
		+"&tariff="+inputs[1].value.replace(/\./g,''))
	.then(function(ans){
		var aux=ans.split(";");

		if(aux[0]!=='null'){
			inputs[0].value=aux[0];
			showAlert('alert-s',aux[1]);

			location.reload();
		}
	});
}

function removeRoomOfDB(id){
	return remove("entity=regRoom&id="+id);
}

function confirmBooking(id){
	update("action=activateBooking&id="+id)
	.then(function(ans){
		var aux=ans.split(";");

		if(aux[0]!=='null'){
			showAlert('alert-s',aux[1]);
			location.href='/reservas';
		}
	});
}

function cancelBooking(id){
	remove("entity=booking&id="+id)
	.then(function(ans){
		var aux=ans.split(";");
		console.log(ans);
		if(aux[0]!=='null'){
			showAlert('alert-s',aux[1]);
			history.pushState(null,null,'?');
			location.reload();
		}else
			showAlert('alert-d',aux[1]);
	});
}

