<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Centrifuge;
use AppBundle\Entity\Falcon;
use AppBundle\Form\FalconType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="index")
     */
    public function indexAction(Request $request)
    {

        $falcon = new Falcon();
        $form = $this->createForm(FalconType::class, $falcon);
        $form->handleRequest($request);


        $session = new Session();
        $centrifuge = $session->get('centrifuge');
        if(null == $centrifuge) {
            $centrifuge = new Centrifuge();
        }


        if ($form->isSubmitted() && $form->isValid()) {
            $centrifuge->set($falcon);
            $session->set('centrifuge', $centrifuge);
            $session->save();

            $this->addFlash(
                'notice',
                'Falcon added.'
            );
            return $this->redirect($this->generateUrl('index'));
        }


        return $this->render('default/index.html.twig', [
            'form' => $form->createView(),
            'collection' => $centrifuge,
        ]);
    }
}
