<?php
    /**
    * Archivo que contiene la información pertinente a las empresas almacenadas en la base de datos
    * @package   empresas
    * @author    Andrés Felipe Chaparro Rosas - Fabian Alejandro Cristancho Rincón
    * @copyright Todos los derechos reservados. 2020.
    * @since     Versión 1.0
    * @version   1.0
    */

    /**
    * Incluye la implementación de las clases requeridas para el buen funcionamiento de la aplicación
    */
    require_once '../includes/classes.php';
    $consult=new Consult();
    $user = new User();
    $userSession = new UserSession();
    
    if(isset($_SESSION['user'])){
        $user->updateDBUser($userSession->getSession());
    }else{
        header('location: /login');
    }
?>

<!DOCTYPE html>
<html>
    <!--Importación de librerias css y javascript -->
    <head>
        <title>Empresas registradas | Hotel Aristo</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="/res/img/famicon.png">
        <link rel="stylesheet" type="text/css" href="/css/main.css">
        <link rel="stylesheet" type="text/css" href="/css/alerts.css">
        <link rel="stylesheet" type="text/css" href="/css/table.css">
        <link rel="stylesheet" type="text/css" href="/css/form.css">
        <link rel="stylesheet" type="text/css" href="/css/font-awesome.min.css">
        <script type="text/javascript" src="/js/moment.js"></script>
        <script type="text/javascript" src="/js/dynamic.js"></script>
        <script type="text/javascript" src="/js/jquery.js"></script>
    </head>
    
    <!--Construcción de la vista-->
    <body>
        <?php
            /**
            * Incluye la implementación de la clase menu, archivo que crea el menú superior de la aplicación web
            */
            include "../objects/menu.php"; 
        ?>
        
        <script type="text/javascript">
            /**
            * Implementa el método setCurrentPage() pasando como parámetro la cadena de texto "consultar"
            */
            setCurrentPage("consultar");
        </script>

        <!--Bloque cuyo contenido se basa en una tabla que presenta la información más relevante de las empresas registradas en la base de datos-->

        <div class="col-12 content">
            <div class="col-11 wrap-11 marco wrap-vertical padd">
                <div class="content-header col-12">
                    <div class="row-simple col-12">
                        <h2 class="title-form col-9">EMPRESAS REGISTRADAS</h2>
                        <a class="button-add-book col-3" href="registrar">Registrar empresa</a> 
                    </div>
                </div>
                
                <div class="scroll-block col-12">
                    <table>
                        <thead>
                            <tr>
                                <th>NIT</th>
                                <th>NOMBRE</th>
                                <th>TELEFONO</th>
                                <th>RETEFUENTE <br/>(3,5 %)</br></th>
                                <th>ICA</br></th>
                            </tr>
                        </thead>
                        <?php
                            /**
                            * Invoca al método getTable('enterprise') que se encarga de obtener de la base de datos los datos de las empresas
                            */
                            $consult->getTable('enterprise', '');
                        ?>
                    </table>
                </div>
            </div>
        </div>
        
        <?php
            /**
            * Incluye la implementación del archivo que contiene el footer con la información de la aplicación web
            */
            include "../objects/footer.php"; 
            include "../objects/alerts.php"; 
        ?>
    </body>
</html>