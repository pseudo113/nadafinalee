<?php
/**
 * Created by PhpStorm.
 * User: mzark
 * Date: 19/02/2018
 * Time: 14:13
 */

namespace nadaBundle\Controller;

use nadaBundle\Entity\Classe;
use nadaBundle\Form\ClasseType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ClasseController extends Controller
{
    /**
     * @Route("/add_classe",name="add_classe")
     */
    public function addClasseAction(Request $request)
    {
        $user = $this->getUser();
        if (!is_object($user) ) {
            return $this->redirectToRoute('fos_user_security_login');
        }
        $id =  $this->getUser()->getId();

        $classe = new Classe();
        $em=$this->getDoctrine()->getManager();
        $reno=$em->getRepository("nadaBundle:User")->findOneBy(array('id' => $id ));

        $user = $em->getRepository('nadaBundle:User')->findOneBy(array('id' => $id ));
        $form = $this->createForm(ClasseType::class,$classe );
        $form->handleRequest($request);
        if($form->isSubmitted() ) {
            $classe->setIdUser($user);
            $em->persist( $classe);
            $em->flush();
            return $this->redirect($this->generateUrl('show_classe',array('msg'=>"add successful")));
        }
        return $this->render('@nada/Classe/addClasse.html.twig',array(
            'form'=>$form->createView(),
            'user'=>$user,
            'userf'=>$reno
        ));
    }

    /**
     * @Route("/show_classe",name="show_classe")
     */
    public function show_classeAction () {
        $user = $this->getUser();
        if (!is_object($user) ) {
            return $this->redirectToRoute('fos_user_security_login');
        }
        $id =  $this->getUser()->getId();
        $em=$this->getDoctrine()->getManager();
        $Profile = $em->getRepository('nadaBundle:User')->findOneBy(array('id' => $id ));
        $classe = $em->getRepository('nadaBundle:Classe')->findAll();
        $count=count($classe);

        return $this->render('@nada/Classe/showClasse.html.twig',array(
            'classe'=>$classe,
            'userf'=>$Profile,
            "count"=>$count,

        ));
    }
    /**
     * @Route("/delete_classe/{id}",name="delete_classe")
     */
    public function delete_classeAction($id)
    {
        $user = $this->getUser();
        if (!is_object($user) ) {
            return $this->redirectToRoute('fos_user_security_login');
        }
        $em=$this->getDoctrine()->getManager();
        $classe = $em->getRepository('nadaBundle:Classe')->findOneBy(array('id' => $id ));
        $em->remove( $classe);
        $em->flush();
        return $this->redirect($this->generateUrl('show_classe',array('msg'=>"Delete successful")));
    }


}