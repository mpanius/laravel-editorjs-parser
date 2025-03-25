<?php

return [
    'config' => [
        'tools' => [
            'paragraph' => [
                'text' => [
                    'type' => 'string',
                    'allowedTags' => 'i,b,a[href],code[class],mark[class]',
                ],
            ],
            'header' => [
                'text' => [
                    'type' => 'string',
                    'allowedTags' => 'a[href],mark[class]',
                ],
                'level' => [1, 2, 3, 4, 5, 6],
            ],
            'list' => [
                // Если в JSON присутствует поле meta в data, оно описывается здесь:
                'meta' => [
                    'type' => 'array',
                    'data' => [
                        '-' => [
                            'type' => 'string',
                            'required' => false
                        ]
                    ], // нет вложенной структуры
                    'required' => false,
                ],
                // Поле style — строка, принимающая значения "ordered" или "unordered"
                'style' => [
                    'type' => 'string',
                    'allowed' => ['ordered', 'unordered'],
                ],
                // Поле items — массив элементов. Каждый элемент — это массив с тремя ключами:
                'items' => [
                    'type' => 'array',
                    'data' => [
                        '-' => [
                            'type' => 'array',
                            'data' => [
                                // Обязательное текстовое содержимое
                                'content' => [
                                    'type' => 'string',
                                    'required' => false

                                ],
                                'checked' => [
                                    'type' => 'boolean',
                                    'required' => false
                                ],
                                // Опциональное поле meta, если присутствует (как пустой массив)
                                'meta' => [
                                    'type' => 'array',
                                    'data' => [

                                        'checked' => [
                                            'type' => 'boolean',
                                            'required' => false
                                        ],


                                    ], // нет вложенной структуры
                                    'required' => false,
                                ],
                                // Опциональное поле items — для вложенных списков (если вдруг понадобятся)
                                'items' => [
                                    'type' => 'array',
                                    'data' => [

                                        '-' => [
                                            'type' => 'array',
                                            'data' => [
                                                'meta' => ['type' => 'array',
                                                    'data' => [
                                                        '-' => [
                                                            'checked' => [
                                                                'type' => 'boolean',
                                                                'required' => false
                                                            ]
                                                        ],
                                                    ],
                                                    'required' => false],
                                                'items' => [
                                                    'type' => 'array',
                                                    'data' => [],
                                                    'required' => false
                                                ],
                                                'content' => [
                                                    'type' => 'string',
                                                    'required' => false
                                                ],
                                            ],
                                            'required' => false,
                                        ]

                                    ], // нет вложенной структуры
                                    'required' => false,
                                ],

                            ],
                        ],
                    ],
                ],
            ],
            'linkTool' => [
                'link' => 'string',
                'meta' => [
                    'type' => 'array',
                    'data' => [
                        'title' => [
                            'type' => 'string',
                        ],
                        'description' => [
                            'type' => 'string',
                        ],
                        'url' => [
                            'type' => 'string',
                            'required' => false,
                        ],
                        'domain' => [
                            'type' => 'string',
                            'required' => false,
                        ],
                        'image' => [
                            'type' => 'array',
                            'required' => false,
                            'data' => [
                                'url' => [
                                    'type' => 'string',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            'image' => [
                'file' => [
                    'type' => 'array',
                    'data' => [
                        'width' => [
                            'type' => 'integer',
                            'required' => false,
                        ],
                        'height' => [
                            'type' => 'integer',
                            'required' => false,
                        ],
                        'media_id' => [
                            'type' => 'integer',
                            'required' => false,
                        ],
                        'url' => 'string',
                        'mime' => [
                            'type' => 'string',
                            'required' => false,
                        ],
                    ],
                ],
                'caption' => [
                    'type' => 'string',
                    'allowedTags' => 'i,b,a[href],code[class],mark[class]',
                ],
                'alt' => [
                    'type' => 'string',
                    'required' => false,
                ],
                'error' => [
                    'type' => 'string',
                    'required' => false,
                ],
                'link' => [
                    'type' => 'string',
                    'required' => false,
                ],
                'withBorder' => 'boolean',
                'withBackground' => 'boolean',
                'stretched' => 'boolean',
            ],
            'table' => [
                'withHeadings' => 'boolean',
                'stretched' => 'boolean',
                'content' => [
                    'type' => 'array',
                    'data' => [
                        '-' => [
                            'type' => 'array',
                            'data' => [
                                '-' => [
                                    'type' => 'string',
                                    'allowedTags' => 'i,b,a[href],code[class],mark[class]',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            'quote' => [
                'text' => [
                    'type' => 'string',
                    'allowedTags' => 'i,b,a[href],code[class],mark[class]',
                ],
                'caption' => [
                    'type' => 'string',
                    'allowedTags' => 'i,b,a[href],code[class],mark[class]',
                ],
                'alignment' => [
                    0 => 'left',
                    1 => 'center',
                ],
            ],
            'code' => [
                'code' => [
                    'type' => 'string',
                    'allowedTags' => '*',
                ],
            ],
            'delimiter' => [],
            'raw' => [
                'html' => [
                    'type' => 'string',
                    'allowedTags' => '*',
                ],
            ],
            'checklist' => [
                'items' => [
                    'type' => 'array',
                    'data' => [
                        '-' => [
                            'type' => 'array',
                            'data' => [
                                'text' => [
                                    'type' => 'string',
                                    'allowedTags' => 'i,b,a[href],code[class],mark[class]',
                                ],
                                'checked' => 'boolean',
                            ],
                        ],
                    ],
                ],
            ],
            // 'attaches'  => [
            //     'file'  => [
            //         'type' => 'array',
            //         'data' => [
            //             'url'       => 'string',
            //             'size'      => 'integer',
            //             'name'      => 'string',
            //             'extension' => 'string',
            //         ],
            //     ],
            //     'title' => 'string',
            // ]
            'embed' => [
                'service' => 'string',
                'source' => 'string',
                'embed' => 'string',
                'width' => 'integer',
                'height' => 'integer',
                'caption' => 'string',
            ],
        ],
    ],
];