<?php

require '../../includes/database.php';

switch ($_POST['action']) {
	case 'activateBooking':
		activateBooking();
		break;
	default;
		print_r($_POST);
		break;
}

function activateBooking(){
	$database= new Database();

	$update="UPDATE reservas SET estado_reserva = 'AC' WHERE id_reserva = ".$_POST['id'];

    $query=$database->connect()->prepare($update);

    try{
        $query->execute();
        echo $_POST['id'].';Se ha activado la reserva ('.$_POST['id'].')';;
    }catch(PDOException $e){
        echo 'null;Error U.1. Error al activar la reserva'.$update.$e->getMessage();
    }
}
?>