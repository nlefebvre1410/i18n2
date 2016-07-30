<?php

namespace Cz\AdminBundle\Entity;

use Cz\ManagerBundle\Entity\AbstractEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Reservation
 *
 * @ORM\Table(name="cz_adminbundle_reservation")
 * @ORM\Entity(repositoryClass="Cz\AdminBundle\Repository\ReservationRepository")
 */
class Reservation extends AbstractEntity
{
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;


    /**
     * Set name
     *
     * @param string $name
     *
     * @return Reservation
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}

