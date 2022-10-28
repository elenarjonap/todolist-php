<?php
//obtenemos el body de la petición (función creada por nosotros)
$taskData = getRequestBody();

//Si no es un array lo que llega en el body cortamos ejecución, no han llegado datos en el body
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

//partimos la ruta para extraer recurso + id de la tarea que se quiere acceder
$uriParts = explode('/',substr($uri,1));

//si la ruta no tiene 2 framentos (recurso + id) no ejecuta el código dentro del if
if($uriParts[0] === 'task' && count($uriParts) === 2){
    //editamos el usuario, si todo va bien tenemos el id de la tarea, en caso contrario un null
    $id = editTask($conn, $taskData, $uriParts[1]);

    //si no se ha editado la tarea devolvemos un error
    if(!$id){
        //devolvemos un error
        http_response_code(400);
        echo '{"message": "No se ha podido actualizar la tarea, revisa los datos enviados"}';
        return;
    }

    //obtenemos los datos de la tarea
    $task = getTask($conn, $id);

    //devolvemos la respuesta con código 200 + json con datos de la tarea
    http_response_code(200);
    echo json_encode($task);
}