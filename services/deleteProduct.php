<?php
require '../db/db.php';
require '../utils/utilities.php';

try{
    $idProducto = Utilities::validateMandatoryParameter($_GET, 'idProducto');//Comprobamos los parámetros que deben de ser obligatorios en el sql (not null)
    

    $database = new Database();
    $con = $database->getConnection(); //Creamos una instancia de database y obtenemos la conexion

    //Escribimos la sentencia para poder eliminar un prodcucto
    $sql = $con->prepare('DELETE FROM producto WHERE idProducto=?');

    //Ponemos el tipo de dato de cada parámetro
    $sql->bind_param("i", $idProducto);

    if($sql->execute()){ //Si la operación se ha hecho correctamente, le indicamos que la operación se ha hecho de manera exitosa
        $responseXML = Utilities::generateResponseXML('OK', 'Producto eliminado con éxito.');

        header('Content-Type: application/xml');
        echo $responseXML->asXML();
    }else{ //En caso contrario, le indicamos que no se ha podido eliminar el producto
        throw new Exception("Error al eliminar el producto: " . $sql->error);
    }

    $sql->close();
}catch(Exception $e){
    $responseXML = Utilities::generateResponseXML('ERROR', $e->getMessage());

    header('Content-Type: application/xml');
    echo $responseXML->asXML();
}
?>