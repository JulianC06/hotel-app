<?php
    /**
    * Archivo que contiene un formulario para el registro de una nueva reserva
    * @package   reservas.registrar
    * @author    Andrés Felipe Chaparro Rosas - Fabian Alejandro Cristancho Rincón
    * @copyright Todos los derechos reservados. 2020.
    * @since     Versión 1.0
    * @version   1.0
    */

    /**
    * Incluye la implementación de las clases requeridas para el buen funcionamiento de la aplicación
    */
	require_once '../../includes/classes.php';
    $consult=new Consult();
	$userSession = new UserSession();
    $user = new User();

    if(isset($_SESSION['user'])){
    	$user->updateDBUser($userSession->getSession());
    }else{
    	header('location: /login');
    }

    if(isset($_GET['type'])){
        if($_GET['type']=='B')
            $holder=new Enterprise();
        else
            $holder=new Person();
        $holder->setId($_GET['holder-id']);
    }

    if (isset($_GET['booking-id'])) {
        $booking= new Reservation();
        $booking->setId2($_GET['booking-id']);
        $holder=$booking->getTitular();
    }
?>

<!DOCTYPE html>
<html>
    <!--Importación de librerias css y javascript -->
	<head>
		<link rel="shortcut icon" href="/res/img/famicon.png" />
		<title>Nueva reserva | Hotel Aristo</title>
		<meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<link rel="stylesheet" type="text/css" href="/css/main.css">
		<link rel="stylesheet" type="text/css" href="/css/form.css">
		<link rel="stylesheet" type="text/css" href="/css/table.css">
		<link rel="stylesheet" type="text/css" href="/css/alerts.css">
		<link rel="stylesheet" type="text/css" href="/css/modal.css">
		<link rel="stylesheet" type="text/css" href="/css/font-awesome.min.css">
		<script type="text/javascript" src="/js/moment.js"></script>
		<script type="text/javascript" src="/js/jquery.js"></script>
		<script type="text/javascript" src="/js/jquerymask.js"></script>
		<script type="text/javascript" src="/js/dynamic.js"></script>
		<script type="text/javascript" src="booking-dynamic.js"></script>
		<script type="text/javascript" src="booking-db.js"></script>
	</head>

    <!--Construcción de la vista-->
	<body>

		<?php
            /**
            * Incluye la implementación de la clase menu, archivo que crea el menú superior de la aplicación web
            */
            include "../../objects/menu.php"; 
        ?>
        
        <script type="text/javascript">
            /**
            * Implementa el método setCurrentPage() pasando como parámetro la cadena de texto "registrar"
            */
            setCurrentPage("registrar");
        </script>

        <div class="content col-12 wrap-main">
        	<div class="row-simple">
                <div class="col-12 padd">
                    <h2>REGISTRAR RESERVA</h2>
                </div>
        		<div class="sub-menu col-12 padd">
                    <button id="back-btn" class="btn" style="float: left;" onclick="window.history.back();">Volver</button>

                    <div class="sub-menu-right">
                    	<?php if(isset($_GET['holder-id'])&&!isset($_GET['booking-id'])):?>
                        <button id="add-room" class="btn btn-yellow" onclick="targetLocation('/control_diario?');"><i class="fa fa-calendar"></i> Ver disponibilidad</button>
                        <?php endif;?>
                        <?php if(isset($_GET['booking-id'])):
                            if(isset($_GET['holder-stay'])):?>
                        <strong class="btn" style="color: red; cursor: auto;">No olvide que el titular se hospedará</strong>
                        <?php endif;?>
                        <button id="add-room" class="btn btn-green" onclick="addRoom();" <?php echo ($booking->getRoomsQuantity()==10?"disabled":"");?>><i class="fa fa-plus"></i> Agregar habitación</button>
                        <button id="finish-booking" class="btn btn-yellow" onclick="confirmBooking(<?php echo $_GET['booking-id']; ?>);" disabled><i class="fa fa-check"></i> Finalizar</button>
                        <?php endif;?>
                    </div>
                </div>

                <?php include 'booking-summary.php';?>

	        	<div class="col-9 padd">
	        		<?php 
	        		if(!isset($_GET['holder-id'])&&!isset($booking)):
	        			include 'booking-holder.php';
	        		elseif(!isset($_GET['booking-id'])):
	        			include 'booking-primeinfo.php';
	        		else:
                    ?>
                    <?php
	        			include 'booking-rooms.php';
	        		endif;
	        		?>
	        	</div>
        	</div>
        </div>

        <div id="room-modal" class="modal <?php if(isset($booking)){if($booking->getRegRooms()->rowCount()) echo 'hideable';}else echo 'hideable';?>" onclick="touchOutside(this);">
            <div class="modal-content col-10 wrap-10">
                <div class="modal-header">
                    <span onclick="hideModal(this.parentElement.parentElement.parentElement.id);" class="close">&times;</span>
                    <h2 id="room-modal-title">Configurar habitación</h2>
                </div>


                <?php 
                include 'booking-room-info.php';
                ?>

            </div>
        </div>

         <div id="client-modal" class="modal hideable" onclick="touchOutside(this);">
            <div class="modal-content col-10 wrap-10">
                <div class="modal-header">
                    <span onclick="hideModal(this.parentElement.parentElement.parentElement.id);" class="close">&times;</span>
                    <h2 id="room-modal-title">Configurar huesped</h2>
                </div>


                <?php 
                include 'booking-client-info.php'; 
                ?>

            </div>
        </div>

        <script type="text/javascript">
        	<?php if(isset($booking)): ?>
            document.getElementById('finish-booking').disabled=document.getElementsByClassName('btn-config-client').length!=0;
            <?php endif; ?>
            function nextStep(){
                var personIndex=document.getElementById('person-index');
                var roomQuantity=document.getElementById("room-quantity");
                var cis=document.getElementById('check-in-state');
                cis.checked=false;
                cis.onchange.call(cis);
                
                if(personIndex.innerHTML==""){
                    personIndex.innerHTML="1";
                    document.getElementById('room-values').classList.add('hideable');
                    document.getElementById('person-values').classList.remove('hideable');
                }else if(parseInt(personIndex.innerHTML)==parseInt(roomQuantity.item(roomQuantity.selectedIndex).innerHTML.charAt(0))){
                    hideModal('room-modal');
                    personIndex.innerHTML="";
                    var btn=document.getElementsByClassName('card-room')[parseInt(document.getElementById('room').innerHTML)].getElementsByClassName('btn-card-room')[0];
                    btn.innerHTML='Listo';
                    btn.classList.remove('btn-register');
                    btn.classList.add('btn-green');
                }else{
                    personIndex.innerHTML=(parseInt(personIndex.innerHTML)+1);
                    
                    if(parseInt(personIndex.innerHTML)==parseInt(roomQuantity.item(roomQuantity.selectedIndex).innerHTML.charAt(0)))
                        document.getElementById('person-next-button').innerHTML="Finalizar";
                }

                document.getElementById('room-modal-title').innerHTML="Asignar huesped ("+personIndex.innerHTML+" de "+roomQuantity.item(roomQuantity.selectedIndex).innerHTML.charAt(0)+")";
            }

            function previousStep(){
                var personIndex=document.getElementById('person-index');
                var roomQuantity=document.getElementById("room-quantity");

                if(document.getElementById('person-index').innerHTML=="1"){
                    personIndex.innerHTML="";
                    document.getElementById('room-values').classList.remove('hideable');
                    document.getElementById('person-values').classList.add('hideable');
                    document.getElementById('room-modal-title').innerHTML="Configurar habitación";
                }else{
                    if(parseInt(personIndex.innerHTML)==parseInt(roomQuantity.item(roomQuantity.selectedIndex).innerHTML.charAt(0)))
                        document.getElementById('person-next-button').innerHTML="Continuar";
                    personIndex.innerHTML=(parseInt(personIndex.innerHTML)-1);
                    document.getElementById('room-modal-title').innerHTML="Asignar huesped ("+personIndex.innerHTML+" de "+roomQuantity.item(roomQuantity.selectedIndex).innerHTML.charAt(0)+")";
                }
            }

            function getURLValues(){
                var str='<?php foreach ($_GET as $key => $value) {echo $key.'='.$value.';';}?>';
                str=str.substring(0,str.length-1);
                str=str.split(';');
                var arr=[];
                
                for (var i = 0; i < str.length; i++) {
                    var aux=str[i].split('=');
                    arr[aux[0]]=aux[1]+"";    
                }

                return arr;
            }

           
        </script>

        <?php
            /**
            * Incluye la implementación del archivo que contiene el footer con la información de la aplicación web
            */
            include "../../objects/footer.php";
            include "../../objects/alerts.php"; 
        ?>
	</body>
</html>