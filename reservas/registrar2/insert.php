<?php

require '../../includes/database.php';

switch ($_POST['entity']) {
	case 'holder':
		if($_POST['id']=="")
			insertHolder();
		else
			updateHolder();
		break;
	case 'person':
		if(!isset($_POST['id']))
			insertPerson();
		else
			updatePerson();
		break;
	case 'bizz':
		if($_POST['id']=="")
			insertBizz();
		else
			updateBizz();
		break;
	case 'booking':
		insertBooking();
		break;
	case 'room':
		if($_POST['id']=="")
			insertRoom();
		else
			updateRoom();
		break;
	case 'regPerson':
		insertRegRoom();
		break;
	default;
		print_r($_POST);
		break;
}

function insertHolder(){
	$database= new Database();

	$insert="INSERT INTO personas(nombres_persona, apellidos_persona, telefono_persona,correo_persona,tipo_persona) VALUES ('".$_POST['fname']."','".$_POST['lname']."','".$_POST['phone']."',".(isset($_POST['email'])?"'".$_POST['email']."'":"NULL").",'C')";

	$database->connect()->exec('ALTER TABLE personas AUTO_INCREMENT = 1');

	try{
		$pdo=$database->connect();
		$query=$pdo->exec($insert);
		$idPerson=$pdo->lastInsertId();
		echo $idPerson.';Se ha insertado a '.$_POST['fname'].' '.$_POST['lname'].'. ('.$idPerson.')';
	}catch(PDOException $e){
		echo 'null;Error C1.1. Error al ingresar nuevo cliente'.$insert."\n".$e->getMessage();
	}
	
	$database->connect()->exec('ALTER TABLE personas AUTO_INCREMENT = 1');
}

function insertPerson(){
	$database= new Database();

	if(!isset($_POST['d-type']))
		$insert="INSERT INTO personas(nombres_persona, apellidos_persona, telefono_persona,correo_persona,tipo_persona) VALUES ('".$_POST['fname']."','".$_POST['lname']."','".$_POST['phone']."',".(isset($_POST['email'])?"'".$_POST['email']."'":"NULL").",'C')";
	else
		$insert="INSERT INTO personas(nombres_persona, apellidos_persona, 
				telefono_persona,correo_persona,tipo_persona,
				id_lugar_nacimiento,id_lugar_expedicion,tipo_documento,numero_documento,
				genero_persona,fecha_nacimiento,tipo_sangre_rh) 
				VALUES ('".$_POST['fname']."','".$_POST['lname']."','"
				.$_POST['phone']."',".(isset($_POST['email'])?"'".$_POST['email']."'":"NULL").",'C',"
				.$_POST['nac'].",".$_POST['d-city'].",'".$_POST['d-type']."','".$_POST['d-number']."','"
				.$_POST['gender']."','".$_POST['bornDate']."','".str_replace("p", "+", $_POST['bloodRh'])."')";
	
	$database->connect()->exec('ALTER TABLE personas AUTO_INCREMENT = 1');

	try{
		$pdo=$database->connect();
		$query=$pdo->exec($insert);
		$idPerson=$pdo->lastInsertId();
		echo $idPerson.';Se ha insertado a '.$_POST['fname'].' '.$_POST['lname'].'. ('.$idPerson.')';
	}catch(PDOException $e){
		echo 'null;Error C1.2. Error al ingresar nuevo cliente'.$insert."\n".$e->getMessage();
	}
	
	$database->connect()->exec('ALTER TABLE personas AUTO_INCREMENT = 1');
}

function insertBizz(){
}

