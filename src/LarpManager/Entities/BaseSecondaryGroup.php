<?php

/**
 * Auto generated by MySQL Workbench Schema Exporter.
 * Version 2.1.6-dev (doctrine2-annotation) on 2016-09-15 11:44:02.
 * Goto https://github.com/johmue/mysql-workbench-schema-exporter for more
 * information.
 */

namespace LarpManager\Entities;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * LarpManager\Entities\SecondaryGroup
 *
 * @Entity()
 * @Table(name="secondary_group", indexes={@Index(name="fk_secondary_groupe_secondary_group_type1_idx", columns={"secondary_group_type_id"}), @Index(name="fk_secondary_group_personnage1_idx", columns={"personnage_id"}), @Index(name="fk_secondary_group_topic1_idx", columns={"topic_id"})})
 * @InheritanceType("SINGLE_TABLE")
 * @DiscriminatorColumn(name="discr", type="string")
 * @DiscriminatorMap({"base":"BaseSecondaryGroup", "extended":"SecondaryGroup"})
 */
class BaseSecondaryGroup
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
     * @Column(type="text", nullable=true)
     */
    protected $description_secrete;

    /**
     * @OneToMany(targetEntity="Membre", mappedBy="secondaryGroup")
     * @JoinColumn(name="id", referencedColumnName="secondary_group_id", nullable=false)
     */
    protected $membres;

    /**
     * @OneToMany(targetEntity="Postulant", mappedBy="secondaryGroup")
     * @JoinColumn(name="id", referencedColumnName="secondary_group_id", nullable=false)
     */
    protected $postulants;

    /**
     * @ManyToOne(targetEntity="SecondaryGroupType", inversedBy="secondaryGroups")
     * @JoinColumn(name="secondary_group_type_id", referencedColumnName="id", nullable=false)
     */
    protected $secondaryGroupType;

    /**
     * @ManyToOne(targetEntity="Personnage", inversedBy="secondaryGroups")
     * @JoinColumn(name="personnage_id", referencedColumnName="id")
     */
    protected $personnage;

    /**
     * @ManyToOne(targetEntity="Topic", inversedBy="secondaryGroups")
     * @JoinColumn(name="topic_id", referencedColumnName="id", nullable=false)
     */
    protected $topic;

    public function __construct()
    {
        $this->membres = new ArrayCollection();
        $this->postulants = new ArrayCollection();
    }

    /**
     * Set the value of id.
     *
     * @param integer $id
     * @return \LarpManager\Entities\SecondaryGroup
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
     * @return \LarpManager\Entities\SecondaryGroup
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
     * @return \LarpManager\Entities\SecondaryGroup
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
     * Set the value of description_secrete.
     *
     * @param string $description_secrete
     * @return \LarpManager\Entities\SecondaryGroup
     */
    public function setDescriptionSecrete($description_secrete)
    {
        $this->description_secrete = $description_secrete;

        return $this;
    }

    /**
     * Get the value of description_secrete.
     *
     * @return string
     */
    public function getDescriptionSecrete()
    {
        return $this->description_secrete;
    }

    /**
     * Add Membre entity to collection (one to many).
     *
     * @param \LarpManager\Entities\Membre $membre
     * @return \LarpManager\Entities\SecondaryGroup
     */
    public function addMembre(Membre $membre)
    {
        $this->membres[] = $membre;

        return $this;
    }

    /**
     * Remove Membre entity from collection (one to many).
     *
     * @param \LarpManager\Entities\Membre $membre
     * @return \LarpManager\Entities\SecondaryGroup
     */
    public function removeMembre(Membre $membre)
    {
        $this->membres->removeElement($membre);

        return $this;
    }

    /**
     * Get Membre entity collection (one to many).
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMembres()
    {
        return $this->membres;
    }

    /**
     * Add Postulant entity to collection (one to many).
     *
     * @param \LarpManager\Entities\Postulant $postulant
     * @return \LarpManager\Entities\SecondaryGroup
     */
    public function addPostulant(Postulant $postulant)
    {
        $this->postulants[] = $postulant;

        return $this;
    }

    /**
     * Remove Postulant entity from collection (one to many).
     *
     * @param \LarpManager\Entities\Postulant $postulant
     * @return \LarpManager\Entities\SecondaryGroup
     */
    public function removePostulant(Postulant $postulant)
    {
        $this->postulants->removeElement($postulant);

        return $this;
    }

    /**
     * Get Postulant entity collection (one to many).
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPostulants()
    {
        return $this->postulants;
    }

    /**
     * Set SecondaryGroupType entity (many to one).
     *
     * @param \LarpManager\Entities\SecondaryGroupType $secondaryGroupType
     * @return \LarpManager\Entities\SecondaryGroup
     */
    public function setSecondaryGroupType(SecondaryGroupType $secondaryGroupType = null)
    {
        $this->secondaryGroupType = $secondaryGroupType;

        return $this;
    }

    /**
     * Get SecondaryGroupType entity (many to one).
     *
     * @return \LarpManager\Entities\SecondaryGroupType
     */
    public function getSecondaryGroupType()
    {
        return $this->secondaryGroupType;
    }

    /**
     * Set Personnage entity (many to one).
     *
     * @param \LarpManager\Entities\Personnage $personnage
     * @return \LarpManager\Entities\SecondaryGroup
     */
    public function setPersonnage(Personnage $personnage = null)
    {
        $this->personnage = $personnage;

        return $this;
    }

    /**
     * Get Personnage entity (many to one).
     *
     * @return \LarpManager\Entities\Personnage
     */
    public function getPersonnage()
    {
        return $this->personnage;
    }

    /**
     * Set Topic entity (many to one).
     *
     * @param \LarpManager\Entities\Topic $topic
     * @return \LarpManager\Entities\SecondaryGroup
     */
    public function setTopic(Topic $topic = null)
    {
        $this->topic = $topic;

        return $this;
    }

    /**
     * Get Topic entity (many to one).
     *
     * @return \LarpManager\Entities\Topic
     */
    public function getTopic()
    {
        return $this->topic;
    }

    public function __sleep()
    {
        return array('id', 'label', 'description', 'secondary_group_type_id', 'personnage_id', 'topic_id', 'description_secrete');
    }
}