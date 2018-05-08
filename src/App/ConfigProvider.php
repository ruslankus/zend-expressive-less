<?php

namespace App;

use App\Action\HomePageAction;
use App\Action\HomePageFactory;
use App\Action\ProformaAction;
use App\Action\ProformaFactory;

class ConfigProvider
{
    public function __invoke()
    {
       return [
           'dependencies' => $this->getDependencies(),
           'templates'    => $this->getTemplates(),
           'routes' => $this->getRoutes()
       ];
    }


    public function getDependencies()
    {
        return [
            'invokables' => [

            ],
            'factories'  => [
                HomePageAction::class => HomePageFactory::class,
                ProformaAction::class => ProformaFactory::class
            ]
        ];
    }

    public function getTemplates()
    {
        return [
            'paths' => [
                'app'  => ['templates/app'],
                'error'  => ['templates/error'],
                'layout' => ['templates/layout'],
                'app-partial' => ['templates/app/app-partial'],
                'proforma' => ['templates/app/proforma']
            ],
        ];
    }

    public function getRoutes() : array
    {
        return [
            [
                'name' => 'home',
                'path' => '/',
                'middleware' => HomePageAction::class,
                'allowed_methods' => ['GET']
            ],
            [
                'name' => 'ps',
                'path' => '/ps',
                'middleware' => ProformaAction::class,
                'allowed_methods' => ['POST']
            ]
        ];

    }
}