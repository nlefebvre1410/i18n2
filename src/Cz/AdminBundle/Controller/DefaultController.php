<?php

namespace Cz\AdminBundle\Controller;

use Cz\AdminBundle\Entity\Carrousel;
use Cz\AdminBundle\Entity\Namec;
use Cz\AdminBundle\Entity\Pages;
use Cz\AdminBundle\Entity\PagesTranslation;
use Cz\AdminBundle\Entity\Person;
use Cz\AdminBundle\Form\NamecType;
use Cz\AdminBundle\Form\CarrouselType;
use Cz\AdminBundle\Form\Handler\CzHandler;
use Cz\AdminBundle\Form\PagesTranslationType;
use DateTime;
use Kunstmaan\AdminBundle\Entity\BaseUser;
use Kunstmaan\AdminBundle\Entity\EntityInterface;
use Kunstmaan\AdminBundle\FlashMessages\FlashTypes;
use Kunstmaan\NodeBundle\Event\RecopyPageTranslationNodeEvent;
use Kunstmaan\NodeBundle\Form\NodeMenuTabTranslationAdminType;
use Kunstmaan\NodeBundle\Form\NodeMenuTabAdminType;
use InvalidArgumentException;

use Doctrine\ORM\EntityManager;
use Doctrine\Common\Collections\ArrayCollection;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Acl\Domain\RoleSecurityIdentity;
use Symfony\Component\Security\Acl\Model\MutableAclProviderInterface;
use Symfony\Component\Security\Acl\Model\ObjectIdentityRetrievalStrategyInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Acl\Model\EntryInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Kunstmaan\AdminBundle\Helper\Security\Acl\AclHelper;
use Kunstmaan\AdminBundle\Helper\Security\Acl\Permission\PermissionMap;
use Kunstmaan\AdminListBundle\AdminList\AdminList;
use Kunstmaan\NodeBundle\AdminList\NodeAdminListConfigurator;
use Kunstmaan\NodeBundle\Entity\Node;
use Kunstmaan\NodeBundle\Event\Events;
use Kunstmaan\NodeBundle\Event\NodeEvent;
use Kunstmaan\NodeBundle\Event\AdaptFormEvent;
use Kunstmaan\NodeBundle\Event\RevertNodeAction;
use Kunstmaan\NodeBundle\Entity\HasNodeInterface;
use Kunstmaan\AdminBundle\Helper\FormWidgets\Tabs\Tab;
use Kunstmaan\AdminBundle\Helper\FormWidgets\Tabs\TabPane;
use Kunstmaan\NodeBundle\Repository\NodeVersionRepository;
use Kunstmaan\NodeBundle\Event\CopyPageTranslationNodeEvent;
use Kunstmaan\NodeBundle\Entity\NodeVersion;
use Kunstmaan\NodeBundle\Entity\NodeTranslation;
use Kunstmaan\UtilitiesBundle\Helper\ClassLookup;
use Kunstmaan\AdminBundle\Helper\FormWidgets\FormWidget;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class DefaultController extends Controller
{
    private function dumps($pe){

       dump($pe);
           die();
    }
    /**
     * @var EntityManager $em
     */
    protected $em;

    /**
     * @var string $locale
     */
    protected $locale;

    /**
     * @var AuthorizationCheckerInterface $authorizationChecker
     */
    protected $authorizationChecker;

    /**
     * @var BaseUser $user
     */
    protected $user;

    /**
     * @var AclHelper $aclHelper
     */
    protected $aclHelper;


    /**
     * init
     *
     * @param Request $request
     */
    protected function init(Request $request)
    {
        $this->em                   = $this->getDoctrine()->getManager();
        $this->locale               = $request->getLocale();
        $this->authorizationChecker = $this->get('security.authorization_checker');
        $this->user                 = $this->getUser();
        $this->aclHelper            = $this->get('kunstmaan_admin.acl.helper');
    }
    /**
     * @Route("/", name="CzAdminBundle_homepage")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }
    /**
     * @Route("/carrousel/list" , name="CzAdminBundle_carrousel_list")
     * @Template("CzAdminBundle:Carrousel:carrousel_list.html.twig")
     */
    public function carrouselListAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $list = $em->getRepository('CzAdminBundle:Carrousel')->getLang($request->getLocale());
        return array('list'=>$list);
    }

    /**
     * @Route("/carrousel" , name="CzAdminBundle_carrousel")
     * @Template("CzAdminBundle:Carrousel:carrousel.html.twig")
     */
    public function carrouselAction(Request $request)
    {
        $form = $this->get('cz_handler_carrousel');
        if($form->process()){
            return $this->redirect($this->generateUrl("CzAdminBundle_homepage"));
        }
        return  array('form'=> $form->createView());
    }


    /**
     * @Route("/carrouseltestview/{id}" , name="CzAdminBundle_carrouseltestview")
     * @Template("CzAdminBundle:Carrousel:carrouselview.html.twig")
     */
    public function carrouseltestviewAction($id)
    {

        $carrousel = $this->getDoctrine()
            ->getRepository('CzAdminBundle:Carrousel')
            ->findOneBy(array('id' => $id));

        return array('carrousel' => $carrousel);

    }



    /**
     * @Route("/carrouseltest" , name="CzAdminBundle_carrouseltest")
     * @Template("CzAdminBundle:Carrousel:carrousel.html.twig")
     */
    public function carrouseltestAction(Request $request)
    {

        $carrousel = new Carrousel();
        $form = $this->createForm(CarrouselType::class, $carrousel);


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $carrousel = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($carrousel);
            $em->flush();

            return $this->redirectToRoute('CzAdminBundle_carrouseltestview', array('id' => $carrousel->getId()));
        }

        return  array('form'=> $form->createView());
    }




    /**
     * @Route("/personnalisation", name="CzAdminBundle_perso")
     * @Template("CzAdminBundle:Personnalisation:index.html.twig")
     */
    public function persoAction(Request $request)
    {

   $this->init($request);

        $nodeAdminListConfigurator = new NodeAdminListConfigurator(
            $this->em,
            $this->aclHelper,
            $this->locale,
            PermissionMap::PERMISSION_VIEW,
            $this->authorizationChecker

        );

        $adminlist = $this->get('kunstmaan_adminlist.factory')->createList($nodeAdminListConfigurator);

        return array(
            'adminlist' => $adminlist,
        );


//        * @Template("KunstmaanNodeBundle:Admin:list.html.twig")

    }

    /**
     * @Route("/services", name="CzAdminBundle_services")
     * @Template()
     */
    public function servicesAction()
    {
        return $this->render("CzAdminBundle:Services:index.html.twig");
    }
    /**
     * @Route("/test", name="CzAdminBundle_test")
     * @Template()
     */
    public function testAction(Request $request)

    {

         $pe = new PagesTranslation();

        $form =  $this->createForm(new PagesTranslationType(),$pe);
        $form->add('submit', SubmitType::class, array(
            'label' => 'Create',
            'attr'  => array('class' => 'btn btn-default ')
        ));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($pe);
            $em->flush();
            return $this->redirectToRoute('CzAdminBundle_homepage');
        }


        return $this->render('CzAdminBundle:Carrousel:carrousel.test.html.twig', array(
            'form' => $form->createView(),
        ));

    }

    /**
     * Creates a new Demo entity.
     *
     * @Route("/test", name="demo_create")
     * @Method("POST")
     *
     */
    public function ajaxFormAction(Request $request) {
//        if ($request->isXmlHttpRequest()) {

        //création du formulaire
        $myFormObject = new PagesTranslation();
        $myEntityForm   = $this->createForm(new PagesTranslationType(), $myFormObject);
        $myEntityForm->handleRequest($request);

        if (   $myEntityForm-->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist( $myEntityForm );
            $em->flush();

            //envoi des données JSON en front
            $response = new JsonResponse();
            $response->setStatusCode(200);
            //ajout de données éventuelles
            $response->setData(array(
                'successMessage' => "Votre message a bien été envoyé"));
            return $response;
        } else {
            //form non valide
            //envoi des données d'erreurs JSON en front
            $response = new JsonResponse();
            $response->setStatusCode(412);
            $response->setData(array(
                'formErrors' => $this->renderView('CzAdminBundle:Carrousel:carrousel.test.html.twig',
                    array('form' => $myEntityForm->createView() )
                ),

            ));
            return $response;
        }
    }
   
}
