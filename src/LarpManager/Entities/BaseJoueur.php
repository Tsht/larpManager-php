<?php

/**
 * Auto generated by MySQL Workbench Schema Exporter.
 * Version 2.1.6-dev (doctrine2-annotation) on 2015-09-02 09:31:05.
 * Goto https://github.com/johmue/mysql-workbench-schema-exporter for more
 * information.
 */

namespace LarpManager\Entities;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * LarpManager\Entities\Joueur
 *
 * @Entity()
 * @Table(name="joueur", indexes={@Index(name="fk_joueur_personnage1_idx", columns={"personnage_id"})})
 * @InheritanceType("SINGLE_TABLE")
 * @DiscriminatorColumn(name="discr", type="string")
 * @DiscriminatorMap({"base":"BaseJoueur", "extended":"Joueur"})
 */
class BaseJoueur
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @Column(type="string", length=45, nullable=true)
     */
    protected $nom;

    /**
     * @Column(type="string", length=45, nullable=true)
     */
    protected $prenom;

    /**
     * @Column(type="string", length=45, nullable=true)
     */
    protected $prenom_usage;

    /**
     * @Column(type="string", length=45, nullable=true)
     */
    protected $telephone;

    /**
     * @Column(type="string", length=45, nullable=true)
     */
    protected $photo;

    /**
     * @Column(type="text", nullable=true)
     */
    protected $probleme_medicaux;

    /**
     * @Column(type="string", length=45, nullable=true)
     */
    protected $personne_a_prevenir;

    /**
     * @Column(type="string", length=45, nullable=true)
     */
    protected $tel_pap;

    /**
     * @Column(type="string", length=45, nullable=true)
     */
    protected $fedegn;

    /**
     * @Column(type="datetime")
     */
    protected $creation_date;

    /**
     * @Column(type="datetime")
     */
    protected $update_date;

    /**
     * @OneToMany(targetEntity="JoueurGn", mappedBy="joueur", cascade={"persist"})
     * @JoinColumn(name="id", referencedColumnName="joueur_id")
     */
    protected $joueurGns;

    /**
     * @OneToOne(targetEntity="User", mappedBy="joueur")
     */
    protected $user;

    /**
     * @OneToOne(targetEntity="Personnage", inversedBy="joueur")
     * @JoinColumn(name="personnage_id", referencedColumnName="id")
     */
    protected $personnage;

    /**
     * @ManyToMany(targetEntity="Groupe", inversedBy="joueurs")
     * @JoinTable(name="joueur_groupe",
     *     joinColumns={@JoinColumn(name="joueur_id", referencedColumnName="id")},
     *     inverseJoinColumns={@JoinColumn(name="groupe_id", referencedColumnName="id")}
     * )
     */
    protected $groupes;

    public function __construct()
    {
        $this->joueurGns = new ArrayCollection();
        $this->users = new ArrayCollection();
        $this->groupes = new ArrayCollection();
    }

    /**
     * Set the value of id.
     *
     * @param integer $id
     * @return \LarpManager\Entities\Joueur
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
     * @return \LarpManager\Entities\Joueur
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
     * Set the value of prenom.
     *
     * @param string $prenom
     * @return \LarpManager\Entities\Joueur
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get the value of prenom.
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set the value of prenom_usage.
     *
     * @param string $prenom_usage
     * @return \LarpManager\Entities\Joueur
     */
    public function setPrenomUsage($prenom_usage)
    {
        $this->prenom_usage = $prenom_usage;

        return $this;
    }

    /**
     * Get the value of prenom_usage.
     *
     * @return string
     */
    public function getPrenomUsage()
    {
        return $this->prenom_usage;
    }

    /**
     * Set the value of telephone.
     *
     * @param string $telephone
     * @return \LarpManager\Entities\Joueur
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * Get the value of telephone.
     *
     * @return string
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Set the value of photo.
     *
     * @param string $photo
     * @return \LarpManager\Entities\Joueur
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * Get the value of photo.
     *
     * @return string
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * Set the value of probleme_medicaux.
     *
     * @param string $probleme_medicaux
     * @return \LarpManager\Entities\Joueur
     */
    public function setProblemeMedicaux($probleme_medicaux)
    {
        $this->probleme_medicaux = $probleme_medicaux;

        return $this;
    }

    /**
     * Get the value of probleme_medicaux.
     *
     * @return string
     */
    public function getProblemeMedicaux()
    {
        return $this->probleme_medicaux;
    }

    /**
     * Set the value of personne_a_prevenir.
     *
     * @param string $personne_a_prevenir
     * @return \LarpManager\Entities\Joueur
     */
    public function setPersonneAPrevenir($personne_a_prevenir)
    {
        $this->personne_a_prevenir = $personne_a_prevenir;

        return $this;
    }

    /**
     * Get the value of personne_a_prevenir.
     *
     * @return string
     */
    public function getPersonneAPrevenir()
    {
        return $this->personne_a_prevenir;
    }

    /**
     * Set the value of tel_pap.
     *
     * @param string $tel_pap
     * @return \LarpManager\Entities\Joueur
     */
    public function setTelPap($tel_pap)
    {
        $this->tel_pap = $tel_pap;

        return $this;
    }

    /**
     * Get the value of tel_pap.
     *
     * @return string
     */
    public function getTelPap()
    {
        return $this->tel_pap;
    }

    /**
     * Set the value of fedegn.
     *
     * @param string $fedegn
     * @return \LarpManager\Entities\Joueur
     */
    public function setFedegn($fedegn)
    {
        $this->fedegn = $fedegn;

        return $this;
    }

    /**
     * Get the value of fedegn.
     *
     * @return string
     */
    public function getFedegn()
    {
        return $this->fedegn;
    }

    /**
     * Set the value of creation_date.
     *
     * @param \DateTime $creation_date
     * @return \LarpManager\Entities\Joueur
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
     * @return \LarpManager\Entities\Joueur
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
     * Add JoueurGn entity to collection (one to many).
     *
     * @param \LarpManager\Entities\JoueurGn $joueurGn
     * @return \LarpManager\Entities\Joueur
     */
    public function addJoueurGn(JoueurGn $joueurGn)
    {
        $this->joueurGns[] = $joueurGn;

        return $this;
    }

    /**
     * Remove JoueurGn entity from collection (one to many).
     *
     * @param \LarpManager\Entities\JoueurGn $joueurGn
     * @return \LarpManager\Entities\Joueur
     */
    public function removeJoueurGn(JoueurGn $joueurGn)
    {
        $this->joueurGns->removeElement($joueurGn);

        return $this;
    }

    /**
     * Get JoueurGn entity collection (one to many).
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getJoueurGns()
    {
        return $this->joueurGns;
    }

    /**
     * Set User entity (one to one).
     *
     * @param \LarpManager\Entities\User $user
     * @return \LarpManager\Entities\Joueur
     */
    public function setUser(User $user = null)
    {
        $user->setJoueur($this);
        $this->user = $user;

        return $this;
    }

    /**
     * Get User entity (one to one).
     *
     * @return \LarpManager\Entities\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set Personnage entity (one to one).
     *
     * @param \LarpManager\Entities\Personnage $personnage
     * @return \LarpManager\Entities\Joueur
     */
    public function setPersonnage(Personnage $personnage)
    {
        $this->personnage = $personnage;

        return $this;
    }

    /**
     * Get Personnage entity (one to one).
     *
     * @return \LarpManager\Entities\Personnage
     */
    public function getPersonnage()
    {
        return $this->personnage;
    }

    /**
     * Add Groupe entity to collection.
     *
     * @param \LarpManager\Entities\Groupe $groupe
     * @return \LarpManager\Entities\Joueur
     */
    public function addGroupe(Groupe $groupe)
    {
        $groupe->addJoueur($this);
        $this->groupes[] = $groupe;

        return $this;
    }

    /**
     * Remove Groupe entity from collection.
     *
     * @param \LarpManager\Entities\Groupe $groupe
     * @return \LarpManager\Entities\Joueur
     */
    public function removeGroupe(Groupe $groupe)
    {
        $groupe->removeJoueur($this);
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
        return array('id', 'personnage_id', 'nom', 'prenom', 'prenom_usage', 'telephone', 'photo', 'probleme_medicaux', 'personne_a_prevenir', 'tel_pap', 'fedegn', 'creation_date', 'update_date');
    }
}