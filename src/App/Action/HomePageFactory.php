<?php

namespace  App\Action;

use Psr\Container\ContainerInterface;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

class HomePageFactory
{
    public function __invoke(ContainerInterface $container)
    {
       $template = $container->get(TemplateRendererInterface::class);

       return new HomePageAction($template);
    }
}