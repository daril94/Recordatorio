<?php
header('Content-Type: application/json');
$pdo = new PDO("mysql:dbname=recordatorio; host:127.0.0.1", "root", "");

$accion = (isset($_GET['accion'])) ? $_GET['accion'] : 'leer';

switch ($accion) {
    case 'agregar':
        $sentenciaSQL = $pdo->prepare("INSERT INTO 
        eventos(nombrePrograma, title, actividad, codigoDocumento, periodicidad, mesImplementacion, textColor, color, intervalo,start, end)
        VALUES (:nombrePrograma, :title, :actividad, :codigoDocumento, :periodicidad, :mesImplementacion, :textColor, :color, :intervalo,:start, :end)");

        $respuesta = $sentenciaSQL->execute(array(
            "nombrePrograma" => $_POST['nombrePrograma'],
            "title" => $_POST['title'],
            "actividad" => $_POST['actividad'],
            "codigoDocumento" => $_POST['codigoDocumento'],
            "periodicidad" => $_POST['periodicidad'],
            "mesImplementacion" => $_POST['mesImplementacion'],
            "textColor" => $_POST['textColor'],
            "color" => $_POST['color'],
            "intervalo" => $_POST['intervalo'],
            "start" => $_POST['start'],
            "end" => $_POST['end']

            /*
            "nombrePrograma" => "AAA",
            "title" => "AAA",
            "actividad" => "AAA",
            "codigoDocumento" =>"AAA",
            "periodicidad" => "AAA",
            "mesImplementacion" => "AAA",
            "textColor" => "#5a4e2c",
            "color" => "#ff00ff",
            "intervalo" => 7,
            "start" =>"2020-04-17",
            "end" => "2020-04-19",*/
        ));


        echo json_encode($respuesta);
        break;


    case 'eliminar':
        $resultado = false;

        if (isset($_POST['id'])) {
            $sentenciaSQL = $pdo->prepare("DELETE FROM eventos WHERE ID= :ID");
            $respuesta = $sentenciaSQL->execute(array("ID" => $_POST['id']));
        }
        echo json_encode($respuesta);
        break;


    case 'modificar':
        $sentenciaSQL = $pdo->prepare("UPDATE eventos SET 
        nombrePrograma=:nombrePrograma,
        title=:title,
        actividad=:actividad,
        codigoDocumento=:codigoDocumento,
        periodicidad=:periodicidad,
        mesImplementacion=:mesImplementacion, 
        textColor=:textColor,
        color=:color,
        intervalo=:intervalo,
        start=:start,
        end=:end  
        WHERE ID=:ID");

        $respuesta = $sentenciaSQL->execute(array(
            "ID" => $_POST['id'],
            "nombrePrograma" => $_POST['nombrePrograma'],
            "title" => $_POST['title'],
            "actividad" => $_POST['actividad'],
            "codigoDocumento" => $_POST['codigoDocumento'],
            "periodicidad" => $_POST['periodicidad'],
            "mesImplementacion" => $_POST['mesImplementacion'],
            "textColor" => $_POST['textColor'],
            "color" => $_POST['color'],
            "intervalo" => $_POST['intervalo'],
            "start" => $_POST['start'],
            "end" => $_POST['end']

        ));
        echo json_encode($respuesta);
    break;

       
    default:
        // seleccionar eventos del calendario

        $sentenciaSQL = $pdo->prepare("SELECT *FROM eventos");
        $sentenciaSQL->execute();

        $resultado = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
        // datos json
        echo json_encode($resultado);
        break;
}
