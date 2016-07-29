<?php

namespace Cz\I18Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class FrontendController extends Controller
{

    public function homepageAction()
    {
        return $this->render('CzI18Bundle:Frontend:homepage.html.twig', array(
            // ...
        ));
    }
    /**
     * locales:  { en: "/welcome", fr: "/bienvenue", de: "/willkommen" }
     */
    public function tesAction(Request $request)
    {
        return array();
    }

}
