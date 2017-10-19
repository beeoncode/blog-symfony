<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use BlogBundle\Entity\Post;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $RAW_QUERY = 'SELECT * FROM `post` WHERE post.status = 1';
        $statement = $em->getConnection()->prepare($RAW_QUERY);
        $statement->execute();
        $posts = $statement->fetchAll();

        /**
         * @var $paginator |Knp|Component|Pager|Paginator
         */
        $paginator  = $this->get('knp_paginator');
        $result = $paginator->paginate(
            $posts,
            $request->query->getInt('page',1),
            2

        );

        return $this->render('public/home.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'posts' => $result
        ]);
    }

    /**
     * @Route("/dashboard",name="dashboard")
     */
    public function DashboardAction()
    {
        $em = $this->getDoctrine()->getManager();
        
    }
}
