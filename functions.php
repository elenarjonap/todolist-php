<?php

function getRequestBody(){
  $json = file_get_contents('php://input');
  
  return json_decode($json, true);
}

function insertTask($conn, $taskData){
  $insertTask = [
    ':title' => $taskData['title'],
    ':category' => $taskData['category'],
    ':description' => $taskData['description'],
    ':created_at' => (new DateTime())->format('Y-m-d H:i:s')
  ];

  $insertSQL = "INSERT INTO tareas (title, category, description, created_at) VALUES (:title, :category, :description, :created_at)";
  //le decimos a PDO que prepare la consulta de $insertSQL para su uso posterior
  $query = $conn->prepare($insertSQL);
  
  try{
    // Vincula y executa
    if($query->execute($insertTask)) {
        return $conn->lastInsertId();
    }
  }catch(Exception $e){
    return $e->getMessage();
  }
}

function getTask($conn, $id){
  $taskSQL = "SELECT * FROM tareas WHERE id=:id";
  $query = $conn->prepare($taskSQL);
  // Especificamos el fetch mode antes de llamar a fetch()
  $query->setFetchMode(PDO::FETCH_ASSOC);
  // Ejecutamos
  $query->execute([':id' => $id]);
  // Mostramos los resultados
  $tasks = $query->fetchAll();

  if(count($tasks) === 0){
    return null;
  }

  return $tasks[0];
}

function getTaskList($conn){
  $tasksSQL = "SELECT * FROM tareas ORDER BY title ASC, category ASC";
  $query = $conn->prepare($tasksSQL);
  // Especificamos el fetch mode antes de llamar a fetch()
  $query->setFetchMode(PDO::FETCH_ASSOC);
  // Ejecutamos
  $query->execute();
  // retornamos los resultados de la base de datos según la consulta SQL y los devolvemos directamente
  return $query->fetchAll();
}
  
function editTask($conn, $taskData, $id){
  $updateTask = [
    ':title' => $taskData['title'],
    ':category' => $taskData['category'],
    ':description' => $taskData['description'],
    ':updated_at' => (new DateTime())->format('Y-m-d H:i:s'),
    ':id' => $id
  ];
  
  $updateSQL = "UPDATE tareas SET title=:title, category=:category, description=:description, updated_at=:updated_at WHERE id=:id";
  //le decimos a PDO que prepare la consulta de $insertSQL para su uso posterior
  $query = $conn->prepare($updateSQL);
  
  try{
    // Vincula y executa
    if($query->execute($updateTask)) {
        return $id;
    }
  }catch(Exception $e){
    return null;
  }
}

function deleteTask($conn, $id){
  $deleteTask = [
    ':id' => $id
  ];
  
  $deleteSQL = "DELETE FROM tareas WHERE id=:id";
  //le decimos a PDO que prepare la consulta de $insertSQL para su uso posterior
  $query = $conn->prepare($deleteSQL);
  
  try{
    // Vincula y executa
    if($query->execute($deleteTask)) {
      return $query->rowCount();
    }
  }catch(Exception $e){
    return 0;
  }
}