<?php

namespace BlogBundle\Controller\Api;

use BlogBundle\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RestController extends Controller
{
    /**
     * @Route("/api/rest/")
     * @Method("GET")
     */
    public function listAction()
    {

        $quote = $this->getDoctrine()
            ->getRepository('BlogBundle:Post')
            ->findAll();
        $data = [];
        foreach ($quote as $key => $item){
            $data[$key]['id'] = $item->getId();
            $data[$key]['title'] = $item->getTitle();
        }

        return new Response(json_encode($data));
    }
    /**
     * @Route("/api/rest/{id}/")
     * @Method("GET")
     * @param $id
     */
    public function getAction($id = null)
    {
        $quote = $this->getDoctrine()
            ->getRepository('BlogBundle:Post')
            ->findOneBy(['id' => $id, 'status' => 1]);
        if(is_null($quote))
            return new Response(json_encode(['400 Bad Request']));

        $data = [
            'id' => $quote->getId(),
            'title' => $quote->getTitle(),
            'text' => $quote->getText(),
            'Date' => $quote->getDate(),
            'tags' => $quote->getTags(),
            'url' => $quote->getUrl(),
        ];

        return new Response(json_encode($data));
    }
}