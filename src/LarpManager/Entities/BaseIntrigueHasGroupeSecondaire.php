<?php

/**
 * Auto generated by MySQL Workbench Schema Exporter.
 * Version 2.1.6-dev (doctrine2-annotation) on 2017-07-01 12:27:40.
 * Goto https://github.com/johmue/mysql-workbench-schema-exporter for more
 * information.
 */

namespace LarpManager\Entities;

/**
 * LarpManager\Entities\IntrigueHasGroupeSecondaire
 *
 * @Entity()
 * @Table(name="intrigue_has_groupe_secondaire", indexes={@Index(name="fk_intrigue_has_groupe_secondaire_intrigue1_idx", columns={"intrigue_id"}), @Index(name="fk_intrigue_has_groupe_secondaire_secondary_group1_idx", columns={"secondary_group_id"})})
 * @InheritanceType("SINGLE_TABLE")
 * @DiscriminatorColumn(name="discr", type="string")
 * @DiscriminatorMap({"base":"BaseIntrigueHasGroupeSecondaire", "extended":"IntrigueHasGroupeSecondaire"})
 */
class BaseIntrigueHasGroupeSecondaire
{
    /**
     * @Id
     * @Column(type="integer", options={"unsigned":true})
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ManyToOne(targetEntity="Intrigue", inversedBy="intrigueHasGroupeSecondaires", cascade={"persist", "remove"})
     * @JoinColumn(name="intrigue_id", referencedColumnName="id", nullable=false)
     */
    protected $intrigue;

    /**
     * @ManyToOne(targetEntity="SecondaryGroup", inversedBy="intrigueHasGroupeSecondaires")
     * @JoinColumn(name="secondary_group_id", referencedColumnName="id", nullable=false)
     */
    protected $secondaryGroup;

    public function __construct()
    {
    }

    /**
     * Set the value of id.
     *
     * @param integer $id
     * @return \LarpManager\Entities\IntrigueHasGroupeSecondaire
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
     * Set Intrigue entity (many to one).
     *
     * @param \LarpManager\Entities\Intrigue $intrigue
     * @return \LarpManager\Entities\IntrigueHasGroupeSecondaire
     */
    public function setIntrigue(Intrigue $intrigue = null)
    {
        $this->intrigue = $intrigue;

        return $this;
    }

    /**
     * Get Intrigue entity (many to one).
     *
     * @return \LarpManager\Entities\Intrigue
     */
    public function getIntrigue()
    {
        return $this->intrigue;
    }

    /**
     * Set SecondaryGroup entity (many to one).
     *
     * @param \LarpManager\Entities\SecondaryGroup $secondaryGroup
     * @return \LarpManager\Entities\IntrigueHasGroupeSecondaire
     */
    public function setSecondaryGroup(SecondaryGroup $secondaryGroup = null)
    {
        $this->secondaryGroup = $secondaryGroup;

        return $this;
    }

    /**
     * Get SecondaryGroup entity (many to one).
     *
     * @return \LarpManager\Entities\SecondaryGroup
     */
    public function getSecondaryGroup()
    {
        return $this->secondaryGroup;
    }

    public function __sleep()
    {
        return array('id', 'intrigue_id', 'secondary_group_id');
    }
}