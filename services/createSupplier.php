<?php
require '../db/db.php';
require '../utils/utilities.php';

try{
    $nombre = Utilities::validateMandatoryParameter($_GET, 'nombre'); //Comprobamos los parámetros que deben de ser obligatorios en el sql (not null)
    $telefono = isset($_GET['telefono']) ? $_GET['telefono'] : null; //Si no son obligatorios y no se han especificado, se marca como null

    $database = new Database();
    $con = $database->getConnection(); //Creamos una instancia de database y obtenemos la conexion

    //Escribimos la sentencia para poder insertar un proveedor
    $sql = $con->prepare('INSERT INTO proveedor (nombre, telefono) VALUES(?, ?)');

    //Ponemos el tipo de dato de cada parámetro
    $sql->bind_param("ss", $nombre, $telefono);

    if($sql->execute()){ //Si la operación se ha hecho correctamente, le indicamos que la operación se ha hecho de manera exitosa
        $responseXML = Utilities::generateResponseXML('OK', 'Proveedor insertado con éxito');

        header('Content-Type: application/xml');
        echo $responseXML->asXML();
    }else{ //En caso contrario, le indicamos que no se ha podido insertar el proveedor
        throw new Exception("Error al insertar el proveedor: " . $sql->error);
    }

    $sql->close();
}catch(Exception $e){
    $responseXML = Utilities::generateResponseXML('ERROR', $e->getMessage());

    header('Content-Type: application/xml');
    echo $responseXML->asXML();
}
?>