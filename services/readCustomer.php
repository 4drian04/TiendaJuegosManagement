<?php
require '../db/db.php';
require '../utils/utilities.php';

try{
    $database = new Database();
    $con = $database->getConnection();
    if(count($_GET)==0){
        $sql = $con->prepare("SELECT * FROM cliente");
    }elseif(count($_GET)==1){
        $paramCorrectos = ((strcmp(key($_GET), "usuario")==0) || (strcmp(key($_GET), "nombre")==0) || (strcmp(key($_GET), "apellido1")==0) || (strcmp(key($_GET), "apellido2")==0));
        if($paramCorrectos){
            // Obtener parámetro de la solicitud GET
            $parametro = key($_GET); // Me devuelve el nombre del parámetro pasado.
            $valorParametro = $_GET[$parametro]; // Obtiene el valor del valor del parámetro.

            // Preparar la consulta en función del parámetro proporcionado
            $sql = $con->prepare("SELECT * FROM cliente WHERE $parametro = ?");
            $sql->bind_param("s", $valorParametro);

        }else{
            throw new Exception("Solo puedes introducir como parámetro el usuario, el nombre, el primer apellido o el segundo apellido.");
        }
    }elseif(count($_GET)==2){
        $parametros=array();
        if(!empty($_GET['nombre'])){
            $parametros[]="nombre";
        }
        if(!empty($_GET['apellido1'])){
            $parametros[]="apellido1";
        }
        if(!empty($_GET['apellido2'])){
            $parametros[]="apellido2";
        }
        if(!empty($_GET['usuario'])){
            $parametros[]="usuario";
        }

        if(count($parametros)==2){
            $param1 = $_GET[$parametros[0]]; // Obtiene el valor del valor del parámetro 1.
            $param2 = $_GET[$parametros[1]]; // Obtiene el valor del valor del parámetro 2.

            // Preparar la consulta en función del parámetro proporcionado
            $sql = $con->prepare("SELECT * FROM cliente WHERE $parametros[0] = ? and $parametros[1] = ?");
            $sql->bind_param("ss", $param1, $param2);
        }else{
            throw new Exception("Solo puedes introducir como parámetro el usuario, el nombre, el primer apellido o el segundo apellido.");
        }
    }elseif(count($_GET)==3){
        $parametros=array();
        if(!empty($_GET['nombre'])){
            $parametros[]="nombre";
        }
        if(!empty($_GET['apellido1'])){
            $parametros[]="apellido1";
        }
        if(!empty($_GET['apellido2'])){
            $parametros[]="apellido2";
        }
        if(!empty($_GET['usuario'])){
            $parametros[]="usuario";
        }

        if(count($parametros)==3){
            $param1 = $_GET[$parametros[0]]; // Obtiene el valor del valor del parámetro 1.
            $param2 = $_GET[$parametros[1]]; // Obtiene el valor del valor del parámetro 2.
            $param3 = $_GET[$parametros[2]]; // Obtiene el valor del valor del parámetro 3.

            // Preparar la consulta en función del parámetro proporcionado
            $sql = $con->prepare("SELECT * FROM cliente WHERE $parametros[0] = ? and $parametros[1] = ? and $parametros[2] = ?");
            $sql->bind_param("sss", $param1, $param2, $param3);
        }else{
            throw new Exception("Solo puedes introducir como parámetro el usuario, el nombre, el primer apellido o el segundo apellido.");
        }
    }elseif(count($_GET)==4){
        if(!empty($_GET['nombre']) && !empty($_GET['apellido1']) && !empty($_GET['apellido2']) && !empty($_GET['usuario'])){
            $nombre = $_GET['nombre']; // Obtiene el valor del valor del parámetro 1.
            $apellido1 = $_GET['apellido1']; // Obtiene el valor del valor del parámetro 2.
            $apellido2 = $_GET['apellido2']; // Obtiene el valor del valor del parámetro 3.
            $usuario = $_GET['usuario']; // Obtiene el valor del valor del parámetro 4.
    
            // Preparar la consulta en función del parámetro proporcionado
            $sql = $con->prepare("SELECT * FROM cliente WHERE nombre = ? and apellido1 = ? and apellido2 = ? and usuario = ?");
            $sql->bind_param("ssss", $nombre, $apellido1, $apellido2, $usuario);
    
        }else{
            throw new Exception("Solo puedes introducir el usuario, el nombre, primer apellido y segundo apellido.");
        }
    }else{
        throw new Exception("Solo puedes introducir el usuario, el nombre, primer apellido y segundo apellido.");
    }

    $sql->execute();
    $resultSet = $sql->get_result();

    //Empezamos a crear el XML correspondiente
    $responseXML = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><clientes></clientes>');

    if($resultSet->num_rows > 0){
        $responseXML->addChild('status', 'OK');
        while($row = $resultSet->fetch_assoc()){
            $clienteXML = $responseXML->addChild('cliente');
            $clienteXML->addChild('idCliente', $row['idCliente']);
            $clienteXML->addChild('nombre', $row['nombre']);
            $clienteXML->addChild('primerApellido', $row['apellido1']);
            $clienteXML->addChild('segundoApellido', $row['apellido2']);
            $clienteXML->addChild('usuario', $row['usuario']);
            $clienteXML->addChild('contraseña', $row['contrasenha']);
            $clienteXML->addChild('edad', $row['edad']);
        }
    }else{
        // No se encontraron clientes
        $responseXML->addChild('status', 'ERROR');
        $responseXML->addChild('description', 'No se han encontrado clientes.');
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