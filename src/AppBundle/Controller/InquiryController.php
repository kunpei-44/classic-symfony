<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/inquiry")
 */

class InquiryController extends Controller
{
    /**
     * @Route("/")
     * @Method("get")
     */
    public function indexAction()
    {
        return $this->render('Inquiry/index.html.twig',
                ['form' => $this->createInquiryForm()->createView()]
        );
    }
    
    private function createInquiryForm()
    {
        return $this->createFormBuilder()
                ->add('name', 'text',[
                    'label' => 'お名前',
                ])
                ->add('email', 'text',[
                    'label' => 'メールアドレス',
                ])
                ->add('tel', 'text', [
                    'label' => '電話番号',
                    'required' => false,
                ])
                ->add('type', 'choice', [
                    'label' => 'お問い合わせ種別',
                    'choices' => [
                        '公演について',
                        'その他',
                    ],
                    'expanded' => true,
                ])
                ->add('content', 'textarea',[
                    'label' => 'お問い合わせ内容',
                ])
                ->add('submit', 'submit', [
                    'label' => '送信',
                ])
                ->getForm();
    }
    
    /**
     * @Route("/complete")
     */
    public function completeAction()
    {
        return $this->render('Inquiry/complete.html.twig');
    }
    
    /**
     * @Route("/")
     * @Method("post")
     */
    public function indexPostAction(Request $request)
    {
        $form = $this->createInquiryForm();
        $form->handleRequest($request);
        if ($form->isValid())
        {
            $data = $form->getData();
            
            $message = \Swift_Message::newInstance()
                    ->setSubject('Webサイトからのお問い合わせ')
                    ->setFrom('webmaster@exsample.com')
                    ->setTo('sabs4416@gmail.com')
                    ->setBody(
                            $this->renderView(
                                    'mail/inquiry.txt.twig',
                                    ['data' => $data]
                            )
                    );
                    
            $this->get('mailer')->send($message);
            
            return $this->redirect(
                    $this->generateUrl('app_inquiry_complete'));
        }
        
        return $this->render('Inquiry/index.html.twig',
                ['form' => $form->createView()]
        );
    }
}
