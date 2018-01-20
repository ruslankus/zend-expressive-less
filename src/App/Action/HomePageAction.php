<?php
 namespace App\Action;

 use Interop\Http\ServerMiddleware\DelegateInterface;
 use Interop\Http\ServerMiddleware\MiddlewareInterface as ServerMiddlewareInterface;
 use Psr\Http\Message\ResponseInterface;
 use Psr\Http\Message\ServerRequestInterface;
 use Zend\Diactoros\Response\JsonResponse;
 use Zend\Expressive\Router\RouterInterface;
 use Zend\Expressive\Template\TemplateRendererInterface;

 class HomePageAction implements  ServerMiddlewareInterface
 {
     private $template;

     public function __construct(TemplateRendererInterface $template)
     {
         $this->template = $template;
     }

     public function process(ServerRequestInterface $request, DelegateInterface $delegate)
     {
         $value = 'передоваеммый параметр';
         $part = $this->template->render('app-partial::pr',array('value' => $value));

         return new JsonResponse(['ask' => time(), 'proforma' => $part]);

     }
 }