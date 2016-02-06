<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route ("/admin/inquiry")
 */
class AdminInquiryListController extends Controller
{
    /**
     * @Route ("/search")
     */
    public function indexAction(Request $request)
    {
        $form = $this->createSerchForm();
        $form->handleRequest($request);
        $keyword = null;
        if ($form->isValid()) {
            $keyword = $form->get('search')->getData();
        }
        
        $em = $this->getDoctrine()->getManager();
        $inquiryRepository = $em->getRepository('AppBundle:Inquiry');

        $inquiryList = $inquiryRepository->findAllByKeyword($keyword);

        return $this->render('Admin/Inquiry/index.html.twig',
            [
                'form' => $form->createView(),
                'inquiryList' => $inquiryList
            ]
        );
    }

    private function createSerchForm()
    {
        return $this->createFormBuilder()
            ->add('search', 'search')
            ->add('submit', 'submit', [
                'label' => '検索',
            ])
            ->getForm();
    }
}
