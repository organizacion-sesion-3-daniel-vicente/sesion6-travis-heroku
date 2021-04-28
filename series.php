<?php

// Modelo de objetos que se corresponde con la tabla de MySQL
class Serie extends \Illuminate\Database\Eloquent\Model
{
    public $timestamps = false;
}

/* Obtención de la lista de series */

$app->get('/series', function ($req, $res, $args) {

    // Creamos un objeto collection + json con la lista de series

    // Obtenemos la lista de series de la base de datos y la convertimos del formato Json (el devuelto por Eloquent) a un array PHP
    $seriess = json_decode(\Serie::all());

    // Mostramos la vista
    return $this->view->render($res, 'serielist_template.php', [
        'items' => $seriess
    ]);
})->setName('series');


/*  Obtención de una serie en concreto  */
$app->get('/series/{name}', function ($req, $res, $args) {

    // Creamos un objeto collection + json con la serie pasada como parámetro

    // Obtenemos la serie de la base de datos a partir de su id y la convertimos del formato Json (el devuelto por Eloquent) a un array PHP
    $p = \Serie::find($args['name']);
    $seriess = json_decode($p);

    // Mostramos la vista
    return $this->view->render($res, 'serie_template.php', [
        'item' => $seriess
    ]);

});

//Borrar serie
$app->delete('/series/{name}', function ($req, $res, $args) {
    //Le pasamos la variable para que la encuentre
    $seriess = Serie::find($args['name']);
    //Borramos la serie encontrada
    $seriess->delete();
});

//Guardar nueva pelicula
$app->post('/series', function ($req, $res, $args)  {
    $template = $req->getParsedBody();

    $datos = $template['template']['data'];
    //longitud del vector
    $longitud = count($datos);
    //bucle que recorre vector
    for ($i = 0; $i < $longitud; $i++)
    {
        switch($datos[$i]['name'])
        {
        case "name":
            $name = $datos[$i]['value'];
            break;
        case "description":
            $description = $datos[$i]['value'];
            break;
        case "director":
            $director = $datos[$i]['value'];
            break;
        case "embedUrl":
            $embedUrl = $datos[$i]['value'];
            break;
        case "datePublished":
            $datePublished = $datos[$i]['value'];
            break;
        }
    }
    $nueva_serie = new Movie;
    $nueva_serie['name'] = $name;
    $nueva_serie['description'] = $description;
    $nueva_serie['director'] = $director;
    $nueva_serie['datePublished'] = $datePublished;
    $nueva_serie['embedUrl'] = $embedUrl;

    $nueva_serie->save();
});
//Actualizar pelicula
$app->put('/series/{id}', function ($req, $res, $args) {
    $template = $req->getParsedBody();
    $datos = $template['template']['data'];
    //longitud del vector
    $longitud = count($datos);
    //bucle que recorre vector
    for ($i = 0; $i < $longitud; $i++)
    {
        switch($datos[$i]['name'])
        {
        case "name":
            $name = $datos[$i]['value'];
            break;
        case "description":
            $description = $datos[$i]['value'];
            break;
        case "director":
            $director = $datos[$i]['value'];
            break;
        case "embedUrl":
            $embedUrl = $datos[$i]['value'];
            break;
        case "datePublished":
            $datePublished = $datos[$i]['value'];
            break;
        }
    }

    $nueva_serie = Serie::find($args['id']);
    $nueva_serie['name'] = $name;
    $nueva_serie['description'] = $description;
    $nueva_serie['director'] = $director;
    $nueva_serie['embedUrl'] = $embedUrl;
    $nueva_serie['datePublished'] = $datePublished;

    $nueva_serie->save();

});

?>
