function toggleStayLabel(input){
	if(input.checked)
		document.getElementById('holder-stay-label').innerHTML="El titular se hospedará.";
	else
		document.getElementById('holder-stay-label').innerHTML="El titular no se hospedará.";
}

function toggleHolder(button){
	var bs= document.getElementById('select-holder').getElementsByTagName('button');
	var search= document.getElementById('search-holder');
	search.hidden=false;
	var searchInput=search.getElementsByTagName('input')[0];
	var personBody=document.getElementById('person-holder');
	var bizzBody=document.getElementById('bizz-holder');
	var personInputs=personBody.getElementsByTagName('input');
	var bizzSelect=bizzBody.getElementsByTagName('select')[0];

	if(bs[0]==button){
		bs[0].classList.add('btn-header-selected');
		bs[1].classList.remove('btn-header-selected');
		search.getElementsByTagName('label')[0].innerHTML="Busqueda por número de documento";
		search.getElementsByTagName('small')[0].innerHTML="ej. 102055214";
		searchInput.placeholder="Documento";
		searchInput.onkeydown= function(){$(this).mask('000000000000');};
		search.getElementsByTagName('button')[0].onclick=function(){searchHolder(searchInput);};
		personBody.hidden=false;
		bizzBody.hidden=true;
		personInputs[0].required=personInputs[1].required=personInputs[2].required=true;
		bizzSelect.required=false;
	}else{
		bs[0].classList.remove('btn-header-selected');
		bs[1].classList.add('btn-header-selected');
		search.getElementsByTagName('label')[0].innerHTML="Busqueda por NIT";
		search.getElementsByTagName('small')[0].innerHTML="ej. 74685445-4";
		searchInput.placeholder="NIT";
		searchInput.onkeydown= function(){$(searchInput).mask('0000000000000000000-0', {reverse: true});};
		search.getElementsByTagName('button')[0].onclick=function(){searchBizz(searchInput);};
		personBody.hidden=true;
		bizzBody.hidden=false;
		personInputs[0].required=personInputs[1].required=personInputs[2].required=false;
		bizzSelect.required=true;
	}

	searchInput.value="";
}

function setIdRoom(id,roomId){
	document.getElementById('room').innerHTML=id;

	if(roomId!==undefined){
		document.getElementById('room-id').value=roomId;
		searchRegRoom(roomId);
	}
	
}

function setIdClient(roomId){
	document.getElementById('room-id').value=roomId;
}

function addRoom(){
	var arr = getURLValues();
	arr['rooms']=parseInt(arr['rooms'])+1;
	location.href=setValuesToURL("/reservas/registrar2",arr);
}

function removeRoom(room, index){
	var idValue=document.getElementById('room-'+index);
	var p= new Promise(function(resolve){
		resolve();
	});

	if(idValue!=null){
		p=removeRoomOfDB(idValue.value);
	}		

	p.then(function(ans){
		

		if(ans!==undefined){
			var aux=ans.split(";");
			console.log(aux[1]);
		}

		var arr = getURLValues();
		arr['rooms']=parseInt(arr['rooms'])-1;
		location.href=setValuesToURL("/reservas/registrar2",arr);
	});
}


function showCustomTariff(input){
	var formGroup=document.getElementById('custom-tariff');
	
	if(input.value=="O"){
		formGroup.style.display="block";
		formGroup.getElementsByTagName("input")[0].required=true;
	}else{
		formGroup.style.display="none";
		formGroup.getElementsByTagName("input")[0].required=false;
	}
}

function showAllInputs(input){
	var rows=document.getElementById("person-card-body").getElementsByClassName("row");

	if(!input.checked){
		setRequired(rows[1],false);
		setRequired(rows[2],false);
		setRequired(rows[4],false);
		rows[1].style.display="none";
		rows[2].style.display="none";
		rows[4].style.display="none";
		rows[5].getElementsByClassName("form-group")[0].style.display="none";
		rows[5].getElementsByClassName("form-group")[1].style.display="none";
	}else{
		setRequired(rows[1],true);
		setRequired(rows[2],true);
		setRequired(rows[4],true);
		rows[1].style.display="flex";
		rows[2].style.display="flex";
		rows[4].style.display="flex";
		rows[5].getElementsByClassName("form-group")[0].style.display="initial";
		rows[5].getElementsByClassName("form-group")[1].style.display="initial";
	}
}


function setRequired(row, bool){
	var inputs=row.getElementsByTagName("input");
	var selects=row.getElementsByTagName("select");
	if(bool){
		for (var i = 0; i < inputs.length; i++) {
			inputs[i].setAttribute("required","");
		}

		for (var i = 0; i < selects.length; i++) {
			selects[i].setAttribute("required","");
		}
	}else{
		for (var i = 0; i < inputs.length; i++) {
			inputs[i].removeAttribute("required");
		}

		for (var i = 0; i < selects.length; i++) {
			selects[i].removeAttribute("required");
		}
	}
}

function setValuesToURL(loc,values){
	var ret="?";

	for (var i = 0; i < Object.keys(values).length; i++) {
		ret+=Object.keys(values)[i]+'='+values[Object.keys(values)[i]]+"&";
	}
	
	return loc+ret.substring(0,ret.length-1);
}

function arrayRemove(arr, value) { 
	return arr.filter(function(ele){ return ele != value; });
}