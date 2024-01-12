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
    <link rel="stylesheet" href="css/anim.css">
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

        if (isset($_GET['type']) ) {
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                echo '<div id="productos">';
                $count = 0;
                while ($row = $result->fetch_assoc()) {
                    if(in_array($_GET['type'],explode(",", $row["types"]))){
                        $count++;
                        echo '
                        <div class="producto">
                        <h1>' . $row["nombre"] .'</h1>
                        <a href="view.php?id=' . $row["id"] . '"><img src="' . $row["imagen"] . '"></img></a>
                        <h2>' . $row["precio"] . '$</h2>
                        </div>
                        ';
                        if($count==5){
                            $count=0;
                            echo '</tr><tr>';
                        }
                    }
                }
                echo '</div>';

            } else {
                echo "No hay resultados.";
            }
        }
        elseif( isset($_GET['name'])){
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                echo '<div id="productos">';
                $count = 0;
                while ($row = $result->fetch_assoc()) {
                    if(stripos($row["nombre"], $_GET["name"]) !== false){
                        $count++;
                        echo '
                        <div class="producto">
                        <h1>' . $row["nombre"] .'</h1>
                        <a href="view.php?id=' . $row["id"] . '"><img src="' . $row["imagen"] . '"></img></a>
                        <h2>' . $row["precio"] . '$</h2>
                        </div>
                        ';
                        if($count==5){
                            $count=0;
                            echo '</tr><tr>';
                        }
                    }
                }
                echo '</div>';
            } else {
                echo "No hay resultados.";
            }           
        }
        elseif( isset($_GET['topic'])){
            if($_GET['topic']=="new"){
                $sql = "SELECT * FROM productos ORDER BY id DESC";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    echo '<div id="productos">';
                    $count = 0;
                    while ($row = $result->fetch_assoc()) {
                        $count++;
                        echo '
                        <div class="producto">
                        <h1>' . $row["nombre"] .'</h1>
                        <a href="view.php?id=' . $row["id"] . '"><img src="' . $row["imagen"] . '"></img></a>
                        <h2>' . $row["precio"] . '$</h2>
                        </div>
                        ';
                        if($count==5){
                            $count=0;
                            echo '</tr><tr>';
                        }
                    }
                    echo '</div>';
                } else {
                    echo "No hay resultados.";
                }           
            }
            if($_GET['topic']=="mostSell"){
                $sql = "SELECT * FROM productos ORDER BY ventas DESC";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    echo '<div id="productos">';
                    $count = 0;
                    while ($row = $result->fetch_assoc()) {
                        $count++;
                        echo '
                        <div class="producto">
                        <h1>' . $row["nombre"] .'</h1>
                        <a href="view.php?id=' . $row["id"] . '"><img src="' . $row["imagen"] . '"></img></a>
                        <h2>' . $row["precio"] . '$</h2>
                        </div>
                        ';
                        if($count==5){
                            $count=0;
                            echo '</tr><tr>';
                        }
                    }
                    echo '</div>';
                } else {
                    echo "No hay resultados.";
                }           
            } 
        }
        else {
            echo "Por favor, ingrese una consulta de búsqueda.";
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