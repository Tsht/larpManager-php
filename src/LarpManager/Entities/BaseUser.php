<?php

/**
 * Auto generated by MySQL Workbench Schema Exporter.
 * Version 2.1.6-dev (doctrine2-annotation) on 2015-08-17 21:48:58.
 * Goto https://github.com/johmue/mysql-workbench-schema-exporter for more
 * information.
 */

namespace LarpManager\Entities;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * LarpManager\Entities\User
 *
 * @Entity()
 * @Table(name="`user`", uniqueConstraints={@UniqueConstraint(name="email_UNIQUE", columns={"email"}), @UniqueConstraint(name="username_UNIQUE", columns={"username"}), @UniqueConstraint(name="id_UNIQUE", columns={"id"})})
 * @InheritanceType("SINGLE_TABLE")
 * @DiscriminatorColumn(name="discr", type="string")
 * @DiscriminatorMap({"base":"BaseUser", "extended":"User"})
 */
class BaseUser
{
    /**
     * @Id
     * @Column(type="integer", options={"unsigned":true})
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @Column(type="string", length=100)
     */
    protected $email;

    /**
     * @Column(name="`password`", type="string", length=255, nullable=true)
     */
    protected $password;

    /**
     * @Column(type="string", length=255)
     */
    protected $salt;

    /**
     * @Column(type="string", length=255)
     */
    protected $rights;

    /**
     * @Column(name="`name`", type="string", length=100)
     */
    protected $name;

    /**
     * @Column(type="datetime")
     */
    protected $creation_date;

    /**
     * @Column(type="string", length=100, nullable=true)
     */
    protected $username;

    /**
     * @Column(type="boolean")
     */
    protected $isEnabled;

    /**
     * @Column(type="string", length=100, nullable=true)
     */
    protected $confirmationToken;

    /**
     * @Column(type="integer", nullable=true, options={"unsigned":true})
     */
    protected $timePasswordResetRequested;

    /**
     * @OneToMany(targetEntity="Competence", mappedBy="user")
     * @JoinColumn(name="id", referencedColumnName="creator_id")
     */
    protected $competences;

    /**
     * @OneToMany(targetEntity="Groupe", mappedBy="userRelatedByScenaristeId")
     * @JoinColumn(name="id", referencedColumnName="scenariste_id")
     */
    protected $groupeRelatedByScenaristeIds;

    /**
     * @OneToMany(targetEntity="Groupe", mappedBy="userRelatedByCreatorId")
     * @JoinColumn(name="id", referencedColumnName="creator_id")
     */
    protected $groupeRelatedByCreatorIds;

    /**
     * @OneToMany(targetEntity="Groupe", mappedBy="userRelatedByResponsableId")
     * @JoinColumn(name="id", referencedColumnName="responsable_id")
     */
    protected $groupeRelatedByResponsableIds;

    /**
     * @OneToMany(targetEntity="Objet", mappedBy="userRelatedByResponsableId")
     * @JoinColumn(name="id", referencedColumnName="responsable_id")
     */
    protected $objetRelatedByResponsableIds;

    /**
     * @OneToMany(targetEntity="Objet", mappedBy="userRelatedByCreateurId")
     * @JoinColumn(name="id", referencedColumnName="createur_id")
     */
    protected $objetRelatedByCreateurIds;

    /**
     * @OneToMany(targetEntity="Pays", mappedBy="user")
     * @JoinColumn(name="id", referencedColumnName="creator_id")
     */
    protected $pays;

    /**
     * @OneToMany(targetEntity="Personnage", mappedBy="user")
     * @JoinColumn(name="id", referencedColumnName="user_id")
     */
    protected $personnages;

    /**
     * @OneToMany(targetEntity="Region", mappedBy="user")
     * @JoinColumn(name="id", referencedColumnName="creator_id")
     */
    protected $regions;

    /**
     * @ManyToMany(targetEntity="Groupe", mappedBy="users", cascade={"persist"})
     */
    protected $groupes;

    public function __construct()
    {
        $this->competences = new ArrayCollection();
        $this->groupeRelatedByScenaristeIds = new ArrayCollection();
        $this->groupeRelatedByCreatorIds = new ArrayCollection();
        $this->groupeRelatedByResponsableIds = new ArrayCollection();
        $this->objetRelatedByResponsableIds = new ArrayCollection();
        $this->objetRelatedByCreateurIds = new ArrayCollection();
        $this->pays = new ArrayCollection();
        $this->personnages = new ArrayCollection();
        $this->regions = new ArrayCollection();
        $this->groupes = new ArrayCollection();
    }

    /**
     * Set the value of id.
     *
     * @param integer $id
     * @return \LarpManager\Entities\User
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
     * Set the value of email.
     *
     * @param string $email
     * @return \LarpManager\Entities\User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of email.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of password.
     *
     * @param string $password
     * @return \LarpManager\Entities\User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of password.
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of salt.
     *
     * @param string $salt
     * @return \LarpManager\Entities\User
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Get the value of salt.
     *
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Set the value of rights.
     *
     * @param string $rights
     * @return \LarpManager\Entities\User
     */
    public function setRights($rights)
    {
        $this->rights = $rights;

        return $this;
    }

