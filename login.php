<?php
    session_start();
    
    include 'config.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST["email"];
        $password = $_POST["password"];
        $sql = "SELECT * FROM usuarios WHERE email = '$email'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $hash = $row["password"];
            if (password_verify($password, $hash)) {
                echo "Inicio de sesión exitoso. Bienvenido " . $row["nombre"];
                $_SESSION["user_id"] = $row["id"];
                $_SESSION["user_nombre"] = $row["nombre"];
                $_SESSION["user_email"] = $row["email"];
                $_SESSION["user_edad"] = $row["edad"];
                $_SESSION["user_domicilio"] = $row["domicilio"];
                header("Location: account.php");
                exit();
            }else{
                header("Location: login.php?msg=not-found");
                exit();
            }
        } else {
            header("Location: login.php?msg=not-found");
            exit();
        }
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/login.css">
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
        <section>
            
            <span style="font-size:30px; font-family: Arial, sans-serif;">Inicio de sesión</span>
            <form method="post">
                <input placeholder="Correo Electrónico" type="email" name="email" required><br>
                <input placeholder="Contraseña" type="password" name="password" required><br>
                <button type="submit" id="sumbit">Iniciar Sesión</button>
            </form>
            <?php
            if(isset($_GET['msg'])){
                if($_GET['msg']=="not-found"){
                    echo "<span>Usuario o contraseñas inválidos</span>";
                }
            }
            ?>
            <br>
            <a href="register.php" style="font-weight: bolder;">Registrarse</a>
        </section>
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
<?php $conn->close();?>