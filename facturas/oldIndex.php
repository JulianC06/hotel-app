<?php
    /**
    * Archivo que contiene la información pertinente a la facturación
    * @package   facturas
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
        <title>Facturas | Hotel Aristo</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="/res/img/famicon.png" />
        <link rel="stylesheet" type="text/css" href="/css/main.css">
        <link rel="stylesheet" type="text/css" href="/css/alerts.css">
        <link rel="stylesheet" type="text/css" href="/css/table.css">
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
            * Implementa el método setCurrentPage() pasando como parámetro la cadena de texto "facturas"
            */
            setCurrentPage("facturas");
        </script>

        <!--Presenta una tabla con los datos básicos de una factura-->
        <div class="col-12 content">
            <div class="col-11 wrap-11 marco wrap-vertical padd">
                <div class="content-header">
                    <h2 class="title-form col-10">FACTURAS</h2>
                    <a class="button-add-book col-2" href="/facturas/registrar">Nueva factura</a>
                </div>
                <br>
                <div class="scroll-block">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>TITULAR</th>
                                <th>VALOR FACTURADO($)</th>
                                <th>FECHA DE FACTURACIÓN</th>
                                <th>RESPONSABLE</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                            <?php 
                                /**
                                * Invoca al método getTable('enterprise') que se encarga de obtener de la base de datos los datos de las empresas
                                */
                                $consult->getTable('bill', '')
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
        ?>
    </body>
</html>