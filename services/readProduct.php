<?php
require '../db/db.php';
require '../utils/utilities.php';

try{
    $database = new Database();
    $con = $database->getConnection();
    if(count($_GET)==0){
        $sql = $con->prepare("SELECT idProducto, prod.nombre, precio, plataforma, prov.nombre as nombreProveedor FROM producto prod join proveedor prov using(idProveedor)");
    }elseif(count($_GET)==1){
        $paramCorrectos = (strcmp(key($_GET), "nombre")==0)||(strcmp(key($_GET), "plataforma")==0);
        if($paramCorrectos){
            // Obtener parámetro de la solicitud GET
            $parametro = key($_GET); // Me devuelve el nombre del parámetro pasado.
            $valorParametro = $_GET[$parametro]; // Obtiene el valor del valor del parámetro.

            // Preparar la consulta en función del parámetro proporcionado
            $sql = $con->prepare("SELECT idProducto, prod.nombre as nombre, precio, plataforma, prov.nombre as nombreProveedor FROM producto prod join proveedor prov using(idProveedor) HAVING $parametro = ?");
            $sql->bind_param("s", $valorParametro);
        }else{
            throw new Exception("Solo puedes introducir como parámetro el nombre o la plataforma.");
        }
    }elseif(count($_GET)==2){
        if(!empty($_GET['nombre']) && !empty($_GET['plataforma'])){
            $nombre = $_GET['nombre']; // Obtiene el valor del parámetro 1.
            $plataforma = $_GET['plataforma']; // Obtiene el valor del parámetro 2.
    
            // Preparar la consulta en función del parámetro proporcionado
            $sql = $con->prepare("SELECT idProducto, prod.nombre as nombre, precio, plataforma, prov.nombre as nombreProveedor FROM producto prod join proveedor prov using(idProveedor) HAVING nombre = ? and plataforma = ?");
            $sql->bind_param("ss", $nombre, $plataforma);
    
        }else{
            throw new Exception("Solo puedes introducir el nombre y la plataforma.");
        }
    }else{
        throw new Exception("Solo puedes introducir el nombre y la plataforma.");
    }

    $sql->execute();
    $resultSet = $sql->get_result();

    //Empezamos a crear el XML correspondiente
    $responseXML = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><productos></productos>');

    if($resultSet->num_rows > 0){
        $responseXML->addChild('status', 'OK');
        while($row = $resultSet->fetch_assoc()){
            $productoXML = $responseXML->addChild('producto');
            $productoXML->addChild('idProducto', $row['idProducto']);
            $productoXML->addChild('nombre', $row['nombre']);
            $productoXML->addChild('precio', $row['precio']);
            $productoXML->addChild('plataforma', $row['plataforma']);
            $productoXML->addChild('proveedor', $row['nombreProveedor']);
        }
    }else{
        // No se encontraron productos
        $responseXML->addChild('status', 'ERROR');
        $responseXML->addChild('description', 'No se han encontrado productos.');
    }

    header('Content-Type: application/xml');
    echo $responseXML->asXML();

    $sql->close();

}catch(Exception $e){
    $responseXML = Utilities::generateResponseXML('ERROR', $e->getMessage());

    header('Content-Type: application/xml');
    echo $responseXML->asXML();
}
?>