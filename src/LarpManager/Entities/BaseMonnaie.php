<?php

/**
 * Auto generated by MySQL Workbench Schema Exporter.
 * Version 2.1.6-dev (doctrine2-annotation) on 2017-07-01 12:27:41.
 * Goto https://github.com/johmue/mysql-workbench-schema-exporter for more
 * information.
 */

namespace LarpManager\Entities;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * LarpManager\Entities\Monnaie
 *
 * @Entity()
 * @Table(name="monnaie")
 * @InheritanceType("SINGLE_TABLE")
 * @DiscriminatorColumn(name="discr", type="string")
 * @DiscriminatorMap({"base":"BaseMonnaie", "extended":"Monnaie"})
 */
class BaseMonnaie
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @Column(type="string", length=45)
     */
    protected $label;

    /**
     * @Column(type="text")
     */
    protected $description;

    /**
     * @OneToMany(targetEntity="QualityValeur", mappedBy="monnaie")
     * @JoinColumn(name="id", referencedColumnName="monnaie_id", nullable=false)
     */
    protected $qualityValeurs;

    public function __construct()
    {
        $this->qualityValeurs = new ArrayCollection();
    }

    /**
     * Set the value of id.
     *
     * @param integer $id
     * @return \LarpManager\Entities\Monnaie
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of id.
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of label.
     *
     * @param string $label
     * @return \LarpManager\Entities\Monnaie
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Get the value of label.
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Set the value of description.
     *
     * @param string $description
     * @return \LarpManager\Entities\Monnaie
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Add QualityValeur entity to collection (one to many).
     *
     * @param \LarpManager\Entities\QualityValeur $qualityValeur
     * @return \LarpManager\Entities\Monnaie
     */
    public function addQualityValeur(QualityValeur $qualityValeur)
    {
        $this->qualityValeurs[] = $qualityValeur;

        return $this;
    }

    /**
     * Remove QualityValeur entity from collection (one to many).
     *
     * @param \LarpManager\Entities\QualityValeur $qualityValeur
     * @return \LarpManager\Entities\Monnaie
     */
    public function removeQualityValeur(QualityValeur $qualityValeur)
    {
        $this->qualityValeurs->removeElement($qualityValeur);

        return $this;
    }

    /**
     * Get QualityValeur entity collection (one to many).
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getQualityValeurs()
    {
        return $this->qualityValeurs;
    }

    public function __sleep()
    {
        return array('id', 'label', 'description');
    }
}