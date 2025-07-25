<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Clientes ARVID</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="../res/CSS/Nuestro.css">
    </head>

    <body>
    <script src="../res/scripts/copiarPortapapeles.js"></script>
    <nav class="navbar navbar-expand-lg bg-body-tertiary" class="navbar bg-dark border-bottom border-body" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="http://localhost/TiendaJuegosManagement/">
                <img src="../res/img/logo_ARVID_Mando.png" alt="ARVID" width="50" height="50">
              </a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="http://localhost/TiendaJuegosManagement/">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Clientes
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="formReadCustomer.html">Buscar cliente</a></li>
                            <li><a class="dropdown-item" href="formCreateCustomer.html">Crear cliente</a></li>
                            <li><a class="dropdown-item" href="formDeleteCustomer.php">Eliminar cliente</a></li>
                            <li><a class="dropdown-item" href="formUpdatePasswordCustomer.php">Cambiar contraseña</a></li>
                        </ul>
                    </li>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Proveedores
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="formReadSupplier.html">Buscar proveedor</a></li>
                            <li><a class="dropdown-item" href="formCreateSupplier.html">Crear proveedor</a></li>
                            <li><a class="dropdown-item" href="formDeleteSupplier.php">Eliminar proveedor</a></li>
                            <li><a class="dropdown-item" href="formUpdatePhoneSupplier.php">Cambiar teléfono</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Productos
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="formReadProduct.html">Buscar producto</a></li>
                            <li><a class="dropdown-item" href="formCreateProduct.php">Crear producto</a></li>
                            <li><a class="dropdown-item" href="formDeleteProduct.php">Eliminar producto</a></li>
                            <li><a class="dropdown-item" href="formUpdatePriceProduct.php">Cambiar precio</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Compras
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="formReadBuy.html">Buscar compra</a></li>
                            <li><a class="dropdown-item" href="formCreateBuy.php">Crear compra</a></li>
                            <li><a class="dropdown-item" href="formDeleteBuy.php">Eliminar compra</a></li>
                            <li><a class="dropdown-item" href="formUpdateDateBuy.php">Cambiar fecha</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Líneas de compra
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="formReadPurchaseLine.html">Buscar línea de compra</a></li>
                            <li><a class="dropdown-item" href="formDeletePurchaseLine.php">Eliminar línea de compra</a></li>
                            <li><a class="dropdown-item" href="formUpdateQuantityProductPurchaseLine.php">Cambiar cantidad de producto</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
      </nav>
    <div class="content">
        <h1><b>CLIENTES</b></h1>
<?php
// Ruta al archivo createCustomer.php en tu servidor
$nombre = $_GET['nombre'];
$nombre=str_replace(" ", "+", $nombre);
$usuario = $_GET['usuario'];
$usuario=str_replace(" ", "+", $usuario);
$contrasenha = $_GET['contrasenha'];
$url_dame_clientes="http://iescristobaldemonroy.duckdns.org:81/USER48/TiendaJuegosManagement/services/createCustomer.php?nombre=$nombre&usuario=$usuario&contrasenha=$contrasenha";
if(!empty($_GET['apellido1'])){
    $apellido1 = $_GET['apellido1'];
    $apellido1=str_replace(" ", "+", $apellido1);
    $url_dame_clientes .="&apellido1=$apellido1";
}
if(!empty($_GET['apellido2'])){
    $apellido2 = $_GET['apellido2'];
    $apellido2=str_replace(" ", "+", $apellido2);
    $url_dame_clientes .="&apellido2=$apellido2";
}
if(!empty($_GET['edad'])){
    $edad = $_GET['edad'];
    $url_dame_clientes .= "&edad=$edad";
}


// Hacer la solicitud HTTP y obtener el XML como una cadena
$xmlString = file_get_contents($url_dame_clientes);

// Verificar si la solicitud fue exitosa
if ($xmlString === FALSE) {
    die('Error al obtener el XML de createCustomer.php');
}

// Procesar el XML con SimpleXML
$xml = simplexml_load_string($xmlString);

//Revisamos la operación y hacemos el HTML del resultado
$output = $xml->status;
if($output=="OK"){
    echo "<h1>El cliente se ha insertado correctamente.</h1>";
}else{
    if($output == "ERROR"){
        echo "<h1>No se ha podido insertar el cliente.</h1>";
        echo "<h2>Vuelve a revisar los datos. Es posible que exista el cliente con usuario $usuario.</h2>";
    }
}
?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>