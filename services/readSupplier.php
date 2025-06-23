<?php
require '../db/db.php';
require '../utils/utilities.php';

try{
    $database = new Database();
    $con = $database->getConnection();
    if(count($_GET)==0){

        $sql = $con->prepare("SELECT * FROM proveedor");
    }elseif(count($_GET)==1){
        $paramCorrectos = (strcmp(key($_GET), "nombre")==0);
        if($paramCorrectos){
            // Obtener parámetro de la solicitud GET
            $parametro = key($_GET); // Me devuelve el nombre del parámetro pasado.
            $valorParametro = $_GET[$parametro]; // Obtiene el valor del valor del parámetro.
            // Preparar la consulta en función del parámetro proporcionado
            $sql = $con->prepare("SELECT * FROM proveedor WHERE $parametro = ?");
            $sql->bind_param("s", $valorParametro);
    }else{
        throw new Exception("Solo puedes introducir como parámetro el nombre");
    }
    
}elseif(count($_GET)>1){
    throw new Exception("Solo puedes introducir un parámetro.");
}
$sql->execute();
    $resultSet = $sql->get_result();
    //Empezamos a crear el XML correspondiente
    $responseXML = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><proveedores></proveedores>');

    if($resultSet->num_rows > 0){
        $responseXML->addChild('status', 'OK');
        while($row = $resultSet->fetch_assoc()){
            $proveedorXML = $responseXML->addChild('proveedor');
            $proveedorXML->addChild('idProveedor', $row['idProveedor']);
            $proveedorXML->addChild('nombre', $row['nombre']);
            $proveedorXML->addChild('telefono', $row['telefono']);
        }
    }else{
        // No se encontraron proveedores
        $responseXML->addChild('status', 'ERROR');
        $responseXML->addChild('description', 'No se han encontrado proveedores.');
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