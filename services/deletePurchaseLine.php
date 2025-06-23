<?php
require '../db/db.php';
require '../utils/utilities.php';

try{
    $usuario = Utilities::validateMandatoryParameter($_GET, 'idCompra');//Comprobamos los parámetros que deben de ser obligatorios en el sql (not null)
    $nombreProducto = Utilities::validateMandatoryParameter($_GET, 'idProducto'); 
    

    $database = new Database();
    $con = $database->getConnection(); //Creamos una instancia de database y obtenemos la conexion

    //Escribimos la sentencia para poder eliminar una linea de compra
    $sql = $con->prepare('DELETE FROM linea_compra WHERE idCompra=? AND idProducto=?');

    //Ponemos el tipo de dato de cada parámetro
    $sql->bind_param("ii", $idCompra, $idProducto);

    if($sql->execute()){ //Si la operación se ha hecho correctamente, le indicamos que la operación se ha hecho de manera exitosa
        $filasAfectadas = $sql->affected_rows;
        if($filasAfectadas <= 0){
            throw new Exception("Esta compra no tiene el producto a eliminar.");
        }
        $responseXML = Utilities::generateResponseXML('OK', 'Linea de compra eliminada con éxito.');

        header('Content-Type: application/xml');
        echo $responseXML->asXML();
    }else{ //En caso contrario, le indicamos que no se ha podido eliminar el cliente
        throw new Exception("Error al eliminar la línea de compra: " . $sql->error);
    }

    $sql->close();
}catch(Exception $e){
    $responseXML = Utilities::generateResponseXML('ERROR', $e->getMessage());

    header('Content-Type: application/xml');
    echo $responseXML->asXML();
}
?>