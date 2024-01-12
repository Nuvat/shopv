<?php
    session_start();
    include 'config.php';
?>
<!DOCTYPE html>
<html lang="es"><head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/view.css">
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
    
    <div id="divCon">
        <?php
        if(isset($_GET['id'])) {
            $id_producto = $_GET['id'];

            // Consultar la base de datos para obtener el nombre del producto
            $sql = "SELECT * FROM productos WHERE id = $id_producto";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Mostrar el nombre del producto
                $row = $result->fetch_assoc();
                $opc='';
                if(isset($_SESSION["user_id"])){
                    $opc = '<button onClick="window.open(`tools.php?ope=addCarrito&id=' . $id_producto .  '&count=1`,`_blank`)">Agregar al carrito</button>';
                }else{
                    $opc = '<button onClick="window.location.href=`login.php`">Agregar al carrito</button>';
                }
                echo '
                <div class="pro">
                    <h1>' . $row["nombre"] . '</h1>
                    <table border="0">
                        <tr>
                            <td style="width:200px; padding:10px;">
                                <img src="' . $row["imagen"] . '"></img>
                            </td>
                            <td style="vertical-align:top; text-align:left;">
                                <h2>' . $row["descripcion"] . '</h2>
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align:center;">
                                <h3>' . $row["precio"] . '$</h3>
                            </td>
                            <td>
                            ' . $opc . '                                
                            </td>
                        </tr>
                    </table>
                </div>
                ';
            } else {
                // Mostrar un mensaje de error si no se encuentra el ID en la base de datos
                echo "Error: No se encontró ningún producto con el ID proporcionado.";
            }
        } else {
            // Mostrar un mensaje de error si no se proporciona ningún ID en la URL
            echo "Error: No se proporcionó un ID de producto en la URL.";
        }
        ?>

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
<?php $conn->close(); ?>