    /**
     * Get the value of rights.
     *
     * @return string
     */
    public function getRights()
    {
        return $this->rights;
    }

    /**
     * Set the value of name.
     *
     * @param string $name
     * @return \LarpManager\Entities\User
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of creation_date.
     *
     * @param \DateTime $creation_date
     * @return \LarpManager\Entities\User
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
     * Set the value of username.
     *
     * @param string $username
     * @return \LarpManager\Entities\User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get the value of username.
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set the value of isEnabled.
     *
     * @param boolean $isEnabled
     * @return \LarpManager\Entities\User
     */
    public function setIsEnabled($isEnabled)
    {
        $this->isEnabled = $isEnabled;

        return $this;
    }

    /**
     * Get the value of isEnabled.
     *
     * @return boolean
     */
    public function getIsEnabled()
    {
        return $this->isEnabled;
    }

    /**
     * Set the value of confirmationToken.
     *
     * @param string $confirmationToken
     * @return \LarpManager\Entities\User
     */
    public function setConfirmationToken($confirmationToken)
    {
        $this->confirmationToken = $confirmationToken;

        return $this;
    }

    /**
     * Get the value of confirmationToken.
     *
     * @return string
     */
    public function getConfirmationToken()
    {
        return $this->confirmationToken;
    }

    /**
     * Set the value of timePasswordResetRequested.
     *
     * @param integer $timePasswordResetRequested
     * @return \LarpManager\Entities\User
     */
    public function setTimePasswordResetRequested($timePasswordResetRequested)
    {
        $this->timePasswordResetRequested = $timePasswordResetRequested;

        return $this;
    }

    /**
     * Get the value of timePasswordResetRequested.
     *
     * @return integer
     */
    public function getTimePasswordResetRequested()
    {
        return $this->timePasswordResetRequested;
    }

    /**
     * Add Competence entity to collection (one to many).
     *
     * @param \LarpManager\Entities\Competence $competence
     * @return \LarpManager\Entities\User
     */
    public function addCompetence(Competence $competence)
    {
        $this->competences[] = $competence;

        return $this;
    }

    /**
     * Remove Competence entity from collection (one to many).
     *
     * @param \LarpManager\Entities\Competence $competence
     * @return \LarpManager\Entities\User
     */
    public function removeCompetence(Competence $competence)
    {
        $this->competences->removeElement($competence);

        return $this;
    }

    /**
     * Get Competence entity collection (one to many).
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCompetences()
    {
        return $this->competences;
    }

    /**
     * Add Groupe entity related by `scenariste_id` to collection (one to many).
     *
     * @param \LarpManager\Entities\Groupe $groupe
     * @return \LarpManager\Entities\User
     */
    public function addGroupeRelatedByScenaristeId(Groupe $groupe)
    {
        $this->groupeRelatedByScenaristeIds[] = $groupe;

        return $this;
    }

    /**
     * Remove Groupe entity related by `scenariste_id` from collection (one to many).
     *
     * @param \LarpManager\Entities\Groupe $groupe
     * @return \LarpManager\Entities\User
     */
    public function removeGroupeRelatedByScenaristeId(Groupe $groupe)
    {
        $this->groupeRelatedByScenaristeIds->removeElement($groupe);

        return $this;
    }

    /**
     * Get Groupe entity related by `scenariste_id` collection (one to many).
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGroupeRelatedByScenaristeIds()
    {
        return $this->groupeRelatedByScenaristeIds;
    }

    /**
     * Add Groupe entity related by `creator_id` to collection (one to many).
     *
     * @param \LarpManager\Entities\Groupe $groupe
     * @return \LarpManager\Entities\User
     */
    public function addGroupeRelatedByCreatorId(Groupe $groupe)
    {
        $this->groupeRelatedByCreatorIds[] = $groupe;

        return $this;
    }

    /**
     * Remove Groupe entity related by `creator_id` from collection (one to many).
     *
     * @param \LarpManager\Entities\Groupe $groupe
     * @return \LarpManager\Entities\User
     */
    public function removeGroupeRelatedByCreatorId(Groupe $groupe)
    {
        $this->groupeRelatedByCreatorIds->removeElement($groupe);

        return $this;
    }

    /**
     * Get Groupe entity related by `creator_id` collection (one to many).
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGroupeRelatedByCreatorIds()
    {
        return $this->groupeRelatedByCreatorIds;
    }

    /**
     * Add Groupe entity related by `responsable_id` to collection (one to many).
     *
     * @param \LarpManager\Entities\Groupe $groupe
     * @return \LarpManager\Entities\User
     */
    public function addGroupeRelatedByResponsableId(Groupe $groupe)
    {
        $this->groupeRelatedByResponsableIds[] = $groupe;

        return $this;
    }

