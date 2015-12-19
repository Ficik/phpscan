<?php
/**
 * @author: Stanislav Fifik <stanislav.fifik@designeo.cz>
 */
namespace PhpScan;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';

$app = new \Slim\App;

$config = parse_ini_file("../config.ini");

$sane = new Sane($config['device']);

function validate($value, $valid_options){
    foreach ($valid_options as $valid) {
        if ($value == $valid)
            return $valid;
    }
    throw new \HttpException("Invalid argument", 400);
}

$app->get('/preview', function (Request $request, Response $response) use ($sane) {
    $params = $request->getQueryParams();
    return $response->withRedirect(sprintf("/outputs/%s?%s",
        $sane->preview(array(
            '--mode=' . validate($params['mode'], ['Lineart', 'Gray', 'Color']))),
        floor(time())));
});

$app->get('/scan', function (Request $request, Response $response) use ($sane) {
    $filename = sprintf("Scan_%s.jpg", date("o-j-n_G:i:s"));
    $params = $request->getQueryParams();
    return $response->withRedirect(sprintf("/outputs/%s?%s",
        $sane->scan($filename, array(
            '--format=jpeg',
            '--mode=' . validate($params['mode'], ['Lineart', 'Gray', 'Color']),
            '--resolution=' . validate($params['resolution'], [75, 150, 300, 600, 1200]))),
        floor(time())));
});

$app->run();