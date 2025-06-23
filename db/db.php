<?php
class Database {

    private $servername = "";
    private $username = "";
    private $password = "";
    private $dbname = "";

    private $conn;
    private $config;
    private $archivoConfig = '../db/cfg/config.properties';

    private function lookUpInformation() {
        // Verificar si el archivo existe
        if (file_exists($this->archivoConfig)) {
            // Leer el archivo de configuración y almacenar las propiedades en un array
            $this->config = parse_ini_file($this->archivoConfig);

            // Acceder a las propiedades
            $this->servername = $this->config['db_host'];
            $this->username = $this->config['db_username'];
            $this->password = $this->config['db_password'];
            $this->dbname = $this->config['db_name'];
        } else {
            throw new Exception("El archivo de configuración no existe.");
        }
    }

    public function __construct() {
        $this->lookUpInformation();
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        if ($this->conn->connect_error) {
            throw new Exception("La conexión a la base de datos falló: " . $this->conn->connect_error);
        }
    }

    public function getConnection() {
        return $this->conn;
    }
}
?>