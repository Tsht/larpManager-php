<?php

/**
 * Auto generated by MySQL Workbench Schema Exporter.
 * Version 2.1.6-dev (doctrine2-annotation) on 2017-02-09 11:20:16.
 * Goto https://github.com/johmue/mysql-workbench-schema-exporter for more
 * information.
 */

namespace LarpManager\Entities;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * LarpManager\Entities\Document
 *
 * @Entity()
 * @Table(name="document", indexes={@Index(name="fk_document_user1_idx", columns={"user_id"})})
 * @InheritanceType("SINGLE_TABLE")
 * @DiscriminatorColumn(name="discr", type="string")
 * @DiscriminatorMap({"base":"BaseDocument", "extended":"Document"})
 */
class BaseDocument
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
    protected $code;

    /**
     * @Column(type="string", length=45)
     */
    protected $titre;

    /**
     * @Column(type="text", nullable=true)
     */
    protected $description;

    /**
     * @Column(type="string", length=45)
     */
    protected $documentUrl;

    /**
     * @Column(type="boolean")
     */
    protected $cryptage;

    /**
     * @Column(type="string", length=45, nullable=true)
     */
    protected $statut;

    /**
     * @Column(type="string", length=45, nullable=true)
     */
    protected $auteur;

    /**
     * @Column(type="datetime")
     */
    protected $creation_date;

    /**
     * @Column(type="datetime")
     */
    protected $update_date;

    /**
     * @Column(type="boolean")
     */
    protected $impression;

    /**
     * @ManyToOne(targetEntity="User", inversedBy="documents")
     * @JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    protected $user;

    /**
     * @ManyToMany(targetEntity="Langue", inversedBy="documents")
     * @JoinTable(name="document_has_langue",
     *     joinColumns={@JoinColumn(name="document_id", referencedColumnName="id", nullable=false)},
     *     inverseJoinColumns={@JoinColumn(name="langue_id", referencedColumnName="id", nullable=false)}
     * )
     */
    protected $langues;

    /**
     * @ManyToMany(targetEntity="Groupe", mappedBy="documents")
     */
    protected $groupes;

    /**
     * @ManyToMany(targetEntity="Lieu", mappedBy="documents")
     */
    protected $lieus;

    /**
     * @ManyToMany(targetEntity="Personnage", mappedBy="documents")
     */
    protected $personnages;

    public function __construct()
    {
        $this->langues = new ArrayCollection();
        $this->groupes = new ArrayCollection();
        $this->lieus = new ArrayCollection();
        $this->personnages = new ArrayCollection();
    }

    /**
     * Set the value of id.
     *
     * @param integer $id
     * @return \LarpManager\Entities\Document
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
     * Set the value of code.
     *
     * @param string $code
     * @return \LarpManager\Entities\Document
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get the value of code.
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set the value of titre.
     *
     * @param string $titre
     * @return \LarpManager\Entities\Document
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
     * Set the value of description.
     *
     * @param string $description
     * @return \LarpManager\Entities\Document
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
     * Set the value of documentUrl.
     *
     * @param string $documentUrl
     * @return \LarpManager\Entities\Document
     */
    public function setDocumentUrl($documentUrl)
    {
        $this->documentUrl = $documentUrl;

        return $this;
    }

    /**
     * Get the value of documentUrl.
     *
     * @return string
     */
    public function getDocumentUrl()
    {
        return $this->documentUrl;
    }

    /**
     * Set the value of cryptage.
     *
     * @param boolean $cryptage
     * @return \LarpManager\Entities\Document
     */
    public function setCryptage($cryptage)
    {
        $this->cryptage = $cryptage;

        return $this;
    }

    /**
     * Get the value of cryptage.
     *
     * @return boolean
     */
    public function getCryptage()
    {
        return $this->cryptage;
    }

    /**
     * Set the value of statut.
     *
     * @param string $statut
     * @return \LarpManager\Entities\Document
     */
    public function setStatut($statut)
    {
        $this->statut = $statut;

        return $this;
    }

    /**
     * Get the value of statut.
     *
     * @return string
     */
    public function getStatut()
    {
        return $this->statut;
    }

    /**
     * Set the value of auteur.
     *
     * @param string $auteur
     * @return \LarpManager\Entities\Document
     */
    public function setAuteur($auteur)
    {
        $this->auteur = $auteur;

        return $this;
    }

    /**
     * Get the value of auteur.
     *
     * @return string
     */
    public function getAuteur()
    {
        return $this->auteur;
    }

    /**
     * Set the value of creation_date.
     *
     * @param \DateTime $creation_date
     * @return \LarpManager\Entities\Document
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
     * @return \LarpManager\Entities\Document
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
     * Set the value of impression.
     *
     * @param boolean $impression
     * @return \LarpManager\Entities\Document
     */
    public function setImpression($impression)
    {
        $this->impression = $impression;

        return $this;
    }

    /**
     * Get the value of impression.
     *
     * @return boolean
     */
    public function getImpression()
    {
        return $this->impression;
    }

    /**
     * Set User entity (many to one).
     *
     * @param \LarpManager\Entities\User $user
     * @return \LarpManager\Entities\Document
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
     * @return \LarpManager\Entities\Document
     */
    public function addLangue(Langue $langue)
    {
        $langue->addDocument($this);
        $this->langues[] = $langue;

        return $this;
    }

    /**
     * Remove Langue entity from collection.
     *
     * @param \LarpManager\Entities\Langue $langue
     * @return \LarpManager\Entities\Document
     */
    public function removeLangue(Langue $langue)
    {
        $langue->removeDocument($this);
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

    /**
     * Add Groupe entity to collection.
     *
     * @param \LarpManager\Entities\Groupe $groupe
     * @return \LarpManager\Entities\Document
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
     * @return \LarpManager\Entities\Document
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

    /**
     * Add Lieu entity to collection.
     *
     * @param \LarpManager\Entities\Lieu $lieu
     * @return \LarpManager\Entities\Document
     */
    public function addLieu(Lieu $lieu)
    {
        $this->lieus[] = $lieu;

        return $this;
    }

    /**
     * Remove Lieu entity from collection.
     *
     * @param \LarpManager\Entities\Lieu $lieu
     * @return \LarpManager\Entities\Document
     */
    public function removeLieu(Lieu $lieu)
    {
        $this->lieus->removeElement($lieu);

        return $this;
    }

    /**
     * Get Lieu entity collection.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLieus()
    {
        return $this->lieus;
    }

    /**
     * Add Personnage entity to collection.
     *
     * @param \LarpManager\Entities\Personnage $personnage
     * @return \LarpManager\Entities\Document
     */
    public function addPersonnage(Personnage $personnage)
    {
        $this->personnages[] = $personnage;

        return $this;
    }

    /**
     * Remove Personnage entity from collection.
     *
     * @param \LarpManager\Entities\Personnage $personnage
     * @return \LarpManager\Entities\Document
     */
    public function removePersonnage(Personnage $personnage)
    {
        $this->personnages->removeElement($personnage);

        return $this;
    }

    /**
     * Get Personnage entity collection.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPersonnages()
    {
        return $this->personnages;
    }

    public function __sleep()
    {
        return array('id', 'code', 'titre', 'description', 'documentUrl', 'cryptage', 'statut', 'auteur', 'user_id', 'creation_date', 'update_date', 'impression');
    }
}