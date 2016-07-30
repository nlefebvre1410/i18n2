<?php

namespace Cz\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class AccueilController extends Controller
{
    /**
     * @Route("/", name="CzAdminBundle_accueil")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }

}
