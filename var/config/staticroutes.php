<?php 

return [
    1 => [
        "id" => 1,
        "name" => "breeding-detail",
        "pattern" => "/\\/breeding\\/(.*)/",
        "reverse" => "/breeding/%id",
        "controller" => "App\\Controller\\BreedingController::detailAction",
        "variables" => "id",
        "defaults" => NULL,
        "siteId" => [

        ],
        "methods" => NULL,
        "priority" => 0,
        "creationDate" => 1649528980,
        "modificationDate" => 1649530679
    ],
    2 => [
        "id" => 2,
        "name" => "available-detail",
        "pattern" => "/\\/available\\/(.*)/",
        "reverse" => "/available/%id",
        "controller" => "App\\Controller\\DefaultController::detailAction",
        "variables" => "id",
        "defaults" => NULL,
        "siteId" => [

        ],
        "methods" => NULL,
        "priority" => 0,
        "creationDate" => 1649531011,
        "modificationDate" => 1649531273
    ]
];
