<?php

// La petición está usando el verbo POST
  //ruta para creación de tarea
  if($uri === "/tasks"){
    //obtenemos el body de la petición (función creada por nosotros)
    $taskData = getRequestBody();
    if(!is_array($taskData)){
    //devolvemos un error
        http_response_code(400);
        echo '{"message": "Petición mal formada"}';
        return;
    }
    
    //validamos que exista el parámetro
    if(!key_exists('title',$taskData)){
        http_response_code(400);
        echo '{"message": "Specify task title"}';
        return;
    }
    
    //validamos que exista el parámetro
    if(!key_exists('category',$taskData)){
        http_response_code(400);
        echo '{"message": "Specify task category"}';
        return;
    }
    
    //validamos que exista el parámetro
    if(!key_exists('description',$taskData)){
        http_response_code(400);
        echo '{"message": "Specify task description"}';
        return;
    }

    //creamos el usuario
    $result = insertTask($conn, $taskData);
    //aquí deberíamos devolver un error si $result es null

    //obtenemos la info de la tarea anteriormente creada y guardamos en $task
    $task = getTask($conn, $result);

    //devolvemos la respuesta con código 201 + json con datos de la tarea
    http_response_code(201);
    echo json_encode($task);
    return;
  }