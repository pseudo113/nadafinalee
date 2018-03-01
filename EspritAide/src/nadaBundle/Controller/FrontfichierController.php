<?php
/**
 * Created by PhpStorm.
 * User: mzark
 * Date: 23/02/2018
 * Time: 23:39
 */

namespace nadaBundle\Controller;


use nadaBundle\Entity\archivefichier;
use nadaBundle\Entity\Commentaire;
use nadaBundle\Entity\fichier;
use nadaBundle\Entity\User;
use nadaBundle\Form\CommentaireType;
use nadaBundle\Form\fichierType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class FrontfichierController extends Controller
{

    /**
     * @Route("/show_fichier_front",name="show_fichier_front")
     */
    public function front_show_fichierAction()
    {
        $user = $this->getUser();
        if (!is_object($user)) {
            return $this->redirectToRoute('fos_user_security_login');
        }
        $em = $this->getDoctrine()->getManager();
        $fichier = $em->getRepository('nadaBundle:fichier')->findAll();
        $count = count($fichier);

        return $this->render('@nada/fichier/showFrontCours.html.twig', array(
            'fichier' => $fichier,
            "count" => $count,

        ));

    }

    /**
     * @Route("/cours/{idx}",name="cours")
     */
    public function CoursAffichageAction($idx, Request $request)
    {
        $user = $this->getUser();
        $comment = new Commentaire();

        $id = $this->getUser()->getId();


        if (!is_object($user)) {

            return $this->redirectToRoute('fos_user_security_login');
        } else {

            $em = $this->getDoctrine()->getManager();

            $form = $this->createForm(CommentaireType::class, $comment);
            $listt = $em->getRepository("nadaBundle:fichier")->findOneBy(array('id' => $idx));
            $mail = $em->getRepository("nadaBundle:User")->findOneBy(array('id' => $listt->getIdUser()));

            $userr = $em->getRepository("nadaBundle:User")->findOneBy(array('id' => $id));

            $form->handleRequest($request);
            if ($form->isSubmitted()) {

                $comment->setIdUser($userr);
                $comment->setIdFichier($listt);
                $em->persist($comment);
                $em->flush();


                $mailLogger = new \Swift_Plugins_Loggers_ArrayLogger();
                $this->get('mailer')->registerPlugin(new \Swift_Plugins_LoggerPlugin($mailLogger));
                $message = \Swift_Message::newInstance()
                    ->setSubject('Nouveau Commentaire')
                    ->setFrom('drama.queen.nakate@gmail.com')
                    ->setTo('nada.aniba.1@esprit.tn')
                    ->setBody('<html>' . '<body>' . '<h2 style="color:#A6192E;">'
                        . 'Nouveau Commentaire' . '</h2>'
                        . '<p>' . 'Un nouveau commentaire sur le cours ' . $listt->getNom() . '<strong>' . $userr->getReNom() . '' . $userr->getRePrenom() . ' </strong>' . '</p>'
                        . '</body>' . '</html>', 'text/html');

# Send the message
                $this->get('mailer')->send($message);
                if ($this->get('mailer')->send($message)) {
                    echo '[SWIFTMAILER] sent email to ' . 'nada.aniba.1@esprit.tn';
                    echo '' . $mailLogger->dump();
                } else {
                    echo '[SWIFTMAILER] not sending email: ' . $mailLogger->dump();
                }


            }
            $comment = $em->getRepository("nadaBundle:Commentaire")->findBy(array('id_fichier' => $idx));

            return $this->render('@nada/fichier/showCoursFront.html.twig',
                array('form' => $form->createView(), "list" => $listt, "comment" => $comment, "user" => $userr));


        }
    }

    /**
     * @Route("/delete_comment/{id}",name="delete_comment")
     */
    public function delete_userAction($id)
    {
        $user = $this->getUser();
        $idx = $this->getUser()->getId();
        if (!is_object($user)) {
            return $this->redirectToRoute('fos_user_security_login');
        }
        $em = $this->getDoctrine()->getManager();
        $comment = $em->getRepository('nadaBundle:Commentaire')->findOneBy(array('id' => $id));



            $em->remove($comment);
            $em->flush();



        return $this->redirect($this->generateUrl('show_fichier_front', array('msg' => "Delete successful")));

    }
}





