<?php
    session_start();
    $msg="";
    include 'config.php';    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Obtener los datos del formulario
        $nombre = $_POST["nombre"];
        $edad = $_POST["edad"];
        $domicilio = $_POST["domicilio"];
        $email = $_POST["email"];
        $password = password_hash($_POST["password"], PASSWORD_DEFAULT); // Hash de la contraseña

        // Verificar si el email ya existe
        $sql_verificacion = "SELECT id FROM usuarios WHERE email = '$email'";
        $result_verificacion = $conn->query($sql_verificacion);

        if ($result_verificacion->num_rows > 0) {
            // echo "Ya existe un usuario con este correo electrónico.";
            $msg = "<span>Ya existe un usuario con este correo electrónico.</span>";
        } else {
            // Preparar la consulta SQL
            $arreglo = array();
            $json = json_encode($arreglo);
            $sql = "INSERT INTO usuarios (nombre, edad, domicilio, email, password, carrito) VALUES ('$nombre', $edad, '$domicilio', '$email', '$password', '$json')";

            // Ejecutar la consulta
            if ($conn->query($sql) === TRUE) {
                echo "Usuario registrado con éxito.";
                header("Location: login.php");
                exit();
            } else {
                echo "Error al registrar usuario: " . $conn->error;
            }
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
            <span style="font-size:30px; font-family: Arial, sans-serif;">Registro de sesión</span>
            <form method="post">
                <input placeholder="nombre" type="text" name="nombre" required><br>
                <input type="number" placeholder="edad" min="18" max="130" step="1" name="edad" required><br>
                <input type="text" placeholder="domicilio" name="domicilio" required><br>
                <input placeholder="Correo Electrónico" type="email" name="email" required><br>
                <input placeholder="Contraseña" type="password" name="password" required><br>

                <button id="sumbit" type="submit">Registrarse</button>
            </form>
            <?php
            

            echo $msg;


            ?>     
            <br>
            <span id="msg"></span>
            <a href="login.php" style="font-weight: bolder;">Iniciar Sesión</a>
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
<?php $conn->close(); ?>