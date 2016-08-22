<?php

/**
 * Auto generated by MySQL Workbench Schema Exporter.
 * Version 2.1.6-dev (doctrine2-annotation) on 2016-08-22 11:27:20.
 * Goto https://github.com/johmue/mysql-workbench-schema-exporter for more
 * information.
 */

namespace LarpManager\Entities;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * LarpManager\Entities\Personnage
 *
 * @Entity()
 * @Table(name="personnage", indexes={@Index(name="fk_personnage_groupe1_idx", columns={"groupe_id"}), @Index(name="fk_personnage_archetype1_idx", columns={"classe_id"}), @Index(name="fk_personnage_age1_idx", columns={"age_id"}), @Index(name="fk_personnage_genre1_idx", columns={"genre_id"}), @Index(name="fk_personnage_joueur1_idx", columns={"joueur_id"}), @Index(name="fk_personnage_territoire1_idx", columns={"territoire_id"})})
 * @InheritanceType("SINGLE_TABLE")
 * @DiscriminatorColumn(name="discr", type="string")
 * @DiscriminatorMap({"base":"BasePersonnage", "extended":"Personnage"})
 */
class BasePersonnage
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
     * @Column(type="string", length=100, nullable=true)
     */
    protected $surnom;

    /**
     * @Column(type="boolean", nullable=true)
     */
    protected $intrigue;

    /**
     * @Column(type="integer", nullable=true)
     */
    protected $renomme;

    /**
     * @Column(type="string", length=100, nullable=true)
     */
    protected $photo;

    /**
     * @Column(type="integer", nullable=true)
     */
    protected $xp;

    /**
     * @Column(type="text", nullable=true)
     */
    protected $materiel;

    /**
     * @Column(type="boolean")
     */
    protected $vivant;

    /**
     * @Column(type="integer", nullable=true)
     */
    protected $age_reel;

    /**
     * @Column(type="string", length=45, nullable=true)
     */
    protected $trombineUrl;

    /**
     * @OneToMany(targetEntity="ExperienceGain", mappedBy="personnage")
     * @JoinColumn(name="id", referencedColumnName="personnage_id", nullable=false)
     */
    protected $experienceGains;

    /**
     * @OneToMany(targetEntity="ExperienceUsage", mappedBy="personnage")
     * @JoinColumn(name="id", referencedColumnName="personnage_id", nullable=false)
     */
    protected $experienceUsages;

    /**
     * @OneToMany(targetEntity="Membre", mappedBy="personnage")
     * @JoinColumn(name="id", referencedColumnName="personnage_id", nullable=false)
     */
    protected $membres;

    /**
     * @OneToMany(targetEntity="PersonnageBackground", mappedBy="personnage")
     * @JoinColumn(name="id", referencedColumnName="personnage_id", nullable=false)
     */
    protected $personnageBackgrounds;

    /**
     * @OneToMany(targetEntity="PersonnageHasToken", mappedBy="personnage")
     * @JoinColumn(name="id", referencedColumnName="personnage_id", nullable=false)
     */
    protected $personnageHasTokens;

    /**
     * @OneToMany(targetEntity="PersonnageLangues", mappedBy="personnage")
     * @JoinColumn(name="id", referencedColumnName="personnage_id", nullable=false)
     */
    protected $personnageLangues;

    /**
     * @OneToMany(targetEntity="PersonnageTrigger", mappedBy="personnage")
     * @JoinColumn(name="id", referencedColumnName="personnage_id", nullable=false)
     */
    protected $personnageTriggers;

    /**
     * @OneToMany(targetEntity="PersonnagesReligions", mappedBy="personnage")
     * @JoinColumn(name="id", referencedColumnName="personnage_id", nullable=false)
     */
    protected $personnagesReligions;

    /**
     * @OneToMany(targetEntity="Postulant", mappedBy="personnage")
     * @JoinColumn(name="id", referencedColumnName="personnage_id", nullable=false)
     */
    protected $postulants;

    /**
     * @OneToMany(targetEntity="SecondaryGroup", mappedBy="personnage")
     * @JoinColumn(name="id", referencedColumnName="personnage_id", nullable=false)
     */
    protected $secondaryGroups;

    /**
     * @ManyToOne(targetEntity="Groupe", inversedBy="personnages")
     * @JoinColumn(name="groupe_id", referencedColumnName="id")
     */
    protected $groupe;

    /**
     * @ManyToOne(targetEntity="Classe", inversedBy="personnages")
     * @JoinColumn(name="classe_id", referencedColumnName="id", nullable=false)
     */
    protected $classe;

    /**
     * @ManyToOne(targetEntity="Age", inversedBy="personnages")
     * @JoinColumn(name="age_id", referencedColumnName="id", nullable=false)
     */
    protected $age;

    /**
     * @ManyToOne(targetEntity="Genre", inversedBy="personnages")
     * @JoinColumn(name="genre_id", referencedColumnName="id", nullable=false)
     */
    protected $genre;

    /**
     * @OneToOne(targetEntity="Participant", inversedBy="personnage")
     * @JoinColumn(name="joueur_id", referencedColumnName="id")
     */
    protected $participant;

    /**
     * @ManyToOne(targetEntity="Territoire", inversedBy="personnages")
     * @JoinColumn(name="territoire_id", referencedColumnName="id")
     */
    protected $territoire;

    /**
     * @ManyToMany(targetEntity="Document", inversedBy="personnages")
     * @JoinTable(name="personnage_has_document",
     *     joinColumns={@JoinColumn(name="personnage_id", referencedColumnName="id", nullable=false)},
     *     inverseJoinColumns={@JoinColumn(name="Document_id", referencedColumnName="id", nullable=false)}
     * )
     */
    protected $documents;

    /**
     * @ManyToMany(targetEntity="Competence", mappedBy="personnages")
     */
    protected $competences;

    /**
     * @ManyToMany(targetEntity="Domaine", inversedBy="personnages")
     * @JoinTable(name="personnages_domaines",
     *     joinColumns={@JoinColumn(name="personnage_id", referencedColumnName="id", nullable=false)},
     *     inverseJoinColumns={@JoinColumn(name="domaine_id", referencedColumnName="id", nullable=false)}
     * )
     */
    protected $domaines;

    /**
     * @ManyToMany(targetEntity="Potion", inversedBy="personnages")
     * @JoinTable(name="personnages_potions",
     *     joinColumns={@JoinColumn(name="personnage_id", referencedColumnName="id", nullable=false)},
     *     inverseJoinColumns={@JoinColumn(name="potion_id", referencedColumnName="id", nullable=false)}
     * )
     */
    protected $potions;

    /**
     * @ManyToMany(targetEntity="Priere", mappedBy="personnages")
     */
    protected $prieres;

    /**
     * @ManyToMany(targetEntity="Sort", inversedBy="personnages")
     * @JoinTable(name="personnages_sorts",
     *     joinColumns={@JoinColumn(name="personnage_id", referencedColumnName="id", nullable=false)},
     *     inverseJoinColumns={@JoinColumn(name="sort_id", referencedColumnName="id", nullable=false)}
     * )
     */
    protected $sorts;

    /**
     * @ManyToMany(targetEntity="User", mappedBy="personnages")
     */
    protected $users;

    public function __construct()
    {
        $this->experienceGains = new ArrayCollection();
        $this->experienceUsages = new ArrayCollection();
        $this->membres = new ArrayCollection();
        $this->personnageBackgrounds = new ArrayCollection();
        $this->personnageHasTokens = new ArrayCollection();
        $this->personnageLangues = new ArrayCollection();
        $this->personnageTriggers = new ArrayCollection();
        $this->personnagesReligions = new ArrayCollection();
        $this->postulants = new ArrayCollection();
        $this->secondaryGroups = new ArrayCollection();
        $this->documents = new ArrayCollection();
        $this->competences = new ArrayCollection();
        $this->domaines = new ArrayCollection();
        $this->potions = new ArrayCollection();
        $this->prieres = new ArrayCollection();
        $this->sorts = new ArrayCollection();
        $this->users = new ArrayCollection();
    }

    /**
     * Set the value of id.
     *
     * @param integer $id
     * @return \LarpManager\Entities\Personnage
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
     * @return \LarpManager\Entities\Personnage
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
     * Set the value of surnom.
     *
     * @param string $surnom
     * @return \LarpManager\Entities\Personnage
     */
    public function setSurnom($surnom)
    {
        $this->surnom = $surnom;

        return $this;
    }

    /**
     * Get the value of surnom.
     *
     * @return string
     */
    public function getSurnom()
    {
        return $this->surnom;
    }

    /**
     * Set the value of intrigue.
     *
     * @param boolean $intrigue
     * @return \LarpManager\Entities\Personnage
     */
    public function setIntrigue($intrigue)
    {
        $this->intrigue = $intrigue;

        return $this;
    }

    /**
     * Get the value of intrigue.
     *
     * @return boolean
     */
    public function getIntrigue()
    {
        return $this->intrigue;
    }

    /**
     * Set the value of renomme.
     *
     * @param integer $renomme
     * @return \LarpManager\Entities\Personnage
     */
    public function setRenomme($renomme)
    {
        $this->renomme = $renomme;

        return $this;
    }

    /**
     * Get the value of renomme.
     *
     * @return integer
     */
    public function getRenomme()
    {
        return $this->renomme;
    }

    /**
     * Set the value of photo.
     *
     * @param string $photo
     * @return \LarpManager\Entities\Personnage
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
     * Set the value of xp.
     *
     * @param integer $xp
     * @return \LarpManager\Entities\Personnage
     */
    public function setXp($xp)
    {
        $this->xp = $xp;

        return $this;
    }

    /**
     * Get the value of xp.
     *
     * @return integer
     */
    public function getXp()
    {
        return $this->xp;
    }

    /**
     * Set the value of materiel.
     *
     * @param string $materiel
     * @return \LarpManager\Entities\Personnage
     */
    public function setMateriel($materiel)
    {
        $this->materiel = $materiel;

        return $this;
    }

    /**
     * Get the value of materiel.
     *
     * @return string
     */
    public function getMateriel()
    {
        return $this->materiel;
    }

    /**
     * Set the value of vivant.
     *
     * @param boolean $vivant
     * @return \LarpManager\Entities\Personnage
     */
    public function setVivant($vivant)
    {
        $this->vivant = $vivant;

        return $this;
    }

    /**
     * Get the value of vivant.
     *
     * @return boolean
     */
    public function getVivant()
    {
        return $this->vivant;
    }

    /**
     * Set the value of age_reel.
     *
     * @param integer $age_reel
     * @return \LarpManager\Entities\Personnage
     */
    public function setAgeReel($age_reel)
    {
        $this->age_reel = $age_reel;

        return $this;
    }

    /**
     * Get the value of age_reel.
     *
     * @return integer
     */
    public function getAgeReel()
    {
        return $this->age_reel;
    }

    /**
     * Set the value of trombineUrl.
     *
     * @param string $trombineUrl
     * @return \LarpManager\Entities\Personnage
     */
    public function setTrombineUrl($trombineUrl)
    {
        $this->trombineUrl = $trombineUrl;

        return $this;
    }

    /**
     * Get the value of trombineUrl.
     *
     * @return string
     */
    public function getTrombineUrl()
    {
        return $this->trombineUrl;
    }

    /**
     * Add ExperienceGain entity to collection (one to many).
     *
     * @param \LarpManager\Entities\ExperienceGain $experienceGain
     * @return \LarpManager\Entities\Personnage
     */
    public function addExperienceGain(ExperienceGain $experienceGain)
    {
        $this->experienceGains[] = $experienceGain;

        return $this;
    }

    /**
     * Remove ExperienceGain entity from collection (one to many).
     *
     * @param \LarpManager\Entities\ExperienceGain $experienceGain
     * @return \LarpManager\Entities\Personnage
     */
    public function removeExperienceGain(ExperienceGain $experienceGain)
    {
        $this->experienceGains->removeElement($experienceGain);

        return $this;
    }

    /**
     * Get ExperienceGain entity collection (one to many).
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getExperienceGains()
    {
        return $this->experienceGains;
    }

    /**
     * Add ExperienceUsage entity to collection (one to many).
     *
     * @param \LarpManager\Entities\ExperienceUsage $experienceUsage
     * @return \LarpManager\Entities\Personnage
     */
    public function addExperienceUsage(ExperienceUsage $experienceUsage)
    {
        $this->experienceUsages[] = $experienceUsage;

        return $this;
    }

    /**
     * Remove ExperienceUsage entity from collection (one to many).
     *
     * @param \LarpManager\Entities\ExperienceUsage $experienceUsage
     * @return \LarpManager\Entities\Personnage
     */
    public function removeExperienceUsage(ExperienceUsage $experienceUsage)
    {
        $this->experienceUsages->removeElement($experienceUsage);

        return $this;
    }

    /**
     * Get ExperienceUsage entity collection (one to many).
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getExperienceUsages()
    {
        return $this->experienceUsages;
    }

    /**
     * Add Membre entity to collection (one to many).
     *
     * @param \LarpManager\Entities\Membre $membre
     * @return \LarpManager\Entities\Personnage
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
     * @return \LarpManager\Entities\Personnage
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
     * Add PersonnageBackground entity to collection (one to many).
     *
     * @param \LarpManager\Entities\PersonnageBackground $personnageBackground
     * @return \LarpManager\Entities\Personnage
     */
    public function addPersonnageBackground(PersonnageBackground $personnageBackground)
    {
        $this->personnageBackgrounds[] = $personnageBackground;

        return $this;
    }

    /**
     * Remove PersonnageBackground entity from collection (one to many).
     *
     * @param \LarpManager\Entities\PersonnageBackground $personnageBackground
     * @return \LarpManager\Entities\Personnage
     */
    public function removePersonnageBackground(PersonnageBackground $personnageBackground)
    {
        $this->personnageBackgrounds->removeElement($personnageBackground);

        return $this;
    }

    /**
     * Get PersonnageBackground entity collection (one to many).
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPersonnageBackgrounds()
    {
        return $this->personnageBackgrounds;
    }

    /**
     * Add PersonnageHasToken entity to collection (one to many).
     *
     * @param \LarpManager\Entities\PersonnageHasToken $personnageHasToken
     * @return \LarpManager\Entities\Personnage
     */
    public function addPersonnageHasToken(PersonnageHasToken $personnageHasToken)
    {
        $this->personnageHasTokens[] = $personnageHasToken;

        return $this;
    }

    /**
     * Remove PersonnageHasToken entity from collection (one to many).
     *
     * @param \LarpManager\Entities\PersonnageHasToken $personnageHasToken
     * @return \LarpManager\Entities\Personnage
     */
    public function removePersonnageHasToken(PersonnageHasToken $personnageHasToken)
    {
        $this->personnageHasTokens->removeElement($personnageHasToken);

        return $this;
    }

    /**
     * Get PersonnageHasToken entity collection (one to many).
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPersonnageHasTokens()
    {
        return $this->personnageHasTokens;
    }

    /**
     * Add PersonnageLangues entity to collection (one to many).
     *
     * @param \LarpManager\Entities\PersonnageLangues $personnageLangues
     * @return \LarpManager\Entities\Personnage
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
     * @return \LarpManager\Entities\Personnage
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
     * Add PersonnageTrigger entity to collection (one to many).
     *
     * @param \LarpManager\Entities\PersonnageTrigger $personnageTrigger
     * @return \LarpManager\Entities\Personnage
     */
    public function addPersonnageTrigger(PersonnageTrigger $personnageTrigger)
    {
        $this->personnageTriggers[] = $personnageTrigger;

        return $this;
    }

    /**
     * Remove PersonnageTrigger entity from collection (one to many).
     *
     * @param \LarpManager\Entities\PersonnageTrigger $personnageTrigger
     * @return \LarpManager\Entities\Personnage
     */
    public function removePersonnageTrigger(PersonnageTrigger $personnageTrigger)
    {
        $this->personnageTriggers->removeElement($personnageTrigger);

        return $this;
    }

    /**
     * Get PersonnageTrigger entity collection (one to many).
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPersonnageTriggers()
    {
        return $this->personnageTriggers;
    }

    /**
     * Add PersonnagesReligions entity to collection (one to many).
     *
     * @param \LarpManager\Entities\PersonnagesReligions $personnagesReligions
     * @return \LarpManager\Entities\Personnage
     */
    public function addPersonnagesReligions(PersonnagesReligions $personnagesReligions)
    {
        $this->personnagesReligions[] = $personnagesReligions;

        return $this;
    }

    /**
     * Remove PersonnagesReligions entity from collection (one to many).
     *
     * @param \LarpManager\Entities\PersonnagesReligions $personnagesReligions
     * @return \LarpManager\Entities\Personnage
     */
    public function removePersonnagesReligions(PersonnagesReligions $personnagesReligions)
    {
        $this->personnagesReligions->removeElement($personnagesReligions);

        return $this;
    }

    /**
     * Get PersonnagesReligions entity collection (one to many).
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPersonnagesReligions()
    {
        return $this->personnagesReligions;
    }

    /**
     * Add Postulant entity to collection (one to many).
     *
     * @param \LarpManager\Entities\Postulant $postulant
     * @return \LarpManager\Entities\Personnage
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
     * @return \LarpManager\Entities\Personnage
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
     * Add SecondaryGroup entity to collection (one to many).
     *
     * @param \LarpManager\Entities\SecondaryGroup $secondaryGroup
     * @return \LarpManager\Entities\Personnage
     */
    public function addSecondaryGroup(SecondaryGroup $secondaryGroup)
    {
        $this->secondaryGroups[] = $secondaryGroup;

        return $this;
    }

    /**
     * Remove SecondaryGroup entity from collection (one to many).
     *
     * @param \LarpManager\Entities\SecondaryGroup $secondaryGroup
     * @return \LarpManager\Entities\Personnage
     */
    public function removeSecondaryGroup(SecondaryGroup $secondaryGroup)
    {
        $this->secondaryGroups->removeElement($secondaryGroup);

        return $this;
    }

    /**
     * Get SecondaryGroup entity collection (one to many).
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSecondaryGroups()
    {
        return $this->secondaryGroups;
    }

    /**
     * Set Groupe entity (many to one).
     *
     * @param \LarpManager\Entities\Groupe $groupe
     * @return \LarpManager\Entities\Personnage
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
     * @return \LarpManager\Entities\Personnage
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

    /**
     * Set Age entity (many to one).
     *
     * @param \LarpManager\Entities\Age $age
     * @return \LarpManager\Entities\Personnage
     */
    public function setAge(Age $age = null)
    {
        $this->age = $age;

        return $this;
    }

    /**
     * Get Age entity (many to one).
     *
     * @return \LarpManager\Entities\Age
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * Set Genre entity (many to one).
     *
     * @param \LarpManager\Entities\Genre $genre
     * @return \LarpManager\Entities\Personnage
     */
    public function setGenre(Genre $genre = null)
    {
        $this->genre = $genre;

        return $this;
    }

    /**
     * Get Genre entity (many to one).
     *
     * @return \LarpManager\Entities\Genre
     */
    public function getGenre()
    {
        return $this->genre;
    }

    /**
     * Set Participant entity (one to one).
     *
     * @param \LarpManager\Entities\Participant $participant
     * @return \LarpManager\Entities\Personnage
     */
    public function setParticipant(Participant $participant)
    {
        $this->participant = $participant;

        return $this;
    }

    /**
     * Get Participant entity (one to one).
     *
     * @return \LarpManager\Entities\Participant
     */
    public function getParticipant()
    {
        return $this->participant;
    }

    /**
     * Set Territoire entity (many to one).
     *
     * @param \LarpManager\Entities\Territoire $territoire
     * @return \LarpManager\Entities\Personnage
     */
    public function setTerritoire(Territoire $territoire = null)
    {
        $this->territoire = $territoire;

        return $this;
    }

    /**
     * Get Territoire entity (many to one).
     *
     * @return \LarpManager\Entities\Territoire
     */
    public function getTerritoire()
    {
        return $this->territoire;
    }

    /**
     * Add Document entity to collection.
     *
     * @param \LarpManager\Entities\Document $document
     * @return \LarpManager\Entities\Personnage
     */
    public function addDocument(Document $document)
    {
        $document->addPersonnage($this);
        $this->documents[] = $document;

        return $this;
    }

    /**
     * Remove Document entity from collection.
     *
     * @param \LarpManager\Entities\Document $document
     * @return \LarpManager\Entities\Personnage
     */
    public function removeDocument(Document $document)
    {
        $document->removePersonnage($this);
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

    /**
     * Add Competence entity to collection.
     *
     * @param \LarpManager\Entities\Competence $competence
     * @return \LarpManager\Entities\Personnage
     */
    public function addCompetence(Competence $competence)
    {
        $this->competences[] = $competence;

        return $this;
    }

    /**
     * Remove Competence entity from collection.
     *
     * @param \LarpManager\Entities\Competence $competence
     * @return \LarpManager\Entities\Personnage
     */
    public function removeCompetence(Competence $competence)
    {
        $this->competences->removeElement($competence);

        return $this;
    }

    /**
     * Get Competence entity collection.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCompetences()
    {
        return $this->competences;
    }

    /**
     * Add Domaine entity to collection.
     *
     * @param \LarpManager\Entities\Domaine $domaine
     * @return \LarpManager\Entities\Personnage
     */
    public function addDomaine(Domaine $domaine)
    {
        $domaine->addPersonnage($this);
        $this->domaines[] = $domaine;

        return $this;
    }

    /**
     * Remove Domaine entity from collection.
     *
     * @param \LarpManager\Entities\Domaine $domaine
     * @return \LarpManager\Entities\Personnage
     */
    public function removeDomaine(Domaine $domaine)
    {
        $domaine->removePersonnage($this);
        $this->domaines->removeElement($domaine);

        return $this;
    }

    /**
     * Get Domaine entity collection.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDomaines()
    {
        return $this->domaines;
    }

    /**
     * Add Potion entity to collection.
     *
     * @param \LarpManager\Entities\Potion $potion
     * @return \LarpManager\Entities\Personnage
     */
    public function addPotion(Potion $potion)
    {
        $potion->addPersonnage($this);
        $this->potions[] = $potion;

        return $this;
    }

    /**
     * Remove Potion entity from collection.
     *
     * @param \LarpManager\Entities\Potion $potion
     * @return \LarpManager\Entities\Personnage
     */
    public function removePotion(Potion $potion)
    {
        $potion->removePersonnage($this);
        $this->potions->removeElement($potion);

        return $this;
    }

    /**
     * Get Potion entity collection.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPotions()
    {
        return $this->potions;
    }

    /**
     * Add Priere entity to collection.
     *
     * @param \LarpManager\Entities\Priere $priere
     * @return \LarpManager\Entities\Personnage
     */
    public function addPriere(Priere $priere)
    {
        $this->prieres[] = $priere;

        return $this;
    }

    /**
     * Remove Priere entity from collection.
     *
     * @param \LarpManager\Entities\Priere $priere
     * @return \LarpManager\Entities\Personnage
     */
    public function removePriere(Priere $priere)
    {
        $this->prieres->removeElement($priere);

        return $this;
    }

    /**
     * Get Priere entity collection.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPrieres()
    {
        return $this->prieres;
    }

    /**
     * Add Sort entity to collection.
     *
     * @param \LarpManager\Entities\Sort $sort
     * @return \LarpManager\Entities\Personnage
     */
    public function addSort(Sort $sort)
    {
        $sort->addPersonnage($this);
        $this->sorts[] = $sort;

        return $this;
    }

    /**
     * Remove Sort entity from collection.
     *
     * @param \LarpManager\Entities\Sort $sort
     * @return \LarpManager\Entities\Personnage
     */
    public function removeSort(Sort $sort)
    {
        $sort->removePersonnage($this);
        $this->sorts->removeElement($sort);

        return $this;
    }

    /**
     * Get Sort entity collection.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSorts()
    {
        return $this->sorts;
    }

    /**
     * Add User entity to collection.
     *
     * @param \LarpManager\Entities\User $user
     * @return \LarpManager\Entities\Personnage
     */
    public function addUser(User $user)
    {
        $this->users[] = $user;

        return $this;
    }

    /**
     * Remove User entity from collection.
     *
     * @param \LarpManager\Entities\User $user
     * @return \LarpManager\Entities\Personnage
     */
    public function removeUser(User $user)
    {
        $this->users->removeElement($user);

        return $this;
    }

    /**
     * Get User entity collection.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsers()
    {
        return $this->users;
    }

    public function __sleep()
    {
        return array('id', 'nom', 'surnom', 'intrigue', 'groupe_id', 'classe_id', 'age_id', 'genre_id', 'renomme', 'photo', 'joueur_id', 'xp', 'territoire_id', 'materiel', 'vivant', 'age_reel', 'trombineUrl');
    }
}