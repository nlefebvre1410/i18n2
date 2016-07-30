<?php
/**
 * Created by PhpStorm.
 * User: nicolaslefebvre
 * Date: 27/07/2016
 * Time: 16:37
 */

namespace Cz\AdminBundle\Entity;


use Cz\ManagerBundle\Entity\EntityInterface;
use Symfony\Component\Form\AbstractType;

interface HasPageInterface extends EntityInterface
{

    /**
     * @return string
     */
    public function getTitle();

    /**
     * Set title
     *
     * @param string $title
     *
     * @return HasNodeInterface
     */
    public function setTitle($title);

    /**
     * @return HasNodeInterface
     */
    public function getParent();

    /**
     * @param HasNodeInterface $hasNode
     */
    public function setParent(HasNodeInterface $hasNode);

    /**
     * @return AbstractType
     */
    public function getDefaultAdminType();

    /**
     * @return array
     */
    public function getPossibleChildTypes();

    /**
     * When this is true there won't be any save, publish, copy, menu, meta, preview, etc.
     * It's basically not a page. Just a node where other pages can hang under.
     *
     * @return boolean
     */
    public function isStructureNode();

}
