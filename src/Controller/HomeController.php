<?php
/**
 * Created by PhpStorm.
 * User: rajesh
 * Date: 12/2/18
 * Time: 11:00 PM
 */

namespace App\Controller;


use App\Entity\Post;
use App\Form\PostType;
use App\Form\EditPostType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends AbstractController
{
    /**
     * @Route("/", methods={"GET"}, name="home_page")
     */
    public function homeAction(){
        return $this->render('home.html.twig', array(
          'message'=>'Welcome Home!'
        ));
    }

    /**
     * @Route("/post/add", methods={"GET","POST"}, name="add_page")
     */
    public function addAction(Request $request): Response
    {
        $post = new Post();

        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $post = $form->getData();
            $now = new \DateTime('now');
            $post->setCreateDate($now);

            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();

            $this->addFlash('success', 'you have added a post!');

            return $this->redirectToRoute('add_page');
        }
        return $this->render('blog/add.html.twig', [
            'message' => 'Create Your Post',
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/post/view", methods={"GET"}, name="view_page")
     */
    public function viewAction(): Response
    {
        $posts = $this->getDoctrine()
            ->getRepository(Post::class)->findAll();


        return $this->render('blog/view.html.twig', array(
            'message'=>'Your Posts',
            'posts' => $posts,
        ));
    }

    /**
     * @Route("/post/details/{id}", methods={"GET"}, name="details_page")
     */
    public function detailsAction($id): Response
    {
        $postDetails = $this->getDoctrine()
            ->getRepository(Post::class)->find($id);

        return $this->render('blog/details.html.twig', array(
            'post' => $postDetails,
        ));
    }

    /**
     * @Route("/post/edit/{id}", methods={"GET","POST"}, name="edit_page")
     */
    public function editAction($id, Request $request): Response
    {
        $postToEdit = $this->getDoctrine()
            ->getRepository(Post::class)->find($id);

        $form = $this->createForm(EditPostType::class,$postToEdit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('info', 'post updated successfully');
            return $this->redirectToRoute('view_page');
        }

        return $this->render('blog/edit_new.html.twig', array(
            'message' => 'EDIT PAGE',
            'form' => $form->createView(),

        ));
    }



    /**
     * @Route("/post/delete/{id}", methods={"GET", "POST"}, name="post_edit")
     */
    public function deleteAction(Request $request, $id): Response
    {
        $postToDelete= $this->getDoctrine()
            ->getRepository(Post::class)->find($id);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($postToDelete);
        $entityManager->flush();

        $this->addFlash('danger', 'post Deleted!!');
        return $this->redirectToRoute('view_page');


    }

}
