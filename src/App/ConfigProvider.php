<?php

namespace App;

use App\Action\HomePageAction;
use App\Action\HomePageFactory;

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
                HomePageAction::class => HomePageFactory::class
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
                'app-partial' => ['templates/app/app-partial']
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
            ]
        ];

    }
}