<?php

/**
 * Auto generated by MySQL Workbench Schema Exporter.
 * Version 2.1.6-dev (doctrine2-annotation) on 2017-02-09 11:20:15.
 * Goto https://github.com/johmue/mysql-workbench-schema-exporter for more
 * information.
 */

namespace LarpManager\Entities;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * LarpManager\Entities\Appelation
 *
 * @Entity()
 * @Table(name="appelation", indexes={@Index(name="fk_territoire_denomination_territoire_denomination1_idx", columns={"appelation_id"})})
 * @InheritanceType("SINGLE_TABLE")
 * @DiscriminatorColumn(name="discr", type="string")
 * @DiscriminatorMap({"base":"BaseAppelation", "extended":"Appelation"})
 */
class BaseAppelation
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
     * @Column(type="text", nullable=true)
     */
    protected $description;

    /**
     * @Column(type="string", length=45, nullable=true)
     */
    protected $titre;

    /**
     * @OneToMany(targetEntity="Appelation", mappedBy="appelation")
     * @JoinColumn(name="id", referencedColumnName="appelation_id", nullable=false)
     */
    protected $appelations;

    /**
     * @OneToMany(targetEntity="Territoire", mappedBy="appelation")
     * @JoinColumn(name="id", referencedColumnName="appelation_id", nullable=false)
     */
    protected $territoires;

    /**
     * @ManyToOne(targetEntity="Appelation", inversedBy="appelations")
     * @JoinColumn(name="appelation_id", referencedColumnName="id")
     */
    protected $appelation;

    public function __construct()
    {
        $this->appelations = new ArrayCollection();
        $this->territoires = new ArrayCollection();
    }

    /**
     * Set the value of id.
     *
     * @param integer $id
     * @return \LarpManager\Entities\Appelation
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
     * @return \LarpManager\Entities\Appelation
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
     * @return \LarpManager\Entities\Appelation
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
     * Set the value of titre.
     *
     * @param string $titre
     * @return \LarpManager\Entities\Appelation
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get the value of titre.
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Add Appelation entity to collection (one to many).
     *
     * @param \LarpManager\Entities\Appelation $appelation
     * @return \LarpManager\Entities\Appelation
     */
    public function addAppelation(Appelation $appelation)
    {
        $this->appelations[] = $appelation;

        return $this;
    }

    /**
     * Remove Appelation entity from collection (one to many).
     *
     * @param \LarpManager\Entities\Appelation $appelation
     * @return \LarpManager\Entities\Appelation
     */
    public function removeAppelation(Appelation $appelation)
    {
        $this->appelations->removeElement($appelation);

        return $this;
    }

    /**
     * Get Appelation entity collection (one to many).
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAppelations()
    {
        return $this->appelations;
    }

    /**
     * Add Territoire entity to collection (one to many).
     *
     * @param \LarpManager\Entities\Territoire $territoire
     * @return \LarpManager\Entities\Appelation
     */
    public function addTerritoire(Territoire $territoire)
    {
        $this->territoires[] = $territoire;

        return $this;
    }

    /**
     * Remove Territoire entity from collection (one to many).
     *
     * @param \LarpManager\Entities\Territoire $territoire
     * @return \LarpManager\Entities\Appelation
     */
    public function removeTerritoire(Territoire $territoire)
    {
        $this->territoires->removeElement($territoire);

        return $this;
    }

    /**
     * Get Territoire entity collection (one to many).
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTerritoires()
    {
        return $this->territoires;
    }

    /**
     * Set Appelation entity (many to one).
     *
     * @param \LarpManager\Entities\Appelation $appelation
     * @return \LarpManager\Entities\Appelation
     */
    public function setAppelation(Appelation $appelation = null)
    {
        $this->appelation = $appelation;

        return $this;
    }

    /**
     * Get Appelation entity (many to one).
     *
     * @return \LarpManager\Entities\Appelation
     */
    public function getAppelation()
    {
        return $this->appelation;
    }

    public function __sleep()
    {
        return array('id', 'appelation_id', 'label', 'description', 'titre');
    }
}