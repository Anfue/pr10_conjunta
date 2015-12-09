<html>
    <head>
        <title>Practica 10</title>
        <link rel="stylesheet" href="css/CSSpr10.css">
        <style>
            a, a:hover{
                text-decoration: none;
                color: black;
            }
        </style>
    </head>
    <span><u>Bienvenidos al mi repositorio</u></span>
    <br/>
</html>

<?php
        
    include_once 'curl.php'; //incluimos el archivo donde esta la funcion get

    //Generamos el JSON_DECODE
    $Token = '1924b59303bf7dd7ad5bc5fd81f2d81501557082'; //metemos nuestro token 
    $Url = 'https://api.github.com/user/repos'; //añadimos la api al repositorio de github
    $Crud = new curl; // aqui creamos un nuevo objeto llamado curl
    $a = $Crud -> get($Url, $Token); //generamos un get para recoger el valor y lo metemos en una array $a
    $Resultado_Json = (json_decode($a)); // codifica el contenido de tu repositorio y lo convietre en json 
    //print_r($resultado_json);   
    
    $NombreUsuario='ricardlafuente';//añadimos nuestro ususario de github


    //recorremos el json y sacamos el NAME de todos los repositorios
    //ponemos un link a todos 
    if((isset($_REQUEST['repositorio']))){ //miramos si repositorio existe, si existe seguimos sino salta al else y lo crea
        echo '<h2>'.$_REQUEST['repositorio'].'</h2>';// ponemos el titulo del repositorio tipo h2
        echo '<h2>'.$_REQUEST['user'].'</h2>'; // numbre usuario tipo h2
        //----------------------------------------------------------------//
        //listaremos los commits de un repositorio
        //GET /repos/:owner/:repo/commits
        $Url_Commits='https://api.github.com/repos/'.$_REQUEST['user'].'/'.$_REQUEST['repositorio'].'/commits'; //esto nos marca cuando se actualizamos el comits
        $a = $Crud -> get($Url_Commits, $Token);//generamos un get para recoger el valor y lo metemos en una array $a
        $Resultado_Json = (json_decode($a)); // codifica el contenido de la array guardada y lo convietre en json 
        print_r($resultado_json);
        
        foreach($Resultado_Json as $Repositorio){//son estructuras de dentro de cada array, y esto son actualizaciones del nombre, data y mensage
            echo '<br>AUTOR: '.$Repositorio->commit->author->name; //estos datos estan encriptadosn en Json
            echo '<br>FECHA: '.$Repositorio->commit->committer->date;//y se ponen los que se desean
            echo '<br>TITULO: '.$Repositorio->commit->message;
            echo '<br>';
        }
    //----------------------------------------------------------------//
        //GET /repos/:owner/:repo/readme
        //sacas los datos de readme si existe, sino no saldrá nada.
        $Url_Readme='https://api.github.com/repos/'.$_REQUEST['user'].'/'.$_REQUEST['repositorio'].'/readme';
        $a = $Crud -> get($Url_Readme, $Token);//generamos un get para recoger el valor y lo metemos en una array $a
        $Resultado_Json2 = (json_decode($a));//guardamos la url donde esta el readme en $Resultado_Json2
        //print_r($resultado_json2);

        if (isset($Resultado_Json2->content)){ //preguntamos si tiene contenido $Resultado_Json2
              echo base64_decode($Resultado_Json2->content); //si existe conteniido el readme lo muestra
        }
 
    //----------------------------------------------------------------//
        
    }
    else //si no existe el repositorio lo creamos
    {
        foreach($Resultado_Json as $Repositorio){
            if ($Repositorio->owner->login == $NombreUsuario){
                echo '<a href="?repositorio='.$Repositorio->name.'&user='.$Repositorio->owner->login.'">'.$Repositorio->name.'<a/>';

            }
            echo '<br>';
        }
    }
?>
