<?php
require '../db/db.php';
require '../utils/utilities.php';

try{
    $database = new Database();
    $con = $database->getConnection();
    if(count($_GET)==0){

        $sql = $con->prepare("SELECT idCompra, idProducto, c2.nombre as nombreCliente, apellido1, apellido2, fecha, p.nombre as nombreProducto, precio, cantidad FROM linea_compra INNER JOIN compra c using(idCompra) inner join producto p using(idProducto) inner join cliente c2 on c.idCliente = c2.idCliente");
    }elseif(count($_GET)==1){
        $paramCorrectos = ((strcmp(key($_GET), "nombreProducto")==0) || (strcmp(key($_GET), "nombreCliente")==0) || (strcmp(key($_GET), "apellido1")==0) || (strcmp(key($_GET), "apellido2")==0) || (strcmp(key($_GET), "fecha")==0) || (strcmp(key($_GET), "idCompra")==0));
        if($paramCorrectos){
            $parametro = key($_GET); // Me devuelve el nombre del parámetro pasado.
            $valorParametro = $_GET[$parametro]; // Obtiene el valor del valor del parámetro.

            // Preparar la consulta en función del parámetro proporcionado
            $sql = $con->prepare("SELECT idCompra, idProducto, c2.nombre as nombreCliente, apellido1, apellido2, fecha, p.nombre as nombreProducto, precio, cantidad FROM linea_compra INNER JOIN compra c using(idCompra) inner join producto p using(idProducto) inner join cliente c2 on c.idCliente = c2.idCliente HAVING $parametro = ?");
            $valorBindeo=$parametro=="idCompra"?"i":"s";
            $sql->bind_param($valorBindeo, $valorParametro);
        }else{
            throw new Exception("Solo puedes introducir como parámetro el nombre del cliente, los apellidos, la fecha, o el nombre del producto.");
        }
    }elseif(count($_GET)==2){
        $parametros=array();
        if(!empty($_GET['nombreProducto'])){
            $parametros[]="nombreProducto";
        }
        if(!empty($_GET['fecha'])){
            $parametros[]="fecha";
        }
        if(!empty($_GET['nombreCliente'])){
            $parametros[]="nombreCliente";
        }
        if(!empty($_GET['apellido1'])){
            $parametros[]="apellido1";
        }
        if(!empty($_GET['apellido2'])){
            $parametros[]="apellido2";
        }
        if(!empty($_GET['apellido1'])){
            $parametros[]="apellido1";
        }
        if(count($parametros)==2){
            $param1 = $_GET[$parametros[0]]; // Obtiene el valor del valor del parámetro 1.
            $param2 = $_GET[$parametros[1]]; // Obtiene el valor del valor del parámetro 2.
            // Preparar la consulta en función del parámetro proporcionado
            $sql = $con->prepare("SELECT idProducto, c2.nombre as nombreCliente, apellido1, apellido2, fecha, p.nombre as nombreProducto, precio, cantidad FROM linea_compra INNER JOIN compra c using(idCompra) inner join producto p using(idProducto) inner join cliente c2 on c.idCliente = c2.idCliente HAVING $parametros[0]  = ? and $parametros[1] = ?");
            $sql->bind_param("ss", $param1, $param2);
        }else{
            throw new Exception("Solo puedes introducir como parámetro el nombre del cliente, los apellidos, la fecha, o el nombre del producto.");
        }
        // Obtener parámetro de la solicitud GET
    }elseif(count($_GET)==3){
        $parametros=array();
        if(!empty($_GET['nombreProducto'])){
            $parametros[]="nombreProducto";
        }
        if(!empty($_GET['fecha'])){
            $parametros[]="fecha";
        }
        if(!empty($_GET['nombreCliente'])){
            $parametros[]="nombreCliente";
        }
        if(!empty($_GET['apellido1'])){
            $parametros[]="apellido1";
        }
        if(!empty($_GET['apellido2'])){
            $parametros[]="apellido2";
        }
        if(!empty($_GET['apellido1'])){
            $parametros[]="apellido1";
        }
        if(count($parametros)==3){
            $param1 = $_GET[$parametros[0]]; // Obtiene el valor del valor del parámetro 1.
            $param2 = $_GET[$parametros[1]]; // Obtiene el valor del valor del parámetro 2.
            $param3 = $_GET[$parametros[2]]; //Obtiene el valor del parámetro 3
            // Preparar la consulta en función del parámetro proporcionado
            $sql = $con->prepare("SELECT idProducto, c2.nombre as nombreCliente, apellido1, apellido2, fecha, p.nombre as nombreProducto, precio, cantidad FROM linea_compra INNER JOIN compra c using(idCompra) inner join producto p using(idProducto) inner join cliente c2 on c.idCliente = c2.idCliente HAVING $parametros[0]  = ? and $parametros[1] = ? and $parametros[2] = ?");
            $sql->bind_param("sss", $param1, $param2, $param3);
        }else{
            throw new Exception("Solo puedes introducir como parámetro el nombre del cliente, los apellidos, la fecha, o el nombre del producto.");
        }
    }elseif(count($_GET)==4){
        $parametros=array();
        if(!empty($_GET['nombreProducto'])){
            $parametros[]="nombreProducto";
        }
        if(!empty($_GET['fecha'])){
            $parametros[]="fecha";
        }
        if(!empty($_GET['nombreCliente'])){
            $parametros[]="nombreCliente";
        }
        if(!empty($_GET['apellido1'])){
            $parametros[]="apellido1";
        }
        if(!empty($_GET['apellido2'])){
            $parametros[]="apellido2";
        }
        if(!empty($_GET['apellido1'])){
            $parametros[]="apellido1";
        }
        if(count($parametros)==4){
            // Obtener parámetro de la solicitud GET
            $param1 = $_GET[$parametros[0]]; // Obtiene el valor del valor del parámetro 1.
            $param2 = $_GET[$parametros[1]]; // Obtiene el valor del valor del parámetro 2.
            $param3 = $_GET[$parametros[2]]; //Obtiene el valor del parámetro 3
            $param4 = $_GET[$parametros[3]]; //Obtiene el valor del parámetro 4

            // Preparar la consulta en función del parámetro proporcionado
            $sql = $con->prepare("SELECT idProducto, c2.nombre as nombre, apellido1, apellido2, fecha, p.nombre as nombreProducto, precio, cantidad FROM linea_compra INNER JOIN compra c using(idCompra) inner join producto p using(idProducto) inner join cliente c2 on c.idCliente = c2.idCliente HAVING $parametros[0]  = ? and $parametros[1] = ? and $parametros[2] = ? and $parametros[3] = ?");
            $sql->bind_param("ssss", $param1, $param2, $param3, $param4);
        }else{
            throw new Exception("Solo puedes introducir como parámetro el nombre del cliente, los apellidos, la fecha, o el nombre del producto.");
        }
    }elseif(count($_GET)==5){
        $parametros=array();
        if(!empty($_GET['nombreProducto'])){
            $parametros[]="nombreProducto";
        }
        if(!empty($_GET['fecha'])){
            $parametros[]="fecha";
        }
        if(!empty($_GET['nombreCliente'])){
            $parametros[]="nombreCliente";
        }
        if(!empty($_GET['apellido1'])){
            $parametros[]="apellido1";
        }
        if(!empty($_GET['apellido2'])){
            $parametros[]="apellido2";
        }
        if(!empty($_GET['apellido1'])){
            $parametros[]="apellido1";
        }
        if(count($parametros)==5){
            // Obtener parámetro de la solicitud GET
            $param1 = $_GET[$parametros[0]]; // Obtiene el valor del valor del parámetro 1.
            $param2 = $_GET[$parametros[1]]; // Obtiene el valor del valor del parámetro 2.
            $param3 = $_GET[$parametros[2]]; //Obtiene el valor del parámetro 3
            $param4 = $_GET[$parametros[3]]; //Obtiene el valor del parámetro 4
            $param5 = $_GET[$parametros[4]];

            // Preparar la consulta en función del parámetro proporcionado
            $sql = $con->prepare("SELECT idProducto, c2.nombre as nombre, apellido1, apellido2, fecha, p.nombre as nombreProducto, precio, cantidad FROM linea_compra INNER JOIN compra c using(idCompra) inner join producto p using(idProducto) inner join cliente c2 on c.idCliente = c2.idCliente HAVING $parametros[0]  = ? and $parametros[1] = ? and $parametros[2] = ? and $parametros[3] = ? and $parametros[4] = ?");
            $sql->bind_param("sssss", $nombreCliente, $apellido1, $apellido2, $fecha, $nombreProducto);
        }else{
            throw new Exception("Solo puedes introducir como parámetro la fecha o el nombre");
        }
    }
    $sql->execute();
    $resultSet = $sql->get_result();

        // Crear respuesta XML
    $responseXML = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><lineaCompra></lineaCompra>');
    if($resultSet->num_rows > 0){
        $responseXML->addChild('status', 'OK');
        while($row = $resultSet->fetch_assoc()){
            $lineaCompraXML = $responseXML->addChild('linea_compra');
            $lineaCompraXML->addChild('nombreCliente', $row['nombreCliente']);
            $lineaCompraXML->addChild('apellido1', $row['apellido1']);
            $lineaCompraXML->addChild('apellido2', $row['apellido2']);
            $lineaCompraXML->addChild('fecha', $row['fecha']);
            $lineaCompraXML->addChild('idProducto', $row['idProducto']);
            $lineaCompraXML->addChild('nombreProducto', $row['nombreProducto']);
            $lineaCompraXML->addChild('precio', $row['precio']);
            $lineaCompraXML->addChild('cantidad', $row['cantidad']);
        }
    }else{
        // No se encontraron detalles de compra
        $responseXML->addChild('status', 'ERROR');
        $responseXML->addChild('description', 'No se han encontrado detalles de compra.');
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