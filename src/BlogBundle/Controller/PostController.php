<?php

namespace BlogBundle\Controller;

use BlogBundle\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;



/**
 * Post controller.
 *
 */
class PostController extends Controller
{

    /**
     * @Route("/post/",name="post_list")
     */
    public function postAction(Request $request)
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
     * Finds and displays a post entity.
     * @Route("/post/{id}/",name="post_show", requirements={"page": "\d+"})
     */
    public function showAction(Post $post)
    {

        return $this->render('public/details.html.twig', array(
            'post' => $post,
        ));
    }

    /**
     * @Route("/admin/status/{id}",name="status_change")
     * @Method("POST")
     */
    public function statusAction(Request $request)
    {
        $id = $request->get('id');
        $postt = new Post();
        $accessor = PropertyAccess::createPropertyAccessor();
        $em = $this->getDoctrine()->getManager();
        $posts = $em->getRepository('BlogBundle:Post')->findAll();
        $edited = $em->getRepository('BlogBundle:Post')->find($id);


        if ($accessor->getValue($edited, 'status') == '1'){
            $em = $this->getDoctrine()->getManager();
            $edited->setStatus('0');
            $em->persist($edited);
            $em->flush();
            return $this->render('post/index.html.twig', array(
                'posts' => $posts,
            ));
        }else if ($accessor->getValue($edited, 'status') == '0'){
            $em = $this->getDoctrine()->getManager();
            $edited->setStatus('1');
            $em->persist($edited);
            $em->flush();
            return $this->render('post/index.html.twig', array(
                'posts' => $posts,
            ));
        }

    }
}
