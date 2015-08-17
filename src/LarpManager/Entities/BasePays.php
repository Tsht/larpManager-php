<?php

/**
 * Auto generated by MySQL Workbench Schema Exporter.
 * Version 2.1.6-dev (doctrine2-annotation) on 2015-08-17 21:48:57.
 * Goto https://github.com/johmue/mysql-workbench-schema-exporter for more
 * information.
 */

namespace LarpManager\Entities;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * LarpManager\Entities\Pays
 *
 * @Entity()
 * @Table(name="pays", indexes={@Index(name="fk_pays_user1_idx", columns={"creator_id"})})
 * @InheritanceType("SINGLE_TABLE")
 * @DiscriminatorColumn(name="discr", type="string")
 * @DiscriminatorMap({"base":"BasePays", "extended":"Pays"})
 */
class BasePays
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @Column(type="string", length=100)
     */
    protected $nom;

    /**
     * @Column(type="string", length=255, nullable=true)
     */
    protected $description;

    /**
     * @Column(type="integer", nullable=true)
     */
    protected $impot;

    /**
     * @Column(type="integer", nullable=true)
     */
    protected $richesse;

    /**
     * @Column(type="text", nullable=true)
     */
    protected $histoire;

    /**
     * @Column(type="string", length=100, nullable=true)
     */
    protected $capitale;

    /**
     * @Column(type="datetime", nullable=true)
     */
    protected $creation_date;

    /**
     * @Column(type="datetime", nullable=true)
     */
    protected $update_date;

    /**
     * @Column(type="boolean", nullable=true)
     */
    protected $is_enabled;

    /**
     * @OneToMany(targetEntity="Chronologie", mappedBy="pays")
     * @JoinColumn(name="id", referencedColumnName="pays_id")
     */
    protected $chronologies;

    /**
     * @OneToMany(targetEntity="Region", mappedBy="pays")
     * @JoinColumn(name="id", referencedColumnName="pays_id")
     */
    protected $regions;

    /**
     * @ManyToOne(targetEntity="User", inversedBy="pays")
     * @JoinColumn(name="creator_id", referencedColumnName="id")
     */
    protected $user;

    /**
     * @ManyToMany(targetEntity="Langue", inversedBy="pays")
     * @JoinTable(name="pays_langue",
     *     joinColumns={@JoinColumn(name="pays_id", referencedColumnName="id")},
     *     inverseJoinColumns={@JoinColumn(name="langue_id", referencedColumnName="id")}
     * )
     */
    protected $langues;

    public function __construct()
    {
        $this->chronologies = new ArrayCollection();
        $this->regions = new ArrayCollection();
        $this->langues = new ArrayCollection();
    }

    /**
     * Set the value of id.
     *
     * @param integer $id
     * @return \LarpManager\Entities\Pays
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
     * Set the value of nom.
     *
     * @param string $nom
     * @return \LarpManager\Entities\Pays
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get the value of nom.
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set the value of description.
     *
     * @param string $description
     * @return \LarpManager\Entities\Pays
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
     * Set the value of impot.
     *
     * @param integer $impot
     * @return \LarpManager\Entities\Pays
     */
    public function setImpot($impot)
    {
        $this->impot = $impot;

        return $this;
    }

    /**
     * Get the value of impot.
     *
     * @return integer
     */
    public function getImpot()
    {
        return $this->impot;
    }

    /**
     * Set the value of richesse.
     *
     * @param integer $richesse
     * @return \LarpManager\Entities\Pays
     */
    public function setRichesse($richesse)
    {
        $this->richesse = $richesse;

        return $this;
    }

    /**
     * Get the value of richesse.
     *
     * @return integer
     */
    public function getRichesse()
    {
        return $this->richesse;
    }

    /**
     * Set the value of histoire.
     *
     * @param string $histoire
     * @return \LarpManager\Entities\Pays
     */
    public function setHistoire($histoire)
    {
        $this->histoire = $histoire;

        return $this;
    }

    /**
     * Get the value of histoire.
     *
     * @return string
     */
    public function getHistoire()
    {
        return $this->histoire;
    }

    /**
     * Set the value of capitale.
     *
     * @param string $capitale
     * @return \LarpManager\Entities\Pays
     */
    public function setCapitale($capitale)
    {
        $this->capitale = $capitale;

        return $this;
    }

    /**
     * Get the value of capitale.
     *
     * @return string
     */
    public function getCapitale()
    {
        return $this->capitale;
    }

    /**
     * Set the value of creation_date.
     *
     * @param \DateTime $creation_date
     * @return \LarpManager\Entities\Pays
     */
    public function setCreationDate($creation_date)
    {
        $this->creation_date = $creation_date;

        return $this;
    }

    /**
     * Get the value of creation_date.
     *
     * @return \DateTime
     */
    public function getCreationDate()
    {
        return $this->creation_date;
    }

    /**
     * Set the value of update_date.
     *
     * @param \DateTime $update_date
     * @return \LarpManager\Entities\Pays
     */
    public function setUpdateDate($update_date)
    {
        $this->update_date = $update_date;

        return $this;
    }

    /**
     * Get the value of update_date.
     *
     * @return \DateTime
     */
    public function getUpdateDate()
    {
        return $this->update_date;
    }

    /**
     * Set the value of is_enabled.
     *
     * @param boolean $is_enabled
     * @return \LarpManager\Entities\Pays
     */
    public function setIsEnabled($is_enabled)
    {
        $this->is_enabled = $is_enabled;

        return $this;
    }

    /**
     * Get the value of is_enabled.
     *
     * @return boolean
     */
    public function getIsEnabled()
    {
        return $this->is_enabled;
    }

    /**
     * Add Chronologie entity to collection (one to many).
     *
     * @param \LarpManager\Entities\Chronologie $chronologie
     * @return \LarpManager\Entities\Pays
     */
    public function addChronologie(Chronologie $chronologie)
    {
        $this->chronologies[] = $chronologie;

        return $this;
    }

    /**
     * Remove Chronologie entity from collection (one to many).
     *
     * @param \LarpManager\Entities\Chronologie $chronologie
     * @return \LarpManager\Entities\Pays
     */
    public function removeChronologie(Chronologie $chronologie)
    {
        $this->chronologies->removeElement($chronologie);

        return $this;
    }

    /**
     * Get Chronologie entity collection (one to many).
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getChronologies()
    {
        return $this->chronologies;
    }

    /**
     * Add Region entity to collection (one to many).
     *
     * @param \LarpManager\Entities\Region $region
     * @return \LarpManager\Entities\Pays
     */
    public function addRegion(Region $region)
    {
        $this->regions[] = $region;

        return $this;
    }

    /**
     * Remove Region entity from collection (one to many).
     *
     * @param \LarpManager\Entities\Region $region
     * @return \LarpManager\Entities\Pays
     */
    public function removeRegion(Region $region)
    {
        $this->regions->removeElement($region);

        return $this;
    }

    /**
     * Get Region entity collection (one to many).
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRegions()
    {
        return $this->regions;
    }

    /**
     * Set User entity (many to one).
     *
     * @param \LarpManager\Entities\User $user
     * @return \LarpManager\Entities\Pays
     */
    public function setUser(User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get User entity (many to one).
     *
     * @return \LarpManager\Entities\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Add Langue entity to collection.
     *
     * @param \LarpManager\Entities\Langue $langue
     * @return \LarpManager\Entities\Pays
     */
    public function addLangue(Langue $langue)
    {
        $langue->addPays($this);
        $this->langues[] = $langue;

        return $this;
    }

    /**
     * Remove Langue entity from collection.
     *
     * @param \LarpManager\Entities\Langue $langue
     * @return \LarpManager\Entities\Pays
     */
    public function removeLangue(Langue $langue)
    {
        $langue->removePays($this);
        $this->langues->removeElement($langue);

        return $this;
    }

    /**
     * Get Langue entity collection.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLangues()
    {
        return $this->langues;
    }

    public function __sleep()
    {
        return array('id', 'nom', 'description', 'impot', 'richesse', 'histoire', 'capitale', 'creation_date', 'update_date', 'is_enabled', 'creator_id');
    }
}