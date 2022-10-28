<?php

// La petición está usando el verbo GET
if($uri === '/tasks'){
    //obtiene el listado de usuarios y guarda en tasks
    $tasks = getTaskList($conn);

    //devolvemos la respuesta con código 200 + json con datos de los usuarios
    http_response_code(200);
    echo json_encode($tasks);
    return;
}

//partimos la ruta para extraer recurso + id del usuario que se quiere acceder
$uriParts = explode('/',substr($uri,1));

//si la ruta no tiene 2 framentos (recurso + id) no ejecuta el código dentro del if
if($uriParts[0] === 'task' && count($uriParts) === 2){
    //obtiene la información del usuario y guarda en $user
    $task = getTask($conn, $uriParts[1]);

    //si no se encuentra el usuario devuelve error 404
    if(!$task){
        //devolvemos un error
        http_response_code(404);
        echo '{"message": "La tarea no existe"}';
        return;
    }

    //devolvemos la respuesta con código 200 + json con datos del usuario
    http_response_code(200);
    echo json_encode($task);
    return;
}