<?php

$routes = [
    [
        'GET', '/', function() use ($twig) {
            echo $twig->render('default.htm');
        }
    ]
];