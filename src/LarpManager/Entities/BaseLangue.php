<?php

/**
 * Auto generated by MySQL Workbench Schema Exporter.
 * Version 2.1.6-dev (doctrine2-annotation) on 2017-07-01 12:27:40.
 * Goto https://github.com/johmue/mysql-workbench-schema-exporter for more
 * information.
 */

namespace LarpManager\Entities;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * LarpManager\Entities\Langue
 *
 * @Entity()
 * @Table(name="langue")
 * @InheritanceType("SINGLE_TABLE")
 * @DiscriminatorColumn(name="discr", type="string")
 * @DiscriminatorMap({"base":"BaseLangue", "extended":"Langue"})
 */
class BaseLangue
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
    protected $label;

    /**
     * @Column(type="string", length=450, nullable=true)
     */
    protected $description;

    /**
     * @Column(type="integer", nullable=true)
     */
    protected $diffusion;

    /**
     * @OneToMany(targetEntity="PersonnageLangues", mappedBy="langue")
     * @JoinColumn(name="id", referencedColumnName="langue_id", nullable=false)
     */
    protected $personnageLangues;

    /**
     * @OneToMany(targetEntity="Territoire", mappedBy="langue")
     * @JoinColumn(name="id", referencedColumnName="langue_id", nullable=false)
     */
    protected $territoires;

    /**
     * @ManyToMany(targetEntity="Document", mappedBy="langues")
     */
    protected $documents;

    public function __construct()
    {
        $this->personnageLangues = new ArrayCollection();
        $this->territoires = new ArrayCollection();
        $this->documents = new ArrayCollection();
    }

    /**
     * Set the value of id.
     *
     * @param integer $id
     * @return \LarpManager\Entities\Langue
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
     * @return \LarpManager\Entities\Langue
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
     * @return \LarpManager\Entities\Langue
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
     * Set the value of diffusion.
     *
     * @param integer $diffusion
     * @return \LarpManager\Entities\Langue
     */
    public function setDiffusion($diffusion)
    {
        $this->diffusion = $diffusion;

        return $this;
    }

    /**
     * Get the value of diffusion.
     *
     * @return integer
     */
    public function getDiffusion()
    {
        return $this->diffusion;
    }

    /**
     * Add PersonnageLangues entity to collection (one to many).
     *
     * @param \LarpManager\Entities\PersonnageLangues $personnageLangues
     * @return \LarpManager\Entities\Langue
     */
    public function addPersonnageLangues(PersonnageLangues $personnageLangues)
    {
        $this->personnageLangues[] = $personnageLangues;

        return $this;
    }

    /**
     * Remove PersonnageLangues entity from collection (one to many).
     *
     * @param \LarpManager\Entities\PersonnageLangues $personnageLangues
     * @return \LarpManager\Entities\Langue
     */
    public function removePersonnageLangues(PersonnageLangues $personnageLangues)
    {
        $this->personnageLangues->removeElement($personnageLangues);

        return $this;
    }

    /**
     * Get PersonnageLangues entity collection (one to many).
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPersonnageLangues()
    {
        return $this->personnageLangues;
    }

    /**
     * Add Territoire entity to collection (one to many).
     *
     * @param \LarpManager\Entities\Territoire $territoire
     * @return \LarpManager\Entities\Langue
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
     * @return \LarpManager\Entities\Langue
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
     * Add Document entity to collection.
     *
     * @param \LarpManager\Entities\Document $document
     * @return \LarpManager\Entities\Langue
     */
    public function addDocument(Document $document)
    {
        $this->documents[] = $document;

        return $this;
    }

    /**
     * Remove Document entity from collection.
     *
     * @param \LarpManager\Entities\Document $document
     * @return \LarpManager\Entities\Langue
     */
    public function removeDocument(Document $document)
    {
        $this->documents->removeElement($document);

        return $this;
    }

    /**
     * Get Document entity collection.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDocuments()
    {
        return $this->documents;
    }

    public function __sleep()
    {
        return array('id', 'label', 'description', 'diffusion');
    }
}