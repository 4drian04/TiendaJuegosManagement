<?php
require '../db/db.php';
require '../utils/utilities.php';

try{
    $idCompra = Utilities::validateMandatoryParameter($_GET, 'idCompra');//Comprobamos los parámetros que deben de ser obligatorios en el sql (not null)
    

    $database = new Database();
    $con = $database->getConnection(); //Creamos una instancia de database y obtenemos la conexion

    //Escribimos la sentencia para poder eliminar una compra.
    $sql = $con->prepare('DELETE FROM compra WHERE idCompra=?');

    //Ponemos el tipo de dato de cada parámetro
    $sql->bind_param("i", $idCompra);

    if($sql->execute()){ //Si la operación se ha hecho correctamente, le indicamos que la operación se ha hecho de manera exitosa
        $responseXML = Utilities::generateResponseXML('OK', 'Compra eliminada con éxito.');

        header('Content-Type: application/xml');
        echo $responseXML->asXML();
    }else{ //En caso contrario, le indicamos que no se ha podido eliminar la compra
        throw new Exception("Error al eliminar la compra: " . $sql->error);
    }

    $sql->close();
}catch(Exception $e){
    $responseXML = Utilities::generateResponseXML('ERROR', $e->getMessage());

    header('Content-Type: application/xml');
    echo $responseXML->asXML();
}
?>