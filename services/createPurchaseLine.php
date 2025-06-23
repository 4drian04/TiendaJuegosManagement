<?php
require '../db/db.php';
require '../utils/utilities.php';

try{
    $idCompra = Utilities::validateMandatoryParameter($_GET, 'idCompra'); //Comprobamos los parámetros que deben de ser obligatorios en el sql (not null)
    $idProducto = Utilities::validateMandatoryParameter($_GET, 'idProducto');
    $cantidad = Utilities::validateMandatoryParameter($_GET, 'cantidad');

    $database = new Database();
    $con = $database->getConnection(); //Creamos una instancia de database y obtenemos la conexion

    //Escribimos la sentencia para poder insertar una linea de compra
    $sql = $con->prepare('INSERT INTO linea_compra (idCompra, idProducto, cantidad) VALUES(?,?,?)');

    //Ponemos el tipo de dato de cada parámetro
    $sql->bind_param("iii", $idCompra, $idProducto, $cantidad);

    if($sql->execute()){ //Si la operación se ha hecho correctamente, le indicamos que la operación se ha hecho de manera exitosa
        $responseXML = Utilities::generateResponseXML('OK', 'Linea de compra insertada con éxito.');

        header('Content-Type: application/xml');
        echo $responseXML->asXML();
    }else{ //En caso contrario, le indicamos que no se ha podido insertar la linea de compra
        throw new Exception("Error al insertar la linea de compra: " . $sql->error);
    }

    $sql->close();
}catch(Exception $e){
    $responseXML = Utilities::generateResponseXML('ERROR', $e->getMessage());

    header('Content-Type: application/xml');
    echo $responseXML->asXML();
}
?>