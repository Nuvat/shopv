<?php
    session_start();
    // $servername = "bo35vnjsi1uvz3jbrfqu-mysql.services.clever-cloud.com"; //Host o url del server
    // $username = "ubt2vsftfwt96m6v";
    // $password = "Keg3w3mqayd1kT7m5WDO";
    // $dbname = "bo35vnjsi1uvz3jbrfqu";  
    $servername = "localhost"; //Host o url del server
    $username = "root";
    $password = "";
    $dbname = "shopv";  
    // Crear conexión
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }


    if($_GET['ope']=="logout"){
        $_SESSION = array();
        session_destroy();
        header("Location: login.php");
        exit();
    }    

    if (isset($_GET['ope']) && $_GET['ope'] == "addCarrito" && isset( $_SESSION["user_id"] ) ){
        if (isset($_GET['id']) && isset($_GET['count'])) {
            // Verificar si 'id' es un número
            if (is_numeric($_GET['id']) && is_numeric($_GET['count'])) {
                // Convertir 'id' a entero antes de realizar operaciones matemáticas


                $producto_id = intval($_GET['id']);
                $producto_count = intval($_GET['count']);
                $arreglo = array();
                
                $sql = "SELECT * FROM usuarios WHERE id = " . $_SESSION["user_id"];
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $arreglo = json_decode($row["carrito"],true);
                }
                array_push($arreglo, array('producto_id' => $producto_id, 'producto_count' => $producto_count));
                
                $carrito = json_encode($arreglo);

                $sql = "UPDATE usuarios SET carrito = '$carrito' WHERE id = " . $_SESSION["user_id"];

                if ($conn->query($sql) === TRUE) {
                    echo "La actualización se realizó correctamente.";
                    // header('Location: ' . $_SERVER['HTTP_REFERER']);
                    // exit();
                    echo '<script>window.close()</script>';
                } else {
                    echo "Error al actualizar: " . $conn->error;
                }


            } else {
                echo "El valor de 'id' no es un número.";
            }
        } else {
            echo "Falta la información necesaria en la URL.";
        }
    }
    // else{
    //     header("Location: login.php");
    //     exit();
    // }
    if($_GET['ope']=="editProducto"){        
        $arreglo = array();  
        $sql = "SELECT carrito FROM usuarios WHERE id = " . $_SESSION["user_id"];
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $arreglo = json_decode($row["carrito"],true);
        // print_r($arreglo[intval($_GET["key"])]);
        $arreglo[intval($_GET["key"])]["producto_count"] = intval($_GET["value"]);
        // print_r($arreglo[intval($_GET["key"])]);
        $json = json_encode($arreglo);
        $sql = "UPDATE usuarios SET carrito = '$json' WHERE id = " . $_SESSION["user_id"];
        if ($conn->query($sql) === TRUE) {
            echo "Actualización exitosa";
        } else {
            echo "Error al actualizar: " . $conn->error;
        }
        echo "<script>window.close();</script>";
    } 
    if($_GET['ope']=="deleteProducto"){        
        $arreglo = array();  
        $sql = "SELECT carrito FROM usuarios WHERE id = " . $_SESSION["user_id"];
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $arreglo = json_decode($row["carrito"],true);

        array_splice($arreglo, intval($_GET["key"]), 1);

        $json = json_encode($arreglo);
        $sql = "UPDATE usuarios SET carrito = '$json' WHERE id = " . $_SESSION["user_id"];
        if ($conn->query($sql) === TRUE) {
            echo "Actualización exitosa";
        } else {
            echo "Error al actualizar: " . $conn->error;
        }
        echo "<script>window.close();</script>";
    }  
    $conn->close();
?>