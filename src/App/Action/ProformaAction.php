<?php

namespace App\Action;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface as ServerMiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Expressive\Template\TemplateRendererInterface;

class ProformaAction implements  ServerMiddlewareInterface
{

    protected $template;

    public function __construct(TemplateRendererInterface $template)
    {
        $this->template = $template;
    }

    /**
     * Process an incoming server request and return a response, optionally delegating
     * to the next middleware component to create the response.
     *
     * @param ServerRequestInterface $request
     * @param DelegateInterface $delegate
     *
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        try {
            $data = $request->getParsedBody();

            if(empty($data['key'])){
                throw new \RuntimeException('key paramentr is required', 404);            }


            $part = $this->template->render('app-partial::pr', array('value' => $data['key']));
            return new JsonResponse(['ask' => time(), 'proforma' => $part]);
        }catch (\Exception $e){

            $return = [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
            return new JsonResponse($return, $e->getCode());
        }


    }
}
