<?php
/* Configuracion de la conexion a la DB X Projects */
$serverName = "sql211.infinityfree.com";
$dbName = "if0_38061924_xprojectsdb";
$userName = "if0_38061924";
$password = "Vm1LfWVScWM";


try {
    /* Haciendo la conexcion con pdo */
    $conn = NEW PDO("mysql:host=$serverName;dbname=$dbName;charset=utf8", $userName, $password);
    // Manejo de errores
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Por si hay un error en la conexion
    die("Error en la conexión: " . $e->getMessage());
}

/* Procesar el formulario de contacto */
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanear los datos recibidos del formulario
    $nombre = htmlspecialchars(trim($_POST["nombre"]));
    $correo = htmlspecialchars(trim($_POST["correo"]));
    $asunto = htmlspecialchars(trim($_POST["asunto"]));
    $mensaje = htmlspecialchars(trim($_POST["mensaje"]));

    // Validar que los campos no esten vacios
    if(empty($nombre) || empty($correo) || empty($asunto) || empty($mensaje)){
        // Mensaje de error para el usuario
        echo "Por favor, rellena todos los campos del formulario.";
        exit();
    }

    // Validar que el correo sea valido
    if(!filter_var($correo, FILTER_VALIDATE_EMAIL)){
        // Mensaje de error para el usuario
        echo "El correo electrónico no es válido.";
        exit();
    }

    // Validar la longitud de los campos
    // Nombre entre 3 y 50 caracteres
    if (strlen($nombre) < 3 || strlen($nombre) > 50) {
        echo "El nombre debe tener entre 3 y 50 caracteres.";
        exit();
    }
    
    // Asunto entre 5 y 150 caracteres
    if (strlen($asunto) < 5 || strlen($asunto) > 150) {
        echo "El asunto debe tener entre 5 y 150 caracteres.";
        exit();
    }
    
    // Mensaje con al menos 10 caracteres
    if (strlen($mensaje) < 10) {
        echo "El mensaje debe tener al menos 10 caracteres.";
        exit();
    }
    

    // Preparar la consulta para insertar los datos en la tabla de contacto
    $sql = "INSERT INTO Contacto(nombre, correo, asunto, mensaje) VALUES(:nombre, :correo, :asunto, :mensaje)";

    try{
        //Preparar la consulta y ejecutarla
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":nombre", $nombre);
        $stmt->bindParam(":correo", $correo);
        $stmt->bindParam(":asunto", $asunto);
        $stmt->bindParam(":mensaje", $mensaje);

        // Ejecutar la consulta
        $stmt->execute();

        // Mensaje de exito para el usuario
        echo "Gracias por contactarme! Tu mensaje ha sido recibido correctamente.";
    } catch (PDOException $e) {
        // Por si hay un error al insertar los datos
        die("Error al guardar el mensaje: " . $e->getMessage());
    }
}
?>