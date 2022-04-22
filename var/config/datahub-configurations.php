<?php

return [
    "folders" => [

    ],
    "list" => [
        "test" => [
            "general" => [
                "active" => TRUE,
                "type" => "dataImporterDataObject",
                "name" => "test",
                "description" => "",
                "path" => NULL
            ],
            "loaderConfig" => [
                "type" => "asset",
                "settings" => [
                    "assetPath" => "/Measurements/measurements-10.csv"
                ]
            ],
            "interpreterConfig" => [
                "type" => "csv",
                "settings" => [
                    "skipFirstRow" => TRUE,
                    "delimiter" => ";",
                    "enclosure" => "\"",
                    "escape" => "\\"
                ]
            ],
            "resolverConfig" => [
                "elementType" => "dataObject",
                "dataObjectClassId" => "Measurement",
                "loadingStrategy" => [
                    "type" => "notLoad"
                ],
                "createLocationStrategy" => [
                    "type" => "staticPath",
                    "settings" => [
                        "path" => "/Measurement-upload/2022-04-18"
                    ]
                ],
                "locationUpdateStrategy" => [
                    "type" => "noChange"
                ],
                "publishingStrategy" => [
                    "type" => "alwaysPublish"
                ]
            ],
            "processingConfig" => [
                "executionType" => "sequential",
                "idDataIndex" => "4",
                "cleanup" => [
                    "strategy" => "unpublish"
                ]
            ],
            "mappingConfig" => [
                [
                    "label" => "weight [5]",
                    "dataSourceIndex" => [
                        "5"
                    ],
                    "transformationResultType" => "numeric",
                    "dataTarget" => [
                        "type" => "direct",
                        "settings" => [
                            "fieldName" => "weight",
                            "language" => ""
                        ]
                    ],
                    "transformationPipeline" => [
                        [
                            "type" => "numeric"
                        ]
                    ]
                ],
                [
                    "label" => "unit [6]",
                    "dataSourceIndex" => [
                        "7"
                    ],
                    "transformationResultType" => "default",
                    "dataTarget" => [
                        "type" => "direct",
                        "settings" => [
                            "fieldName" => "unit",
                            "language" => ""
                        ]
                    ],
                    "transformationPipeline" => [

                    ]
                ],
                [
                    "label" => "product",
                    "dataSourceIndex" => [
                        "5"
                    ],
                    "settings" => [
                        "loadStrategy" => "id",
                        "attributeDataObjectClassId" => "",
                        "attributeName" => "",
                        "attributeLanguage" => ""
                    ],
                    "transformationResultType" => "dataObject",
                    "dataTarget" => [
                        "type" => "direct",
                        "settings" => [
                            "fieldName" => "product",
                            "language" => ""
                        ]
                    ],
                    "transformationPipeline" => [
                        [
                            "settings" => [
                                "loadStrategy" => "id",
                                "attributeDataObjectClassId" => "",
                                "attributeName" => "",
                                "attributeLanguage" => ""
                            ],
                            "type" => "loadDataObject"
                        ]
                    ]
                ]
            ],
            "executionConfig" => [
                "cronDefinition" => ""
            ],
            "workspaces" => [

            ]
        ],
        "Measurement" => [
            "general" => [
                "active" => TRUE,
                "type" => "dataImporterDataObject",
                "name" => "Measurement",
                "description" => "",
                "path" => NULL
            ],
            "loaderConfig" => [
                "type" => "asset",
                "settings" => [
                    "assetPath" => "/Measurements/measurements-10.csv"
                ]
            ],
            "interpreterConfig" => [
                "type" => "csv",
                "settings" => [
                    "skipFirstRow" => TRUE,
                    "delimiter" => ";",
                    "enclosure" => "\"",
                    "escape" => "\\"
                ]
            ],
            "resolverConfig" => [
                "elementType" => "dataObject",
                "dataObjectClassId" => "Measurement",
                "loadingStrategy" => [
                    "type" => "notLoad"
                ],
                "createLocationStrategy" => [
                    "type" => "staticPath",
                    "settings" => [
                        "path" => "/Measurement-upload/2022-04-18"
                    ]
                ],
                "locationUpdateStrategy" => [
                    "type" => "noChange"
                ],
                "publishingStrategy" => [
                    "type" => "alwaysPublish"
                ]
            ],
            "processingConfig" => [
                "executionType" => "sequential",
                "idDataIndex" => "4",
                "cleanup" => [
                    "strategy" => "unpublish"
                ]
            ],
            "mappingConfig" => [
                [
                    "label" => "weight [5]",
                    "dataSourceIndex" => [
                        "5"
                    ],
                    "transformationResultType" => "numeric",
                    "dataTarget" => [
                        "type" => "direct",
                        "settings" => [
                            "fieldName" => "weight",
                            "language" => ""
                        ]
                    ],
                    "transformationPipeline" => [
                        [
                            "type" => "numeric"
                        ]
                    ]
                ],
                [
                    "label" => "unit [6]",
                    "dataSourceIndex" => [
                        "7"
                    ],
                    "transformationResultType" => "default",
                    "dataTarget" => [
                        "type" => "direct",
                        "settings" => [
                            "fieldName" => "unit",
                            "language" => ""
                        ]
                    ],
                    "transformationPipeline" => [

                    ]
                ],
                [
                    "label" => "product",
                    "dataSourceIndex" => [
                        "5"
                    ],
                    "settings" => [
                        "loadStrategy" => "id",
                        "attributeDataObjectClassId" => "",
                        "attributeName" => "",
                        "attributeLanguage" => ""
                    ],
                    "transformationResultType" => "dataObject",
                    "dataTarget" => [
                        "type" => "direct",
                        "settings" => [
                            "fieldName" => "product",
                            "language" => ""
                        ]
                    ],
                    "transformationPipeline" => [
                        [
                            "settings" => [
                                "loadStrategy" => "id",
                                "attributeDataObjectClassId" => "",
                                "attributeName" => "",
                                "attributeLanguage" => ""
                            ],
                            "type" => "loadDataObject"
                        ]
                    ]
                ]
            ],
            "executionConfig" => [
                "cronDefinition" => ""
            ],
            "workspaces" => [

            ]
        ]
    ]
];
