<?php
require '../db/db.php';
require '../utils/utilities.php';

try{
    $contrasenhaNueva = Utilities::validateMandatoryParameter($_GET, 'contrasenhaNueva');
    $contrasenhaAntigua = Utilities::validateMandatoryParameter($_GET, 'contrasenhaAntigua'); //Comprobamos los parámetros que deben de ser obligatorios en el sql (not null)
    $usuario = Utilities::validateMandatoryParameter($_GET, 'usuario');

    $database = new Database();
    $con = $database->getConnection(); //Creamos una instancia de database y obtenemos la conexion

    //Escribimos la sentencia para poder editar la contraseña
    $sql = $con->prepare('UPDATE cliente SET contrasenha=? WHERE usuario=? AND contrasenha=?');

    //Ponemos el tipo de dato de cada parámetro
    $sql->bind_param("sss", $contrasenhaNueva, $usuario, $contrasenhaAntigua);

    if($sql->execute()){ //Si la operación se ha hecho correctamente, le indicamos que la operación se ha hecho de manera exitosa
        $responseXML = Utilities::generateResponseXML('OK', 'Contraseña cambiada con éxito.');

        header('Content-Type: application/xml');
        echo $responseXML->asXML();
    }else{ //En caso contrario, le indicamos que no se ha podido editar la contraseña
        throw new Exception("Error al cambiar la contraseña: " . $sql->error);
    }

    $sql->close();
}catch(Exception $e){
    $responseXML = Utilities::generateResponseXML('ERROR', $e->getMessage());

    header('Content-Type: application/xml');
    echo $responseXML->asXML();
}
?>