<?php
/**
 * Created by PhpStorm.
 * User: mzark
 * Date: 18/02/2018
 * Time: 20:35
 */

namespace nadaBundle\Controller;

use FOS\UserBundle\Form\Type\ChangePasswordFormType;
use nadaBundle\Entity\User;
use nadaBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Form\Factory\FactoryInterface;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\Routing\Annotation\Route;


class UserController extends Controller
{
    /**
     * @Route("/ProfileSettings", name="ProfileSettings")
     */
    public function profilSettingsAction(Request $request)
    {
        $user = $this->getUser();
        $id =  $this->getUser()->getId();
        $em=$this->getDoctrine()->getManager();
        $Profile = $em->getRepository(User::class)->findOneBy(array('id' => $id ));
        $form = $this->createForm(ChangePasswordFormType::class,$Profile );

        $form->handleRequest($request);
        if($form->isSubmitted() )
        {
            $em->persist($Profile);
            $em->flush();
            return $this->redirect($this->generateUrl('nada_default_index'));
        }
        /** @var $dispatcher EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');
        $event = new GetResponseUserEvent($user,$request);

        $dispatcher->dispatch(FOSUserEvents::CHANGE_PASSWORD_INITIALIZE, $event);
        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }
        /** @var $formFactory FactoryInterface */
        $formFactory = $this->get('fos_user.change_password.form.factory');
        $form = $formFactory->createForm();
        $form->setData($user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var $userManager UserManagerInterface */
            $userManager = $this->get('fos_user.user_manager');
            $event = new FormEvent($form, $request);
            $dispatcher->dispatch(FOSUserEvents::CHANGE_PASSWORD_SUCCESS, $event);
            $userManager->updateUser($user);
            if (null === $response = $event->getResponse()) {
                $url = $this->generateUrl('fos_user_security_logout');
                $response = new RedirectResponse($url);
            }
            //maill

            // $this->redirect('/logout');
            $dispatcher->dispatch(FOSUserEvents::CHANGE_PASSWORD_COMPLETED, new FilterUserResponseEvent($user, $request, $response));
            return $response;
        }
        return $this->render('@nada/pages/profile_user.html.twig',array(

            'userf'=>$Profile
        ));
    }

    /**
     * @Route("/user_list", name="User_list")
     */
    public function enseigantListAction( )
    {
        $user = $this->getUser();
        $id =  $this->getUser()->getId();
        $email = $this->getUser()->getemail();


        if (!is_object($user) ) {

            return $this->redirectToRoute('fos_user_security_login');
        }
        else {

            $em=$this->getDoctrine()->getManager();



            $reno=$em->getRepository("nadaBundle:User")->findOneBy(array('id' => $id ));
            $list=$em->getRepository("nadaBundle:User")->findAll();

            $count=count($list);



            return $this->render('@nada/pages/User_list.html.twig',
                array("list"=>$list,"userf"=>$reno,"count"=>$count));
        }

    }

    /**
     * @Route("/User_profil/{idx}",name="User_profil")
     */
    public function clientProfilAction($idx)
    {
        $user = $this->getUser();
        $id =  $this->getUser()->getId();


        if (!is_object($user) ) {

            return $this->redirectToRoute('fos_user_security_login');
        }
        else {    $em=$this->getDoctrine()->getManager();

            $reno=$em->getRepository("nadaBundle:User")->findOneBy(array('id' => $id ));
            $list=$em->getRepository("nadaBundle:User")->findOneBy(array('id' => $idx ));


            return $this->render('@nada/pages/User_profil.html.twig',array("list"=>$list,"userf"=>$reno));
        }

    }
    /**
     * @Route("/Edit", name="Edit")
     */
    public function EditAction(Request $request)
    {
        $user = $this->getUser();
        $id =  $this->getUser()->getId();
        $em=$this->getDoctrine()->getManager();
        $Profile = $em->getRepository(User::class)->findOneBy(array('id' => $id ));
        $form = $this->createForm(ChangePasswordFormType::class,$Profile );

        $form->handleRequest($request);
        if($form->isSubmitted() )
        {
            $em->persist($Profile);
            $em->flush();
            return $this->redirect($this->generateUrl('nada_default_index'));
        }
        /** @var $dispatcher EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');
        $event = new GetResponseUserEvent($user,$request);

        $dispatcher->dispatch(FOSUserEvents::CHANGE_PASSWORD_INITIALIZE, $event);
        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }
        /** @var $formFactory FactoryInterface */
        $formFactory = $this->get('fos_user.change_password.form.factory');
        $form = $formFactory->createForm();
        $form->setData($user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var $userManager UserManagerInterface */
            $userManager = $this->get('fos_user.user_manager');
            $event = new FormEvent($form, $request);
            $dispatcher->dispatch(FOSUserEvents::CHANGE_PASSWORD_SUCCESS, $event);
            $userManager->updateUser($user);
            if (null === $response = $event->getResponse()) {
                $url = $this->generateUrl('fos_user_security_logout');
                $response = new RedirectResponse($url);
            }
            //maill

            // $this->redirect('/logout');
            $dispatcher->dispatch(FOSUserEvents::CHANGE_PASSWORD_COMPLETED, new FilterUserResponseEvent($user, $request, $response));
            return $response;
        }
        return $this->render('@nada/pages/changepw.html.twig',array(

            'form'=>$form->createView(),
            'userf'=>$Profile,
        ));
    }
    /**
     * @Route("/delete_user/{id}",name="delete_user")
     */
    public function delete_userAction($id)
    {
        $user = $this->getUser();
        if (!is_object($user) ) {
            return $this->redirectToRoute('fos_user_security_login');
        }
        $em=$this->getDoctrine()->getManager();
        $user = $em->getRepository('nadaBundle:User')->findOneBy(array('id' => $id ));
        $em->remove( $user);
        $em->flush();
        return $this->redirect($this->generateUrl('User_list',array('msg'=>"Delete successful")));
    }


}