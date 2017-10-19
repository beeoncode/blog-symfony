<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class ExceptionController extends Controller
{

    public function indexAction(){

        $response = new Response(null,404);
        return $this->render('security/error404.html.twig', [
            'status_text'=> 'Not Found',
        ],$response);

    }

}