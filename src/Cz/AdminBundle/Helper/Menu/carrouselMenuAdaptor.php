<?php

namespace Cz\AdminBundle\Helper\Menu;

use Symfony\Component\HttpFoundation\Request;
use Cz\ManagerBundle\Helper\Menu\MenuItem;
use Cz\ManagerBundle\Helper\Menu\MenuAdaptorInterface;
use Cz\ManagerBundle\Helper\Menu\MenuBuilder;
use Cz\ManagerBundle\Helper\Menu\TopMenuItem;
class carrouselMenuAdaptor implements MenuAdaptorInterface
{

    /**
     * In this method you can add children for a specific parent, but also remove and change the already created children
     *
     * @param MenuBuilder $menu      The MenuBuilder
     * @param MenuItem[]  &$children The current children
     * @param MenuItem    $parent    The parent Menu item
     * @param Request     $request   The Request
     */
    public function adaptChildren(MenuBuilder $menu, array &$children, MenuItem $parent = null, Request $request = null)
    {
        if (is_null($parent)) {

        } elseif ('CzAdminBundle_accueil' == $parent->getRoute()) {
            $menuItem = new TopMenuItem($menu);
            $menuItem
                ->setRoute('CzAdminBundle_carrousel')
                ->setLabel('Carrousel')
                ->setUniqueId('Carrousel')
                ->setCategory('Acceuil')
                ->setParent($parent);

            if (stripos($request->attributes->get('_route'), $menuItem->getRoute()) === 0) {
                $menuItem->setActive(true);
                $parent->setActive(true);
            }
            $children[] = $menuItem;
        }
    }

}
