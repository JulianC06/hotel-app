<?php
    /**
    * Archivo que contiene un formulario con el fin de realizar el registro de un usuario
    * @package   usuarios.registrar
    * @author    Andrés Felipe Chaparro Rosas - Fabian Alejandro Cristancho Rincón
    * @copyright Todos los derechos reservados. 2020.
    * @since     Versión 1.0
    * @version   1.0
    */

    require_once '../../includes/classes.php';
    $user = new User();
    $userSession = new UserSession();
    
    if(isset($_SESSION['user'])){
        $user->updateDBUser($userSession->getSession());
        if($user->getRole()!=5)
            header('location: /login');
    }else{
        header('location: /login');
    }
?>


<!DOCTYPE html>
<html lang="es">
    <!--Importación de librerias css y javascript -->
    <head>
        <title>Registro de usuarios | Hotel Aristo</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="/res/img/famicon.png" />
        <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="/css/register.css">
        <link rel="stylesheet" type="text/css" href="/css/main.css"> 
        <link rel="stylesheet" type="text/css" href="/css/alerts.css">
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
            include "../../objects/menu.php"; 
        ?>
      
        <script type="text/javascript">
             /**
            * Implementa el método setCurrentPage() pasando como parámetro la cadena de texto "registrar"
            */
            setCurrentPage("registrar");
        </script>
    
        <!--Bloque encargado de contener el formulario correspondiente al registro de un nuevo usuario-->
        <div class="contenedor-formulario">
            <div class="wrap">
            <!-- Formulario -->
                <form action="" class="formulario" name="formulario_registro" method="post">  
                    <div>
                        <h2>REGISTRAR USUARIO</h2>
                        <div class="line-group">
                            <div class="input-group">
                                <input type="text" id="nombre" name="nombre">
                                <label class="label" for="nombre">Nombres</label>
                            </div>
                            <div class="input-group">
                                <input type="text" id="last-name" name="last-name">
                                <label class="label" for="last-name">Apellidos</label>
                            </div>
                        </div>

                        <div class="line-group">
                            <div class="input-group">
                                <label class="label_combo" for="type_id">Tipo de documento</label>
                                <select id="type_id" class="combo">
                                    <option value="RG">Registro Civil</option>
                                    <option value="TI">Tarjeta de identidad</option>
                                    <option value="CC">Cédula de Ciudadanía</option>
                                    <option value="CC">Cédula de Extranjería</option>
                                    <option value="CC">Pasaporte</option>
                                </select>
                            </div>

                            <div class="input-group">
                                <input type="text" id="document" name="document">
                                <label class="label" for="document">Número de Documento</label>
                            </div>
                        </div>

                        <div class="line-group">
                            <div class="input-group">
                                <input type="text" id="phone" name="phone">
                                <label class="label" for="phone">Teléfono</label>
                            </div>
                        
                            <div class="input-group">
                                <input type="email" id="email" name="email">
                                <label class="label" for="email">Correo electrónico</label>
                            </div>
                        </div>

                        <div class="line-group">
                            <div class="input-group">
                                <label class="label_combo" for="charge">Cargo</label>
                                <select id="charge" class="combo">
                                    <option value="DA">Director/a Administrativa</option>
                                    <option value="CD">Coordinadora</option>
                                    <option value="RC">Recepcionista</option>
                                    <option value="CM">Camarera</option>
                                </select>
                            </div>
                            <div class="input-group">
                                <input type="text" id="nickname" name="nickname" disabled>
                                <label class="label" for="nickname">Nombre de usuario</label>
                            </div>
                        </div>

                        <div class="line-group">
                            <div class="input-group">
                                <input type="password" id="pass" name="pass">
                                <label class="label" for="pass">Contraseña</label>
                            </div>
                            <div class="input-group">
                                <input type="password" id="pass2" name="pass2">
                                <label class="label" for="pass2">Repetir Contraseña</label>
                            </div>
                        </div>

                        <input type="submit" id="btn-submit" value="Registrar">
                    </div>
                </form>
            </div>
            <script src="/js/formulario.js"></script>
        </div>
        
            <?php
                /**
                * Incluye la implementación del archivo que contiene el footer con la información de la aplicación web
                */
                include "../../objects/footer.php"; 
            include "../../objects/alerts.php"; 
            ?>
        
        <script src="/js/formulario.js"></script>
    </body>
</html>
