<?php

return [
    // Register link wizard
    'wizard_sys25imagemap' => [
        'path' => '/wizard/link/sys25imagemap',
        'target' => \Sys25\ImageMapWizard\Wizard\ImageMapWizardController::class . '::mainAction'
    ],

];