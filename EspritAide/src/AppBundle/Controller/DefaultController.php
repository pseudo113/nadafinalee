<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        $user = $this->getUser();
        $id =  $this->getUser()->getId();


        if (!is_object($user) ) {

            return $this->redirectToRoute('fos_user_security_login');
        }else {

            var_dump($id);

            $em=$this->getDoctrine()->getManager();
            $userf=$em->getRepository("nadaBundle:User")->findOneBy(array('id' => $id ));

            return $this->render('nadaBundle:Default:index.html.twig',array("userf"=>$userf,));
        }

    }
    /**
     * @Route("/accessDenied")
     */
    public function accessDeniedAction()
    {
        $user = $this->getUser();
        $id =  $this->getUser()->getId();
        $email = $this->getUser()->getemail();

        if (!is_object($user) ) {

            return $this->redirectToRoute('fos_user_security_login');
        }else {
            return $this->render('@nada/Default/401.html.twig');
        }

    }
    public function baseAction()
    {
        $user = $this->getUser();
        $id =  $this->getUser()->getId();
        $email = $this->getUser()->getemail();

        if (!is_object($user) ) {

            return $this->redirectToRoute('fos_user_security_login');
        }else {

            $em=$this->getDoctrine()->getManager();
            $userf=$em->getRepository("nadaBundle\\Entity\\User")->findOneBy(array('id' => $id ));

            return $this->render('base.html.twig',array("userf"=>$userf));
        }

    }
}
