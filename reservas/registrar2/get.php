<?php
    include '../../includes/classes.php';
    $consult=new Consult();

    switch($_POST['action']){
        case 'bizz':
            $consult->getEnterprise($_POST['id']);
            break;
        case 'regRoom':
        	$consult->getRegRoom($_POST['id']);
        	break;
        default:
        print_r($_POST);
        	break;
    }
?>