function insertBooking(){
	$database= new Database();

	$insert="INSERT INTO reservas (fecha_ingreso, fecha_salida,id_usuario";
	$values="'".$_POST['sdate']."','".$_POST['fdate']."',".$_POST["id-user"].",";
	
	if($_POST['type']=='P'){
		$insert=$insert.",id_titular";
	}else{
		$insert=$insert.",id_empresa";
	}
	$values=$values.$_POST['id'];

	$insert=$insert.")\n VALUES (".$values.");";

	$database->connect()->exec('ALTER TABLE reservas AUTO_INCREMENT = 1');

	try{
		$pdo=$database->connect();
		$query=$pdo->exec($insert);
		$id=$pdo->lastInsertId();
		echo $id.';Se ha insertado una nueva reserva. ('.$id.')';
	}catch(PDOException $e){
		echo 'null;Error C3.1. Error al ingresar nueva reserva'.$insert."\n".$e->getMessage();
	}
	
	$database->connect()->exec('ALTER TABLE reservas AUTO_INCREMENT = 1');
}

function insertRoom(){
	$database= new Database();

	if(isset($_POST['tariff-id']))
		$tariffId=$_POST['tariff-id'];
	else{
		$pQuery=$database->connect()->prepare("SELECT id_tarifa 
		FROM tarifas 
		WHERE valor_ocupacion=".(isset($_POST['tariff'])?$_POST['tariff']:"0"));

		$pQuery->execute();

		if($pQuery->rowCount()){
			$tariff=$pQuery->fetch();
	        $tariffId=$tariff['id_tarifa'];
	    }else{
	    	$database->connect()->exec('ALTER TABLE tarifas AUTO_INCREMENT = 1');
	        $pQuery=$database->connect()->prepare("SELECT id_tipo_habitacion FROM habitaciones WHERE id_habitacion=".$_POST['room-id']);
	        $pQuery->execute();
	        $roomType=$pQuery->fetch();
	        $pdo=$database->connect();
	        $pdo->exec("INSERT INTO tarifas (id_tipo_habitacion,valor_ocupacion,predeterminado)
	        		VALUES (".$roomType['id_tipo_habitacion'].",".$_POST['tariff'].",0)");
	        $tariffId=$pdo->lastInsertId();
	    }
	}


	$insert='INSERT INTO registros_habitacion(id_reserva, id_habitacion, id_tarifa, estado_registro';
	$values=$_POST['booking-id'].",".$_POST['room-id'].",".$tariffId.",'CI'";


	$insert=$insert.")\n VALUES (".$values.');';
	$database->connect()->exec('ALTER TABLE registros_habitacion AUTO_INCREMENT = 1');

	try{
		$pdo=$database->connect();
		$pdo->exec($insert);
		$idRoom=$pdo->lastInsertId();
		echo $idRoom.';Se ha asignado una habitacion a la reserva. ('.$idRoom.')';
	}catch(PDOException $e){
		echo 'null;Error C4.1. Error al ingresar nuevo registro'."\n".$insert.$e->getMessage();;
	}

	$database->connect()->exec('ALTER TABLE registros_habitacion AUTO_INCREMENT = 1');
}

function insertRegRoom(){
	$database= new Database();

	$insert="INSERT INTO registros_huesped(id_huesped,id_registro_habitacion) VALUES (".$_POST['id'].",".$_POST['regRoom'].")";

	$database->connect()->exec('ALTER TABLE registros_huesped AUTO_INCREMENT = 1');

	try{
		$pdo=$database->connect();
		$query=$pdo->exec($insert);
		$id=$pdo->lastInsertId();
		echo $id.';Se ha asignado a cliente en la habitacion. ('.$id.')';
	}catch(PDOException $e){
		echo 'null;Error C5.1. Error al asignar cliente'.$insert."\n".$e->getMessage();
	}
	
	$database->connect()->exec('ALTER TABLE registros_huesped AUTO_INCREMENT = 1');
}

function updateHolder(){
	$database= new Database();

	$update="UPDATE personas SET nombres_persona = '".$_POST['fname']."', apellidos_persona = '".$_POST['lname']."', telefono_persona = '".$_POST['phone']."', correo_persona = ".(isset($_POST['email'])?"'".$_POST['email']."'":"NULL")." WHERE id_persona = ".$_POST['id'];

    $query=$database->connect()->prepare($update);

    try{
        $query->execute();
        echo $_POST['id'].';Se ha modificado a '.$_POST['fname'].' '.$_POST['lname'].'. ('.$_POST['id'].')';;
    }catch(PDOException $e){
        echo 'null;Error U1.1. Error al actualizar al cliente'.$update.$e->getMessage();
    }
}

function updateBizz(){
	$database= new Database();

	$update="UPDATE empresas SET telefono_empresa = '".$_POST['phone']."' WHERE id_empresa = ".$_POST['id'];

    $query=$database->connect()->prepare($update);

    try{
        $query->execute();
        echo $_POST['id'].';Se ha modificado a ('.$_POST['id'].')';;
    }catch(PDOException $e){
        echo 'null;Error U2.1. Error al actualizar a la empresa'.$update.$e->getMessage();
    }
}

function updateRoom(){
	$database= new Database();

	if(isset($_POST['tariff-id']))
		$tariffId=$_POST['tariff-id'];
	else{
		$pQuery=$database->connect()->prepare("SELECT id_tarifa 
		FROM tarifas 
		WHERE valor_ocupacion=".(isset($_POST['tariff'])?$_POST['tariff']:"0"));

		$pQuery->execute();

		if($pQuery->rowCount()){
			$tariff=$pQuery->fetch();
	        $tariffId=$tariff['id_tarifa'];
	    }else{
	    	$database->connect()->exec('ALTER TABLE tarifas AUTO_INCREMENT = 1');
	        $pQuery=$database->connect()->prepare("SELECT id_tipo_habitacion FROM habitaciones WHERE id_habitacion=".$_POST['room-id']);
	        $pQuery->execute();
	        $roomType=$pQuery->fetch();
	        $pdo=$database->connect();
	        $pdo->exec("INSERT INTO tarifas (id_tipo_habitacion,valor_ocupacion,predeterminado)
	        		VALUES (".$roomType['id_tipo_habitacion'].",".$_POST['tariff'].",0)");
	        $tariffId=$pdo->lastInsertId();
	    }
	}

	$update='UPDATE registros_habitacion SET id_habitacion='.$_POST['room-id'].', id_tarifa='.$tariffId.' WHERE id_registro_habitacion ='.$_POST['id'];

    $query=$database->connect()->prepare($update);

    try{
        $query->execute();
        echo $_POST['id'].';Se ha modificado a ('.$_POST['id'].')';;
    }catch(PDOException $e){
        echo 'null;Error U4.1. Error al actualizar al registro'.$update.$e->getMessage();
    }
}

function updatePerson(){
	$database= new Database();

	if(!isset($_POST['d-type']))
		$update="UPDATE personas SET nombres_persona ='".$_POST['fname']."', apellidos_persona='".$_POST['lname']."', telefono_persona='".$_POST['phone']."'".(isset($_POST['email'])?",correo_persona='".$_POST['email']."'":"");
	else
		$update="UPDATE personas SET nombres_persona ='".$_POST['fname']."', apellidos_persona='".$_POST['lname']."', telefono_persona='".$_POST['phone']."',".(isset($_POST['email'])?"correo_persona='".$_POST['email']."'":"").", id_lugar_nacimiento=".$_POST['nac'].", id_lugar_expedicion=".$_POST['d-city'].", tipo_documento='".$_POST['d-type']."', numero_documento='".$_POST['d-number']."', genero_persona='".$_POST['gender']."', fecha_nacimiento='".$_POST['bornDate']."',tipo_sangre_rh='".str_replace("p", "+", $_POST['bloodRh'])."'";

    $update=$update." WHERE id_persona = ".$_POST['id'];

    $query=$database->connect()->prepare($update);

    try{
    	$query->execute();
    	echo $_POST['id'].';Se ha modificado al cliente satisfactoriamente';
    }catch(PDOException $e){
    	echo 'null;Error U5.2. Error al actualizar al cliente'.$update.$e->getMessage();
    }
}
?>