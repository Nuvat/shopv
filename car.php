<?php

    session_start();
    if(!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }
    
    include 'config.php';
    $arreglo = array(); 
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Obtener los datos del formulario
        // $nombre = $_POST["nombre"];
        // $edad = $_POST["edad"];
        $sql = "SELECT carrito FROM usuarios WHERE id = " . $_SESSION["user_id"];
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $arreglo = $row["carrito"];
        }
        // $fecha = getdate();
        $fechaActual = date("d-m-Y");
        // echo $fechaActual;
        $sql = "INSERT INTO `compras` (`id`, `user_id`, `carrito`, `fecha`) VALUES (NULL, '" . $_SESSION["user_id"] . "', '" . $arreglo . "', '" . $fechaActual . "')";
        if ($conn->query($sql) === TRUE) {
            // echo "Registro insertado correctamente";
        } else {
            echo "Error al insertar el registro: " . $conn->error;
        }

        $sql = "UPDATE usuarios SET carrito = '[]' WHERE id = " . $_SESSION["user_id"];
        if ($conn->query($sql) === TRUE) {
            // echo "Actualización exitosa";
        } else {
            echo "Error al actualizar: " . $conn->error;
        }
    }

?>
<!DOCTYPE html>
<html lang="es"><head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/car.css">
</head>
<body>
    
    <header>
        <a href="/proyecto"><img src="img/logo.png" alt=""/></a>
        <div>
            <input type="text" id="barraSearch" placeholder="Búsqueda" list="search" onkeypress="handleKeyPress(event)"/>
            <datalist id="search">                
            <?php
                $sql = "SELECT * FROM productos";
                $result = $conn->query($sql);
        
                // Verificar si hay resultados
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '
                            <option value="' . $row["nombre"] . '"></option>
                        ';
                    }
                }
            ?>
            </datalist>
            <button onClick="search()">Buscar</button>
        </div>
        <ul>
            <li>
                <button onclick="toggleCategories()">Categorías</button>
                <div id="categoriesDropdown" class="categories-dropdown">
                    <button onClick="send(this)" data-type="sd">Sistemas Digitales</button>
                    <button onClick="send(this)" data-type="sce">Sistemas de control Eléctrico</button>
                    <button onClick="send(this)" data-type="com">Computación</button>
                    <button onClick="send(this)" data-type="basic">Útiles Escolares</button>
                </div>
            </li>
            <li>
            <?php
                if(isset( $_SESSION["user_id"])){
                    echo '<button onClick="window.location.href = `car.php`">Carrito</button>';
                }else{
                    echo '<button onClick="window.location.href = `login.php`">Carrito</button>';
                }
            ?>
            </li>
            <li><button onClick="window.location.href = 'account.php'"><img src="img/gui/account.png" alt=""/></button></li>
        </ul>

        
    </header>

    <div style = "text-align:center; margin-bottom:20px">
        <div id="divCon">
        
            <?php
                           
            $sql = "SELECT carrito FROM usuarios WHERE id = " . $_SESSION["user_id"];
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $arreglo = json_decode($row["carrito"],true);
            }
            $count = 0;
            foreach ($arreglo as $producto) {
                $sql = "SELECT * FROM productos WHERE id = " . $producto["producto_id"];
                $result = $conn->query($sql);
                
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    
                    echo '
                        <div class="producto">
                        <h1>' . $row["nombre"] . '</h1>
                        <h1>' . $producto["producto_count"] . '</h1>
                        <a href="edit.php?key=' . $count . '"><img src="' . $row["imagen"] . '"></img></a>
                        <h2>' . $row["precio"] . '$</h2>
                        </div>';
                        $count++;
                }
            }
            ?>

            

        </div>    
        <form method="post">
                <button type="submit" id ="purchase">Comprar</button>
        </form>
    </div>

    <footer>
        <div style="text-align: center;">
                <h1>Redes Sociales</h1>
                <section>
                    <a href="#"><img src="img/footer/facebook.png" alt=""></a>
                    <a href="#"><img src="img/footer/twitter.png" alt=""></a>
                    <a href="#"><img src="img/footer/instagram.png" alt=""></a>
                    <a href="#"><img src="img/footer/youtube.png" alt=""></a>
                </section>
        </div>
        <div style="display: flex">
            <div>
                <h1>Acerca de</h1>
                <h2 style="margin-right: 10%;">Proyecto estudiantil creado por Meneses Maldonado Israel y Martínez Salazar Brandon, del Grupo 5IV5 <br> Gloria al Instituto Politécnico Nacional, La técnica al servicio de la patria.</h2>
            </div>
            <div style="text-align: right;">
                <h1>Ubicación</h1>
                <h2 style="margin-left: 10%;">Manzana 027<br>5518 Ecatepec de Morelos.<br>Laboratorio II de  Computación</h2>
            </div>
        </div>
    </footer>

<script src="js/index.js"></script>

</body>
</html>