<?php

namespace Cz\AdminBundle\Form\Handler;

use Cz\ManagerBundle\Manager\CzManager;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

class CzHandler
{
    protected $form;
    protected $request;
    protected $manager;

    /**
     * CzHandler constructor.
     * @param Form $form
     * @param Request $request
     */
    public function __construct(Form $form, Request $request,CzManager $manager)
    {
        $this->form = $form;
        $this->request = $request;
        $this->manager = $manager;

    }

    /**
     * @return bool
     */
    public function process()
    {
        $this->form->handleRequest($this->request);
        if($this->request->isMethod('post') && $this->form->isValid()){
            $this->onSuccess();
            return true;
        }
        return false;
    }
    public function createView()
    {
        return $this->form->createView();
    }

    /**
     * @return Form
     */
    public function getForm()
    {
        return $this->form;
    }

    protected function onSuccess()
    {

        $this->manager->flush($this->form->getData());
    }
}