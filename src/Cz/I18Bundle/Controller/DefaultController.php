<?php

namespace Cz\I18Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction(Request $request)

    {

        return $this->render('CzI18Bundle:Default:index.html.twig');
    }
}
