<?php

/**
 * Auto generated by MySQL Workbench Schema Exporter.
 * Version 2.1.6-dev (doctrine2-annotation) on 2016-07-18 10:52:46.
 * Goto https://github.com/johmue/mysql-workbench-schema-exporter for more
 * information.
 */

namespace LarpManager\Entities;

/**
 * LarpManager\Entities\GroupeAllie
 *
 * @Entity()
 * @Table(name="groupe_allie", indexes={@Index(name="fk_groupe_allie_groupe1_idx", columns={"groupe_id"}), @Index(name="fk_groupe_allie_groupe2_idx", columns={"groupe_allie_id"})})
 * @InheritanceType("SINGLE_TABLE")
 * @DiscriminatorColumn(name="discr", type="string")
 * @DiscriminatorMap({"base":"BaseGroupeAllie", "extended":"GroupeAllie"})
 */
class BaseGroupeAllie
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @Column(type="boolean")
     */
    protected $groupe_accepted;

    /**
     * @Column(type="boolean")
     */
    protected $groupe_allie_accepted;

    /**
     * @Column(type="text", nullable=true)
     */
    protected $message;

    /**
     * @Column(type="text", nullable=true)
     */
    protected $message_allie;

    /**
     * @ManyToOne(targetEntity="Groupe", inversedBy="groupeAllieRelatedByGroupeIds")
     * @JoinColumn(name="groupe_id", referencedColumnName="id", nullable=false)
     */
    protected $groupeRelatedByGroupeId;

    /**
     * @ManyToOne(targetEntity="Groupe", inversedBy="groupeAllieRelatedByGroupeAllieIds")
     * @JoinColumn(name="groupe_allie_id", referencedColumnName="id", nullable=false)
     */
    protected $groupeRelatedByGroupeAllieId;

    public function __construct()
    {
    }

    /**
     * Set the value of id.
     *
     * @param integer $id
     * @return \LarpManager\Entities\GroupeAllie
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
     * Set the value of groupe_accepted.
     *
     * @param boolean $groupe_accepted
     * @return \LarpManager\Entities\GroupeAllie
     */
    public function setGroupeAccepted($groupe_accepted)
    {
        $this->groupe_accepted = $groupe_accepted;

        return $this;
    }

    /**
     * Get the value of groupe_accepted.
     *
     * @return boolean
     */
    public function getGroupeAccepted()
    {
        return $this->groupe_accepted;
    }

    /**
     * Set the value of groupe_allie_accepted.
     *
     * @param boolean $groupe_allie_accepted
     * @return \LarpManager\Entities\GroupeAllie
     */
    public function setGroupeAllieAccepted($groupe_allie_accepted)
    {
        $this->groupe_allie_accepted = $groupe_allie_accepted;

        return $this;
    }

    /**
     * Get the value of groupe_allie_accepted.
     *
     * @return boolean
     */
    public function getGroupeAllieAccepted()
    {
        return $this->groupe_allie_accepted;
    }

    /**
     * Set the value of message.
     *
     * @param string $message
     * @return \LarpManager\Entities\GroupeAllie
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get the value of message.
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set the value of message_allie.
     *
     * @param string $message_allie
     * @return \LarpManager\Entities\GroupeAllie
     */
    public function setMessageAllie($message_allie)
    {
        $this->message_allie = $message_allie;

        return $this;
    }

    /**
     * Get the value of message_allie.
     *
     * @return string
     */
    public function getMessageAllie()
    {
        return $this->message_allie;
    }

    /**
     * Set Groupe entity related by `groupe_id` (many to one).
     *
     * @param \LarpManager\Entities\Groupe $groupe
     * @return \LarpManager\Entities\GroupeAllie
     */
    public function setGroupeRelatedByGroupeId(Groupe $groupe = null)
    {
        $this->groupeRelatedByGroupeId = $groupe;

        return $this;
    }

    /**
     * Get Groupe entity related by `groupe_id` (many to one).
     *
     * @return \LarpManager\Entities\Groupe
     */
    public function getGroupeRelatedByGroupeId()
    {
        return $this->groupeRelatedByGroupeId;
    }

    /**
     * Set Groupe entity related by `groupe_allie_id` (many to one).
     *
     * @param \LarpManager\Entities\Groupe $groupe
     * @return \LarpManager\Entities\GroupeAllie
     */
    public function setGroupeRelatedByGroupeAllieId(Groupe $groupe = null)
    {
        $this->groupeRelatedByGroupeAllieId = $groupe;

        return $this;
    }

    /**
     * Get Groupe entity related by `groupe_allie_id` (many to one).
     *
     * @return \LarpManager\Entities\Groupe
     */
    public function getGroupeRelatedByGroupeAllieId()
    {
        return $this->groupeRelatedByGroupeAllieId;
    }

    public function __sleep()
    {
        return array('id', 'groupe_id', 'groupe_allie_id', 'groupe_accepted', 'groupe_allie_accepted', 'message', 'message_allie');
    }
}