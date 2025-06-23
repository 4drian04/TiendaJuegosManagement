<?php
require '../db/db.php';
require '../utils/utilities.php';

try{
    $fecha = Utilities::validateMandatoryParameter($_GET, 'fecha'); //Comprobamos los parámetros que deben de ser obligatorios en el sql (not null)
    $idCompra = Utilities::validateMandatoryParameter($_GET, 'idCompra');

    $database = new Database();
    $con = $database->getConnection(); //Creamos una instancia de database y obtenemos la conexion

    //Escribimos la sentencia para poder editar la fecha de la compra
    $sql = $con->prepare('UPDATE compra SET fecha=? WHERE idCompra=?');

    //Ponemos el tipo de dato de cada parámetro
    $sql->bind_param("si", $fecha, $idCompra);

    if($sql->execute()){ //Si la operación se ha hecho correctamente, le indicamos que la operación se ha hecho de manera exitosa
        $responseXML = Utilities::generateResponseXML('OK', 'Fecha cambiada con éxito.');

        header('Content-Type: application/xml');
        echo $responseXML->asXML();
    }else{ //En caso contrario, le indicamos que no se ha podido editar la fecha de la compra
        throw new Exception("Error al cambiar la fecha: " . $sql->error);
    }

    $sql->close();
}catch(Exception $e){
    $responseXML = Utilities::generateResponseXML('ERROR', $e->getMessage());

    header('Content-Type: application/xml');
    echo $responseXML->asXML();
}
?>