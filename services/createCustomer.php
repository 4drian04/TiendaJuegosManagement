<?php
require '../db/db.php';
require '../utils/utilities.php';

try{
    $nombre = Utilities::validateMandatoryParameter($_GET, 'nombre'); //Comprobamos los parámetros que deben de ser obligatorios en el sql (not null)
    $primerApellido = isset($_GET['apellido1']) ? $_GET['apellido1'] : null; //Si no son obligatorios y no se han especificado, se marca como null
    $segundoApellido = isset($_GET['apellido2']) ? $_GET['apellido2'] : null;
    $usuario = Utilities::validateMandatoryParameter($_GET, 'usuario');
    $contrasenha = Utilities::validateMandatoryParameter($_GET, 'contrasenha');
    $edad = isset($_GET['edad']) ? $_GET['edad'] : null;

    $database = new Database();
    $con = $database->getConnection(); //Creamos una instancia de database y obtenemos la conexion

    //Escribimos la sentencia para poder insertar un cliente
    $sql = $con->prepare('INSERT INTO cliente (nombre, apellido1, apellido2, usuario, contrasenha, edad) VALUES (?, ?, ?, ?, ?, ?)');

    //Ponemos el tipo de dato de cada parámetro
    $sql->bind_param("sssssi", $nombre, $primerApellido, $segundoApellido, $usuario, $contrasenha, $edad);

    if($sql->execute()){ //Si la operación se ha hecho correctamente, le indicamos que la operación se ha hecho de manera exitosa
        $responseXML = Utilities::generateResponseXML('OK', 'Cliente insertado con éxito.');

        header('Content-Type: application/xml');
        echo $responseXML->asXML();
    }else{ //En caso contrario, le indicamos que no se ha podido insertar el cliente
        throw new Exception("Error al insertar el cliente: " . $sql->error);
    }

    $sql->close();
}catch(Exception $e){
    $responseXML = Utilities::generateResponseXML('ERROR', $e->getMessage());

    header('Content-Type: application/xml');
    echo $responseXML->asXML();
}
?>