
<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Proveedores ARVID</title>
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
        <h1><b>PROVEEDORES</b></h1>
<?php
// Ruta al archivo readSupplier.php en tu servidor
$url_dame_proveedores = "http://iescristobaldemonroy.duckdns.org:81/USER48/TiendaJuegosManagement/services/readSupplier.php";
if(!empty($_GET['nombre'])){
    $nombre = $_GET['nombre'];
    $nombre=str_replace(" ", "+", $nombre);
    $url_dame_proveedores .= "?nombre=$nombre";
}

// Hacer la solicitud HTTP y obtener el XML como una cadena
$xmlString = file_get_contents($url_dame_proveedores);

// Verificar si la solicitud fue exitosa
if ($xmlString === FALSE) {
    die('Error al obtener el XML de readSupplier.php');
}

// Procesar el XML con SimpleXML
$xml = simplexml_load_string($xmlString);

// Construir la lista HTML
if($xml->status == 'OK'){
    // Construir la lista HTML
    $output = "<ul class=\"busqueda\">";
    $i=0;
    foreach ($xml->proveedor as $proveedor) {
        $i++;
        $ternariaTelefono = $proveedor->telefono==""?"":"({$proveedor->telefono})";
        $output .= "<li onclick=\"copiarTexto('textoACopiar{$i}')\"><span class='icono'>🌟</span><span id=\"textoACopiar{$i}\">{$proveedor->nombre}</span>$ternariaTelefono</li>";
    }

    $output .= "</ul>";
}else{
    $output = "<h1>ERROR</h1><h2 class='text-danger'><p class='font-weight-bold'>";
    $output.=$xml->description;
    $output.="</p></h2>";
}

$output .= "</div>";

// Mostrar la lista en tu página
echo $output;
?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>