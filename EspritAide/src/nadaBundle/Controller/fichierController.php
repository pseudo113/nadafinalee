<?php
/**
 * Created by PhpStorm.
 * User: mzark
 * Date: 20/02/2018
 * Time: 14:50
 */

namespace nadaBundle\Controller;

use nadaBundle\Entity\archivefichier;
use nadaBundle\Entity\fichier;
use nadaBundle\Form\fichierType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class fichierController extends Controller
{
    /**
     * @Route("/add_fichier",name="add_fichier")
     */
    public function addClasseAction(Request $request)
    {
        $user = $this->getUser();
        if (!is_object($user) ) {
            return $this->redirectToRoute('fos_user_security_login');
        }
        $id =  $this->getUser()->getId();

        $fichier = new fichier();
        $em=$this->getDoctrine()->getManager();
        $reno=$em->getRepository("nadaBundle:User")->findOneBy(array('id' => $id ));

        $user = $em->getRepository('nadaBundle:User')->findOneBy(array('id' => $id ));
        $form = $this->createForm(fichierType::class,$fichier );
        $form->handleRequest($request);
        if($form->isSubmitted() ) {
            $fichier->setIdUser($user);
            $em->persist($fichier);
            $em->flush();
            return $this->redirect($this->generateUrl('show_fichier',array('msg'=>"add successful")));
        }
        return $this->render('@nada/fichier/addfichier.html.twig',array(
            'form'=>$form->createView(),
            'user'=>$user,
            'userf'=>$reno
        ));
    }

    /**
     * @Route("/show_fichier",name="show_fichier")
     */
    public function show_fichierAction()
    {
        $user = $this->getUser();
        if (!is_object($user) ) {
            return $this->redirectToRoute('fos_user_security_login');
        }
        $id =  $this->getUser()->getId();
        $em=$this->getDoctrine()->getManager();
        $Profile = $em->getRepository('nadaBundle:User')->findOneBy(array('id' => $id ));
        $fichier = $em->getRepository('nadaBundle:fichier')->findBy(array('id_user' => $id ));
        $count=count($fichier);

        return $this->render('@nada/fichier/showfichier.html.twig',array(
            'fichier'=>$fichier,
            'userf'=>$Profile,
            "count"=>$count,

        ));

    }
    /**
     * @Route("/show_fichier_all",name="show_fichier_all")
     */
    public function ALLshow_fichierAction()
    {
        $user = $this->getUser();
        if (!is_object($user) ) {
            return $this->redirectToRoute('fos_user_security_login');
        }
        $id =  $this->getUser()->getId();
        $em=$this->getDoctrine()->getManager();
        $Profile = $em->getRepository('nadaBundle:User')->findOneBy(array('id' => $id ));
        $fichier = $em->getRepository('nadaBundle:fichier')->findAll();
        $count=count($fichier);

        return $this->render('@nada/fichier/showfichier.html.twig',array(
            'fichier'=>$fichier,
            'userf'=>$Profile,
            "count"=>$count,

        ));

    }
    /**
     * @Route("/edit_fichier/{idx}",name="edit_fichier")
     */
    public function editClientAction(Request $request,$idx)
    {
        $user = $this->getUser();
        $id =  $this->getUser()->getId();
        $email = $this->getUser()->getemail();


        if (!is_object($user) ) {

            return $this->redirectToRoute('fos_user_security_login');
        }
        else {    $em=$this->getDoctrine()->getManager();

            $reno=$em->getRepository("nadaBundle:User")->findOneBy(array('id' => $id ));
            $list=$em->getRepository("nadaBundle:fichier")->findOneBy(array('id' => $idx));
            $form = $this->createForm(fichierType::class,$list );



            $form->handleRequest($request);

            if($form->isSubmitted() )
            {

                $em->persist($list);
                $em->flush();

                //
                return $this->redirect($this->generateUrl('show_fichier'));

            }


            return $this->render('@nada/fichier/editfichier.html.twig',
                array("userf"=>$reno,"form"=>$form->createView()));
        }

    }
    /**
     * @Route("/archive_fichier/{id}",name="archive_fichier")
     */
    public function archiveAction($id)
    {
        $user = $this->getUser();
        if (!is_object($user) ) {
            return $this->redirectToRoute('fos_user_security_login');
        }
        $em=$this->getDoctrine()->getManager();
        $fichier = $em->getRepository('nadaBundle:fichier')->findOneBy(array('id' => $id ));
        $archive = new archivefichier();
        $archive->setId($fichier->getId());
        $archive->setIdUser($fichier->getIdUser());
        $archive->setIdClasse($fichier->getIdClasse());
        $archive->setType($fichier->getType());
        $archive->setNom($fichier->getNom());
        $archive->setModule($fichier->getModule());
        $archive->setReDatecreation($fichier->getReDatecreation());
        $archive->setImageName($fichier->getImageName());
        $archive->setUpdatedAt($fichier->getUpdatedAt());

        $em->persist($archive);
        $em->remove( $fichier);
        $em->flush();
        return $this->redirect($this->generateUrl('nada_default_index',array('msg'=>"Delete successful")));
    }
    /**
     * @Route("/show_archived",name="show_archived")
     */
    public function show_archivedAction()
    {
        $user = $this->getUser();
        if (!is_object($user) ) {
            return $this->redirectToRoute('fos_user_security_login');
        }
        $id =  $this->getUser()->getId();
        $em=$this->getDoctrine()->getManager();
        $Profile = $em->getRepository('nadaBundle:User')->findOneBy(array('id' => $id ));
        $fichier = $em->getRepository('nadaBundle:archivefichier')->findAll();
        $count=count($fichier);

        return $this->render('@nada/fichier/showarichived.html.twig',array(
            'fichier'=>$fichier,
            'userf'=>$Profile,
            "count"=>$count,

        ));

    }

}