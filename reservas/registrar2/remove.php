<?php 
require '../../includes/database.php';

switch ($_POST['entity']) {
	case 'regRoom':
		removeRegRoom($_POST['id']);
		break;
    case 'booking':
        removeBooking();
        break;
	default:
		print_r($_POST);
		break;
}

function removeRegRoom($id){
	$database=new Database();

	$database->connect()->exec("DELETE FROM registros_huesped WHERE id_registro_habitacion =".$id);

    $query=$database->connect()->prepare("DELETE FROM registros_habitacion WHERE id_registro_habitacion=".$id);

    try{
        $query->execute();
        echo $id.';Se ha eliminado la habitacion.';
    }catch(PDOException $e){
        echo 'null;Error D1.1. Error al eliminar la habitacion'.$e->getMessage();
    }
}

function removeBooking(){
    $database=new Database();

    $queryRH=$database->connect()->prepare("SELECT id_registro_habitacion FROM registros_habitacion WHERE id_reserva=".$_POST["id"]);
    $queryRH->execute();

    foreach ($queryRH as $current) {
    	removeRegRoom($current['id_registro_habitacion']);
    }

    $query=$database->connect()->prepare("DELETE FROM reservas WHERE id_reserva=".$_POST['id']);

    try{
    	$query->execute();
        echo $_POST["id"].';Se ha eliminado la reserva.';
    }catch(PDOException $e){
    	echo 'null;Error D3.1. Error al eliminar la reserva'.$e->getMessage();
    }
}
?>