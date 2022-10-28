<?php

/** INICIAMOS LA CONEXIÓN CON LA BASE DE DATOS Y GUARDAMOS EN $conn**/
$servername = "localhost";
$username = "root";
$password = ""; //si no es vacía, probar con root
$dbname = "databasecruda";
$dbport = 3306;

//definimos la variable $conn en el ámbito raíz del fichero para poder usarlo más adelante
$conn = null;

try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname;port=$dbport", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  //$conn->setAttribute(PDO::ATTR_TIMEOUT, 2);
  //echo "Conectado correctamente";
} catch(PDOException $e) {
  echo "Error en la conexión" . $e->getMessage();
  //Si hay un error lanzamos un 500 informando
  http_response_code(500);
  echo '{"message": "Se ha producido un error interno. Ponte en contacto con el administrador si el problema persiste."}';
  return;
}