<?php

/**
 * Auto generated by MySQL Workbench Schema Exporter.
 * Version 2.1.6-dev (doctrine2-annotation) on 2017-07-01 12:27:43.
 * Goto https://github.com/johmue/mysql-workbench-schema-exporter for more
 * information.
 */

namespace LarpManager\Entities;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * LarpManager\Entities\Question
 *
 * @Entity()
 * @Table(name="question", indexes={@Index(name="fk_question_user1_idx", columns={"user_id"})})
 * @InheritanceType("SINGLE_TABLE")
 * @DiscriminatorColumn(name="discr", type="string")
 * @DiscriminatorMap({"base":"BaseQuestion", "extended":"Question"})
 */
class BaseQuestion
{
    /**
     * @Id
     * @Column(type="integer", options={"unsigned":true})
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @Column(name="`text`", type="text")
     */
    protected $text;

    /**
     * @Column(name="`date`", type="datetime")
     */
    protected $date;

    /**
     * @OneToMany(targetEntity="PersonnageHasQuestion", mappedBy="question")
     * @JoinColumn(name="id", referencedColumnName="question_id", nullable=false)
     */
    protected $personnageHasQuestions;

    /**
     * @ManyToOne(targetEntity="User", inversedBy="questions")
     * @JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    protected $user;

    public function __construct()
    {
        $this->personnageHasQuestions = new ArrayCollection();
    }

    /**
     * Set the value of id.
     *
     * @param integer $id
     * @return \LarpManager\Entities\Question
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
     * Set the value of text.
     *
     * @param string $text
     * @return \LarpManager\Entities\Question
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get the value of text.
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set the value of date.
     *
     * @param \DateTime $date
     * @return \LarpManager\Entities\Question
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get the value of date.
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Add PersonnageHasQuestion entity to collection (one to many).
     *
     * @param \LarpManager\Entities\PersonnageHasQuestion $personnageHasQuestion
     * @return \LarpManager\Entities\Question
     */
    public function addPersonnageHasQuestion(PersonnageHasQuestion $personnageHasQuestion)
    {
        $this->personnageHasQuestions[] = $personnageHasQuestion;

        return $this;
    }

    /**
     * Remove PersonnageHasQuestion entity from collection (one to many).
     *
     * @param \LarpManager\Entities\PersonnageHasQuestion $personnageHasQuestion
     * @return \LarpManager\Entities\Question
     */
    public function removePersonnageHasQuestion(PersonnageHasQuestion $personnageHasQuestion)
    {
        $this->personnageHasQuestions->removeElement($personnageHasQuestion);

        return $this;
    }

    /**
     * Get PersonnageHasQuestion entity collection (one to many).
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPersonnageHasQuestions()
    {
        return $this->personnageHasQuestions;
    }

    /**
     * Set User entity (many to one).
     *
     * @param \LarpManager\Entities\User $user
     * @return \LarpManager\Entities\Question
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

    public function __sleep()
    {
        return array('id', 'text', 'date', 'user_id');
    }
}