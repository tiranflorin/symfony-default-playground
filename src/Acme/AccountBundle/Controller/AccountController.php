<?php
// src/Acme/AccountBundle/Controller/AccountController.php
namespace Acme\AccountBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Acme\AccountBundle\Form\Type\RegistrationType;
use Acme\AccountBundle\Form\Model\Registration;

class AccountController extends Controller
{
    public function registerAction()
    {
        $registration = new Registration();
        $form = $this->createForm(new RegistrationType(), $registration, array(
            'action' => $this->generateUrl('account_create'),
        ));
        return $this->render(
            'AcmeAccountBundle:Account:register.html.twig',
            array('form' => $form->createView())
        );
    }

    public function createAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(new RegistrationType(), new Registration());
        $form->handleRequest($request);
        if ($form->isValid()) {
            $registration = $form->getData();
            $em->persist($registration->getUser());
            $em->flush();
            return $this->redirect($this->generateUrl('acme_account_homepage', array('name' => 'registration')));
        }
        return $this->render(
            'AcmeAccountBundle:Account:register.html.twig',
            array('form' => $form->createView())
        );
    }
}