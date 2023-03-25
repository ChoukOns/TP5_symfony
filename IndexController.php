<?php 
namespace App\Controller; 
use App\Entity\Article;
use App\Form\ArticleType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response; 
use Symfony\Component\HttpFoundation\Request; 
use Symfony\Component\Routing\Annotation\Route; 
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method; 
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController; 
use Symfony\Component\Form\Extension\Core\Type\TextType; 
use Symfony\Component\Form\Extension\Core\Type\SubmitType; 



class IndexController extends AbstractController 
{ 
    /** 
      *@Route("/article/save") 
    */ 

    public function save(EntityManagerInterface$entityManager):Response { 
       
      $article = new Article(); 
      $article->setNom('Article3 '); 
      $article->setPrix(3000); 
      $entityManager->persist($article);
       $entityManager->flush();
        return new Response('Article enregisté avec id '.$article->getId()); 
      }

    /** 
      *@Route("/",name="article_list") 
    */
    public function home(EntityManagerInterface$entityManager) 
    {  
       $articles= $entityManager->getRepository(Article::class)->findAll(); 
      return $this->render('articles/index.html.twig',['articles'=> $articles]); 
    }


    /** 
      * * @Route("/article/new", name="new_article") 
      * * Method({"GET", "POST"})
    */ 
    public function new(EntityManagerInterface$entityManager ,Request $request) { 
      $article = new Article(); 
      $form = $this->createForm(ArticleType::class,$article); 
      $form->handleRequest($request); 
      if($form->isSubmitted() && $form->isValid()) 
      { 
        $article = $form->getData();  
        $entityManager->persist($article); $entityManager->flush(); 
        return $this->redirectToRoute('article_list'); 
      } 
      return $this->render('articles/new.html.twig',['form' => $form->createView()]);

    }

    /** 
      * @Route("/article/{id}", name="article_show") 
    */ 
    public function show(EntityManagerInterface$entityManager,$id) { 
      $article = $entityManager->getRepository(Article::class)
        ->find($id);
      return $this->render('articles/show.html.twig', array('article' => $article)); 
    }

    /** 
      * @Route("/article/edit/{id}", name="edit_article") * Method({"GET", "POST"}) 
    */
    public function edit(EntityManagerInterface$entityManager,Request $request, $id) { 
      $article = new Article(); 
      $article = $entityManager->getRepository(Article::class)->find($id); 
      $form = $this->createForm(ArticleType::class,$article); 
      $form->handleRequest($request); 
      if($form->isSubmitted() && $form->isValid()) 
      {  
        $entityManager->flush(); return $this->redirectToRoute('article_list'); 
      } 
      return $this->render('articles/edit.html.twig', ['form' =>$form->createView()]);
    }

    /** 
      * @Route("/article/delete/{id}",name="delete_article") * @Method({"DELETE"})
    */
    public function delete(EntityManagerInterface$entityManager ,Request $request, $id) { 
      $article = $entityManager->getRepository(Article::class)->find($id); 
      $entityManager->remove($article); 
      $entityManager->flush(); 
      $response = new Response(); 
      $response->send(); 
      return $this->redirectToRoute('article_list'); }

}