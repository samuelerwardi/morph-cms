<?php

return [
    "bundle" => [
        "Pimcore\\Bundle\\DataHubBundle\\PimcoreDataHubBundle" => TRUE,
        "Pimcore\\Bundle\\DataImporterBundle\\PimcoreDataImporterBundle" => [
            "enabled" => TRUE,
            "priority" => 9,
            "environments" => [

            ]
        ]
    ]
];
