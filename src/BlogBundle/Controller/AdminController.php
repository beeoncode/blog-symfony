<?php

namespace BlogBundle\Controller;

use BlogBundle\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Cookie;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;


/**
 * Admin controller.
 *
 */
class AdminController extends Controller
{
    /**
     * @Route("/admin/",name="admin_index")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $posts = $em->getRepository('BlogBundle:Post')->findAll();
        return $this->render('post/index.html.twig', array(
            'posts' => $posts
        ));
    }

    /**
     * Creates a new post entity.
     * @Route("/admin/post/new/",name="admin_new")
     */
    public function newAction(Request $request)
    {
        $post = new Post();
        $form = $this->createForm('BlogBundle\Form\PostType', $post);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $post->setDate(New \DateTime('now'));
            $post->setStatus(1);
            $em->persist($post);
            $em->flush();
            return $this->redirectToRoute('admin_index', array('id' => $post->getId()));
        }

        return $this->render('post/new.html.twig', array(
            'post' => $post,
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing post entity.
     * @Route("/admin/post/{id}/edit/",name="admin_edit", requirements={"id": "\d+"})
     */
    public function editAction(Request $request, Post $post)
    {
        $editForm = $this->createForm('BlogBundle\Form\PostType', $post);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_edit', array('id' => $post->getId()));
        }

        return $this->render('post/edit.html.twig', array(
            'post' => $post,
            'edit_form' => $editForm->createView(),
        ));
    }    
}
