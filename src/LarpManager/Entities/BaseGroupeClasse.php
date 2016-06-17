<?php

/**
 * Auto generated by MySQL Workbench Schema Exporter.
 * Version 2.1.6-dev (doctrine2-annotation) on 2016-06-17 12:45:02.
 * Goto https://github.com/johmue/mysql-workbench-schema-exporter for more
 * information.
 */

namespace LarpManager\Entities;

/**
 * LarpManager\Entities\GroupeClasse
 *
 * @Entity()
 * @Table(name="groupe_classe", indexes={@Index(name="fk_groupe_classe_groupe1_idx", columns={"groupe_id"}), @Index(name="fk_groupe_classe_classe1_idx", columns={"classe_id"})})
 * @InheritanceType("SINGLE_TABLE")
 * @DiscriminatorColumn(name="discr", type="string")
 * @DiscriminatorMap({"base":"BaseGroupeClasse", "extended":"GroupeClasse"})
 */
class BaseGroupeClasse
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ManyToOne(targetEntity="Groupe", inversedBy="groupeClasses", cascade={"persist"})
     * @JoinColumn(name="groupe_id", referencedColumnName="id", nullable=false)
     */
    protected $groupe;

    /**
     * @ManyToOne(targetEntity="Classe", inversedBy="groupeClasses")
     * @JoinColumn(name="classe_id", referencedColumnName="id", nullable=false)
     */
    protected $classe;

    public function __construct()
    {
    }

    /**
     * Set the value of id.
     *
     * @param integer $id
     * @return \LarpManager\Entities\GroupeClasse
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
     * Set Groupe entity (many to one).
     *
     * @param \LarpManager\Entities\Groupe $groupe
     * @return \LarpManager\Entities\GroupeClasse
     */
    public function setGroupe(Groupe $groupe = null)
    {
        $this->groupe = $groupe;

        return $this;
    }

    /**
     * Get Groupe entity (many to one).
     *
     * @return \LarpManager\Entities\Groupe
     */
    public function getGroupe()
    {
        return $this->groupe;
    }

    /**
     * Set Classe entity (many to one).
     *
     * @param \LarpManager\Entities\Classe $classe
     * @return \LarpManager\Entities\GroupeClasse
     */
    public function setClasse(Classe $classe = null)
    {
        $this->classe = $classe;

        return $this;
    }

    /**
     * Get Classe entity (many to one).
     *
     * @return \LarpManager\Entities\Classe
     */
    public function getClasse()
    {
        return $this->classe;
    }

    public function __sleep()
    {
        return array('id', 'groupe_id', 'classe_id');
    }
}