    /**
     * Remove Groupe entity related by `responsable_id` from collection (one to many).
     *
     * @param \LarpManager\Entities\Groupe $groupe
     * @return \LarpManager\Entities\User
     */
    public function removeGroupeRelatedByResponsableId(Groupe $groupe)
    {
        $this->groupeRelatedByResponsableIds->removeElement($groupe);

        return $this;
    }

    /**
     * Get Groupe entity related by `responsable_id` collection (one to many).
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGroupeRelatedByResponsableIds()
    {
        return $this->groupeRelatedByResponsableIds;
    }

    /**
     * Add Objet entity related by `responsable_id` to collection (one to many).
     *
     * @param \LarpManager\Entities\Objet $objet
     * @return \LarpManager\Entities\User
     */
    public function addObjetRelatedByResponsableId(Objet $objet)
    {
        $this->objetRelatedByResponsableIds[] = $objet;

        return $this;
    }

    /**
     * Remove Objet entity related by `responsable_id` from collection (one to many).
     *
     * @param \LarpManager\Entities\Objet $objet
     * @return \LarpManager\Entities\User
     */
    public function removeObjetRelatedByResponsableId(Objet $objet)
    {
        $this->objetRelatedByResponsableIds->removeElement($objet);

        return $this;
    }

    /**
     * Get Objet entity related by `responsable_id` collection (one to many).
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getObjetRelatedByResponsableIds()
    {
        return $this->objetRelatedByResponsableIds;
    }

    /**
     * Add Objet entity related by `createur_id` to collection (one to many).
     *
     * @param \LarpManager\Entities\Objet $objet
     * @return \LarpManager\Entities\User
     */
    public function addObjetRelatedByCreateurId(Objet $objet)
    {
        $this->objetRelatedByCreateurIds[] = $objet;

        return $this;
    }

    /**
     * Remove Objet entity related by `createur_id` from collection (one to many).
     *
     * @param \LarpManager\Entities\Objet $objet
     * @return \LarpManager\Entities\User
     */
    public function removeObjetRelatedByCreateurId(Objet $objet)
    {
        $this->objetRelatedByCreateurIds->removeElement($objet);

        return $this;
    }

    /**
     * Get Objet entity related by `createur_id` collection (one to many).
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getObjetRelatedByCreateurIds()
    {
        return $this->objetRelatedByCreateurIds;
    }

    /**
     * Add Pays entity to collection (one to many).
     *
     * @param \LarpManager\Entities\Pays $pays
     * @return \LarpManager\Entities\User
     */
    public function addPays(Pays $pays)
    {
        $this->pays[] = $pays;

        return $this;
    }

    /**
     * Remove Pays entity from collection (one to many).
     *
     * @param \LarpManager\Entities\Pays $pays
     * @return \LarpManager\Entities\User
     */
    public function removePays(Pays $pays)
    {
        $this->pays->removeElement($pays);

        return $this;
    }

    /**
     * Get Pays entity collection (one to many).
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPays()
    {
        return $this->pays;
    }

    /**
     * Add Personnage entity to collection (one to many).
     *
     * @param \LarpManager\Entities\Personnage $personnage
     * @return \LarpManager\Entities\User
     */
    public function addPersonnage(Personnage $personnage)
    {
        $this->personnages[] = $personnage;

        return $this;
    }

    /**
     * Remove Personnage entity from collection (one to many).
     *
     * @param \LarpManager\Entities\Personnage $personnage
     * @return \LarpManager\Entities\User
     */
    public function removePersonnage(Personnage $personnage)
    {
        $this->personnages->removeElement($personnage);

        return $this;
    }

    /**
     * Get Personnage entity collection (one to many).
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPersonnages()
    {
        return $this->personnages;
    }

    /**
     * Add Region entity to collection (one to many).
     *
     * @param \LarpManager\Entities\Region $region
     * @return \LarpManager\Entities\User
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
     * @return \LarpManager\Entities\User
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
     * Add Groupe entity to collection.
     *
     * @param \LarpManager\Entities\Groupe $groupe
     * @return \LarpManager\Entities\User
     */
    public function addGroupe(Groupe $groupe)
    {
        $this->groupes[] = $groupe;

        return $this;
    }

    /**
     * Remove Groupe entity from collection.
     *
     * @param \LarpManager\Entities\Groupe $groupe
     * @return \LarpManager\Entities\User
     */
    public function removeGroupe(Groupe $groupe)
    {
        $this->groupes->removeElement($groupe);

        return $this;
    }

    /**
     * Get Groupe entity collection.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGroupes()
    {
        return $this->groupes;
    }

    public function __sleep()
    {
        return array('id', 'email', 'password', 'salt', 'rights', 'name', 'creation_date', 'username', 'isEnabled', 'confirmationToken', 'timePasswordResetRequested');
    }
}