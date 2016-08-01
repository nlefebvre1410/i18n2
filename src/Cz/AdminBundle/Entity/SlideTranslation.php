<?php

namespace Cz\AdminBundle\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="slide_translation")
 */
class SlideTranslation implements \A2lix\I18nDoctrineBundle\Doctrine\Interfaces\OneLocaleInterface
{

    use \A2lix\I18nDoctrineBundle\Doctrine\ORM\Util\Translation;



    /**
     * @ORM\Column
     */
    private $title;

    public function getId()
    {
        return $this->id;
    }

    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    public function getTitle()
    {
        return $this->title;
    }




}
