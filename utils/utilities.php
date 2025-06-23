<?php
/**
* Esta clase centralizará la implementación de operaciones comunes en los servicios.
* Se describirán una a una.
*/
class Utilities {

    /**
    * Función para validar obligatoriedad de parámetros.
    * @arg params Todos los parámetros recibidos en el GET
    * @arg paramName Nombre del parámetro a chequear.
    * @return valor del parámetro validado.
    */
    public static function validateMandatoryParameter($params, $paramName) {
        if (!isset($params[$paramName]) || $params[$paramName] === '') {
            throw new Exception("Bad usage: Mandatory '$paramName'");
        }

        return $params[$paramName];
    }

    /**
    * Función para generar el XML de respuesta (usado en respuesta errónea).
    * @arg status Estado a incluir en el XML.
    * @arg description Descripción de la información a incluir en el XML.
    * @return XML generado.
    */
    public static function generateResponseXML($status, $description) {
        $responseXML = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><response></response>');
        $responseXML->addChild('status', $status);
        $responseXML->addChild('description', $description);

        return $responseXML;
    }

    /**
    * Función para formatear fecha desde el formato europeo hasta el usado en la BD MySQL.
    * @arg date String con la fecha a formatera (DD/MM/YYYY)
    * @return String con la fecha validada y formateada (YYYY-MM-DD)
    */
    public static function formatEuropeanDateToMySQL($date) {
        // Formato de entrada: DD/MM/YYYY
        $dateParts = explode('/', $date);
        if (count($dateParts) === 3) {
            // Formato de salida: YYYY-MM-DD
            return $dateParts[2] . '-' . $dateParts[1] . '-' . $dateParts[0];
        } else {
            throw new Exception("Invalid date format: $date");
        }
    }
}
?>