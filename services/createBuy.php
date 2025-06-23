<?php
require '../db/db.php';
require '../utils/utilities.php';

try{
    $fecha = Utilities::validateMandatoryParameter($_GET, 'fecha'); //Comprobamos los parámetros que deben de ser obligatorios en el sql (not null)
    $idCliente = isset($_GET['idCliente']) ? $_GET['idCliente'] : null; //Si no son obligatorios y no se han especificado, se marca como null

    $database = new Database();
    $con = $database->getConnection(); //Creamos una instancia de database y obtenemos la conexion

    //Escribimos la sentencia para poder insertar una compra
    $sql = $con->prepare('INSERT INTO compra (fecha, idCliente) VALUES(?,?)');

    //Ponemos el tipo de dato de cada parámetro
    $sql->bind_param("si", $fecha, $idCliente);

    if($sql->execute()){ //Si la operación se ha hecho correctamente, le indicamos que la operación se ha hecho de manera exitosa
        $idCompra = $con->insert_id; // Obtenemos el ID de la compra insertada
        $responseXML = Utilities::generateResponseXML('OK', 'Compra insertada con éxito');
        $responseXML->addChild('idCompra', $idCompra); // Añadimos el ID de la compra a la respuesta XML

        header('Content-Type: application/xml');
        echo $responseXML->asXML();
    }else{ //En caso contrario, le indicamos que no se ha podido insertar la compra
        throw new Exception("Error al insertar la compra: " . $sql->error);
    }

    $sql->close();
}catch(Exception $e){
    $responseXML = Utilities::generateResponseXML('ERROR', $e->getMessage());

    header('Content-Type: application/xml');
    echo $responseXML->asXML();
}
?>