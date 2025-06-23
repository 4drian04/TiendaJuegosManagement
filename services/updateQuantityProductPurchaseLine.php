<?php
require '../db/db.php';
require '../utils/utilities.php';

try{
    $cantidad = Utilities::validateMandatoryParameter($_GET, 'cantidad'); //Comprobamos los parámetros que deben de ser obligatorios en el sql (not null)
    $idProducto = Utilities::validateMandatoryParameter($_GET, 'idProducto');
    $idCompra = Utilities::validateMandatoryParameter($_GET, 'idCompra');

    $database = new Database();
    $con = $database->getConnection(); //Creamos una instancia de database y obtenemos la conexion

    //Escribimos la sentencia para poder editar el precio
    $sql = $con->prepare('UPDATE linea_compra SET cantidad=? WHERE idCompra=? and idProducto=?');

    //Ponemos el tipo de dato de cada parámetro
    $sql->bind_param("iii", $cantidad, $idCompra, $idProducto);

    if($sql->execute()){ //Si la operación se ha hecho correctamente, le indicamos que la operación se ha hecho de manera exitosa
        $responseXML = Utilities::generateResponseXML('OK', 'Cantidad del producto cambiado con éxito.');

        header('Content-Type: application/xml');
        echo $responseXML->asXML();
    }else{ //En caso contrario, le indicamos que no se ha podido editar la cantidad del producto
        throw new Exception("Error al cambiar el producto: " . $sql->error);
    }

    $sql->close();
}catch(Exception $e){
    $responseXML = Utilities::generateResponseXML('ERROR', $e->getMessage());

    header('Content-Type: application/xml');
    echo $responseXML->asXML();
}
?>