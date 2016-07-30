<?php

namespace Cz\I18Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AcceuilController extends Controller
{
    public function indexAction()
    {
        return $this->render('CzI18Bundle:Acceuil:index.html.twig', array(
            // ...
        ));
    }

}
