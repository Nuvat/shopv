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
    <link rel="stylesheet" href="css/edit.css">
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

    <script>
    function validarNumero(input) {
        if(isNaN(input.value[input.value.length-1])){
            input.value=input.value.slice(0, -1);;
        }
    }
    function operar(obj){
        if(obj.textContent=="+"){
            obj.parentNode.childNodes[3].value = parseInt(obj.parentNode.childNodes[3].value, 10)+1;
        }
        if(obj.textContent=="-"){
            if(parseInt(obj.parentNode.childNodes[3].value, 10)>1){
                obj.parentNode.childNodes[3].value = parseInt(obj.parentNode.childNodes[3].value, 10)-1;
            }
        }
    }
    function accept(obj, key){
        window.open(`tools.php?ope=editProducto&key=${key}&value=${obj.parentNode.childNodes[3].value}`, "_blank", "width=500,height=500,toolbar=no,location=no,status=no,menubar=no,scrollbars=yes");
    }
    function eliminar(obj, key) {
        window.open(`tools.php?ope=deleteProducto&key=${key}`, "_blank", "width=500,height=500,toolbar=no,location=no,status=no,menubar=no,scrollbars=yes");
        window.location.href = "car.php";
    }
    </script>
    
    <div id="divCon">
        <?php
        $arreglo = array();                
        $sql = "SELECT carrito FROM usuarios WHERE id = " . $_SESSION["user_id"];
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $arreglo = json_decode($row["carrito"],true)[intval($_GET["key"])];

        $sql = "SELECT * FROM productos WHERE id = " . $arreglo["producto_id"];
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        if ($result->num_rows > 0) {
            


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
                            <button onclick="operar(this);">-</button>
                            <input type="text" id="count" oninput="validarNumero(this)" value="' . $arreglo["producto_count"] . '">
                            <button onclick="operar(this);" style="margin-left:0">+</button>
                            <button onClick="accept(this,' . $_GET["key"] . ')">Aceptar</button>
                            <button onClick="eliminar(this,' . $_GET["key"] . ')">Eliminar</button>
                        </td>
                    </tr>
                </table>
            </div>
            ';
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