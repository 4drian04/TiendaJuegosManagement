<?php
require '../db/db.php';
require '../utils/utilities.php';

try{
    $telefono = Utilities::validateMandatoryParameter($_GET, 'telefono'); //Comprobamos los parámetros que deben de ser obligatorios en el sql (not null)
    $nombre = Utilities::validateMandatoryParameter($_GET, 'nombre');

    $database = new Database();
    $con = $database->getConnection(); //Creamos una instancia de database y obtenemos la conexion

    //Escribimos la sentencia para poder editar el precio
    $sql = $con->prepare('UPDATE proveedor SET telefono=? WHERE nombre=?');

    //Ponemos el tipo de dato de cada parámetro
    $sql->bind_param("ss", $telefono, $nombre);

    if($sql->execute()){ //Si la operación se ha hecho correctamente, le indicamos que la operación se ha hecho de manera exitosa
        $responseXML = Utilities::generateResponseXML('OK', 'Teléfono cambiado con éxito.');

        header('Content-Type: application/xml');
        echo $responseXML->asXML();
    }else{ //En caso contrario, le indicamos que no se ha podido editar el telefono
        throw new Exception("Error al cambiar el teléfono: " . $sql->error);
    }

    $sql->close();
}catch(Exception $e){
    $responseXML = Utilities::generateResponseXML('ERROR', $e->getMessage());

    header('Content-Type: application/xml');
    echo $responseXML->asXML();
}
?>