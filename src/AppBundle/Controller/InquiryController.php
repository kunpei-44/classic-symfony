<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * @Route("/Inquiry")
 */

class InquiryController extends Controller
{
    /**
     * @Route("/")
     * @Method("get")
     */
    public function indexAction()
    {
        $form = $this->createFormBilder()
                ->add('name', 'text')
                ->add('email', 'text')
                ->add('tel', 'text', [
                    'required' => false,
                ])
                ->add('type', 'choice', [
                    'choices' => [
                        '公演について',
                        'その他',
                    ],
                    'expand' => true,
                ])
                ->add('content', 'textarea')
                ->add('submit', 'submit', [
                    'label' => '送信',
                ])
                ->getForm();
        
        return $this->render('Inquiry_index.html.twig',
                ['form' => $form->createView()]
        );
    }
}
