<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Compras ARVID</title>
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
        <h1><b>BORRAR COMPRAS</b></h1>
<?php
//Recogemos el ID de la compra.
$idCompra = $_GET['idCompra'];

//Buscamos los id de los productos de las líneas de compras de la compra con dicho ID.
$url_dame_lineas_de_compra = "http://iescristobaldemonroy.duckdns.org:81/USER48/TiendaJuegosManagement/services/readPurchaseLine.php?idCompra=$idCompra";

// Hacer la solicitud HTTP y obtener el XML como una cadena
$xmlString = file_get_contents($url_dame_lineas_de_compra);

// Verificar si la solicitud fue exitosa
if ($xmlString === FALSE) {
    die('Error al obtener el XML de readBuy.php');
}

// Procesar el XML con SimpleXML
$xml = simplexml_load_string($xmlString);

//Recogemos los IDs de los productos en un array.
$idsproductos=array();
foreach ($xml->linea_compra as $linea_compra) {
    $idsproductos[]=$linea_compra->idProducto;
}

//Borramos todas las líneas de compra.
$operacionCorrecta=TRUE;
foreach ($idsproductos as &$idProducto) {
    $url_elimina_lineas_de_compra = "http://iescristobaldemonroy.duckdns.org:81/USER48/TiendaJuegosManagement/services/deletePurchaseLine.php?idCompra=$idCompra&idProducto=$idProducto";

    // Hacer la solicitud HTTP y obtener el XML como una cadena
    $xmlString = file_get_contents($url_elimina_lineas_de_compra);

    
    // Verificar si la solicitud fue exitosa
    if ($xmlString === FALSE) {
        die('Error al obtener el XML de deletePurchaseLine.php');
    }
    
    // Procesar el XML con SimpleXML
    $xml = simplexml_load_string($xmlString);
    
    // Construir la lista HTML
    $output = $xml->status;
    
    if($output=="ERROR"){
        $operacionCorrecta=FALSE;
    }
}

//Ahora sí, borramos la compra. 
if($operacionCorrecta){
    // Ruta al archivo deleteBuy.php en tu servidor
    $url_borrar_compra="http://iescristobaldemonroy.duckdns.org:81/USER48/TiendaJuegosManagement/services/deleteBuy.php?idCompra=$idCompra";

    // Hacer la solicitud HTTP y obtener el XML como una cadena
    $xmlString = file_get_contents($url_borrar_compra);

    // Verificar si la solicitud fue exitosa
    if ($xmlString === FALSE) {
        die('Error al obtener el XML de deleteBuy.php');
    }

    // Procesar el XML con SimpleXML
    $xml = simplexml_load_string($xmlString);

    // Construir la lista HTML
    $output = $xml->status;
    if($output=="OK"){
        echo "<h1>La compra se ha borrado correctamente.</h1>";
    }else{
        if($output == "ERROR"){
            echo "<h1>No se ha podido borrar la compra. $xml->description</h1>";
        }
    }
}else{
    if($output == "ERROR"){
        echo "<h1>No se ha podido borrar la compra.</h1>";
    }
}
?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>