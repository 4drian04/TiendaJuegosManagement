<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filtros de creación de compras</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../res/CSS/Nuestro.css">
</head>
<body>
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
    <div class="formulario">
        <h2>Datos de la compra</h2>
        <form action="llamadaCreateBuy.php">
            <label for="fecha">Fecha de la compra:</label>
            <input type="date" id="fecha" name="fecha" class="form-control" required>

            <label for="idCliente">Cliente:</label>
            <select name="idCliente" id="idCliente" class="form-select">
                <?php
                    $url_dame_clientes = 'http://iescristobaldemonroy.duckdns.org:81/USER48/TiendaJuegosManagement/services/readCustomer.php';

                    // Hacer la solicitud HTTP y obtener el XML como una cadena
                    $xmlString = file_get_contents($url_dame_clientes);

                    // Verificar si la solicitud fue exitosa
                    if ($xmlString === FALSE) {
                        die('Error al obtener el XML de readCliente.php');
                    }

                    // Procesar el XML con SimpleXML
                    $xml = simplexml_load_string($xmlString);

                    foreach ($xml->cliente as $cliente) {
                        ?>
                        <option value="<?php echo $cliente->idCliente; ?>">
                            <?php echo $cliente->nombre?>
                        </option>
                        <?php
                    }
                ?>
            </select>

            <label for="idProducto">Productos:</label>
            <ul style="list-style: none; padding-left:0;">
                
                <?php
                    $url_dame_productos = 'http://iescristobaldemonroy.duckdns.org:81/USER48/TiendaJuegosManagement/services/readProduct.php';

                    // Hacer la solicitud HTTP y obtener el XML como una cadena
                    $xmlString = file_get_contents($url_dame_productos);

                    // Verificar si la solicitud fue exitosa
                    if ($xmlString === FALSE) {
                        die('Error al obtener el XML de readProduct.php');
                    }

                    // Procesar el XML con SimpleXML
                    $xml = simplexml_load_string($xmlString);
                    foreach ($xml->producto as $producto) {
                        $ternariaPlataforma = $producto->plataforma==""?"":"($producto->plataforma)";
                        ?>
                        <li>
                            <input type="checkbox" name="ID<?php echo $producto->idProducto; ?>">
                            <span><?php echo "{$producto->nombre}{$ternariaPlataforma} ➪ {$producto->precio}€"?></span>
                            <input class="form-control" type="number" name="cantidad<?php echo $producto->idProducto; ?>" min="0" placeholder="Cantidad">
                        </li>
                        <?php 
                    }
                ?>
            </ul>
            <input type="submit" value="Enviar">
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>