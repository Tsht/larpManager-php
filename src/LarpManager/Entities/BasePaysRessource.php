<?php

/**
 * Auto generated by MySQL Workbench Schema Exporter.
 * Version 2.1.6-dev (doctrine2-annotation) on 2015-07-01 07:09:36.
 * Goto https://github.com/johmue/mysql-workbench-schema-exporter for more
 * information.
 */

namespace LarpManager\Entities;

/**
 * LarpManager\Entities\PaysRessource
 *
 * @Entity()
 * @Table(name="pays_ressource", indexes={@Index(name="fk_pays_importation_pays1_idx", columns={"pays_id"})})
 * @InheritanceType("SINGLE_TABLE")
 * @DiscriminatorColumn(name="discr", type="string")
 * @DiscriminatorMap({"base":"BasePaysRessource", "extended":"PaysRessource"})
 */
class BasePaysRessource
{
    /**
     * @Id
     * @Column(type="integer")
     */
    protected $ressource_id;

    /**
     * @Id
     * @Column(type="integer")
     */
    protected $pays_id;

    /**
     * @Column(type="integer", nullable=true)
     */
    protected $sens;

    /**
     * @ManyToOne(targetEntity="Ressource", inversedBy="paysRessources")
     * @JoinColumn(name="ressource_id", referencedColumnName="id")
     */
    protected $ressource;

    /**
     * @ManyToOne(targetEntity="Pays", inversedBy="paysRessources")
     * @JoinColumn(name="pays_id", referencedColumnName="id")
     */
    protected $pays;

    public function __construct()
    {
    }

    /**
     * Set the value of ressource_id.
     *
     * @param integer $ressource_id
     * @return \LarpManager\Entities\PaysRessource
     */
    public function setRessourceId($ressource_id)
    {
        $this->ressource_id = $ressource_id;

        return $this;
    }

    /**
     * Get the value of ressource_id.
     *
     * @return integer
     */
    public function getRessourceId()
    {
        return $this->ressource_id;
    }

    /**
     * Set the value of pays_id.
     *
     * @param integer $pays_id
     * @return \LarpManager\Entities\PaysRessource
     */
    public function setPaysId($pays_id)
    {
        $this->pays_id = $pays_id;

        return $this;
    }

    /**
     * Get the value of pays_id.
     *
     * @return integer
     */
    public function getPaysId()
    {
        return $this->pays_id;
    }

    /**
     * Set the value of sens.
     *
     * @param integer $sens
     * @return \LarpManager\Entities\PaysRessource
     */
    public function setSens($sens)
    {
        $this->sens = $sens;

        return $this;
    }

    /**
     * Get the value of sens.
     *
     * @return integer
     */
    public function getSens()
    {
        return $this->sens;
    }

    /**
     * Set Ressource entity (many to one).
     *
     * @param \LarpManager\Entities\Ressource $ressource
     * @return \LarpManager\Entities\PaysRessource
     */
    public function setRessource(Ressource $ressource = null)
    {
        $this->ressource = $ressource;

        return $this;
    }

    /**
     * Get Ressource entity (many to one).
     *
     * @return \LarpManager\Entities\Ressource
     */
    public function getRessource()
    {
        return $this->ressource;
    }

    /**
     * Set Pays entity (many to one).
     *
     * @param \LarpManager\Entities\Pays $pays
     * @return \LarpManager\Entities\PaysRessource
     */
    public function setPays(Pays $pays = null)
    {
        $this->pays = $pays;

        return $this;
    }

    /**
     * Get Pays entity (many to one).
     *
     * @return \LarpManager\Entities\Pays
     */
    public function getPays()
    {
        return $this->pays;
    }

    public function __sleep()
    {
        return array('ressource_id', 'pays_id', 'sens');
    }
}