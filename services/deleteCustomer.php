<?php
require '../db/db.php';
require '../utils/utilities.php';

try{
    $usuario = Utilities::validateMandatoryParameter($_GET, 'usuario');//Comprobamos los parámetros que deben de ser obligatorios en el sql (not null)
    $contrasenha = Utilities::validateMandatoryParameter($_GET, 'contrasenha'); 
    

    $database = new Database();
    $con = $database->getConnection(); //Creamos una instancia de database y obtenemos la conexion

    //Escribimos la sentencia para poder eliminar un cliente
    $sql = $con->prepare('DELETE FROM cliente WHERE usuario=? AND contrasenha=?');

    //Ponemos el tipo de dato de cada parámetro
    $sql->bind_param("ss", $usuario, $contrasenha);

    if($sql->execute()){ //Si la operación se ha hecho correctamente, le indicamos que la operación se ha hecho de manera exitosa
        $responseXML = Utilities::generateResponseXML('OK', 'Cliente eliminado con éxito.');

        header('Content-Type: application/xml');
        echo $responseXML->asXML();
    }else{ //En caso contrario, le indicamos que no se ha podido eliminar el cliente
        throw new Exception("Error al eliminar el cliente: " . $sql->error);
    }

    $sql->close();
}catch(Exception $e){
    $responseXML = Utilities::generateResponseXML('ERROR', $e->getMessage());

    header('Content-Type: application/xml');
    echo $responseXML->asXML();
}
?>