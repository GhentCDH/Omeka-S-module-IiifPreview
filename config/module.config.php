<?php declare(strict_types=1);

namespace IiifPreview;

return [
    'view_manager' => [
        'template_path_stack' => [
            dirname(__DIR__) . '/view',
        ],
    ],
    'view_helpers' => [
        'factories' => [
            'IiifPreview' => Service\ViewHelper\IiifPreviewFactory::class,
        ],
    ],
    'form_elements' => [
        'factories' => [
            Form\ConfigForm::class => Service\Form\ConfigFormFactory::class,
        ],
    ],
    'iiifpreview' => [
        'config' => [
            'iiifpreview_viewer' => 'universalviewer'
        ],
    ],
];
