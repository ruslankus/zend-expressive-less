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
    protected $headers = [];

    public function __construct(TemplateRendererInterface $template)
    {
        $login = 'ruslan';
        $pass = '123456';
        $this->template = $template;
        $this->headers[] = 'Authorization: Basic ' . base64_encode($login . ":" . $pass);
        $this->headers[] = 'Content-type: application/json';
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


            $part = $this->template->render('app-partial::proforma', array('value' => $data['key']));

            $proforma = $this->getProformaPdf($part);

            return new JsonResponse(['ask' => time(), 'pakedPdf' => $proforma]);
        }catch (\Exception $e){

            $return = [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
            return new JsonResponse($return, $e->getCode());
        }


    }


    protected function getProformaPdf($html)
    {
        $postData['contents'] = base64_encode($html);
        $pdfData = $this->generatePdf($postData);

        return $pdfData;
    }

    public function generatePdf($postData)
    {
        $fullRoute = '172.18.0.1:8888';
        //downloading
        $postVars = json_encode($postData);
        $process = curl_init($fullRoute);
        curl_setopt($process,CURLOPT_POST, 1);                //0 for a get request
        curl_setopt($process,CURLOPT_POSTFIELDS,$postVars);
        curl_setopt($process, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($process, CURLOPT_HTTPHEADER, $this->headers);
        $data = curl_exec($process);
        curl_close($process);
        return $data;
    }
}
