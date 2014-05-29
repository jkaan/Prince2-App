<?php

namespace Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Subject
 *
 * @ORM\Entity
 * @ORM\Table(name="subjects")
 */
class Subject
{
    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $message;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="Document", mappedBy="subject")
     */
    private $documents;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="Clip", mappedBy="subject")
     */
    private $clips;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", length=1)
     */
    private $schoolYear;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->documents = new \Doctrine\Common\Collections\ArrayCollection();
        $this->clips = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Subject
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set message
     *
     * @param string $message
     * @return Subject
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string 
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Add documents
     *
     * @param \Entities\Document $documents
     * @return Subject
     */
    public function addDocument(\Entities\Document $documents)
    {
        $this->documents[] = $documents;

        return $this;
    }

    /**
     * Remove documents
     *
     * @param \Entities\Document $documents
     */
    public function removeDocument(\Entities\Document $documents)
    {
        $this->documents->removeElement($documents);
    }

    /**
     * Get documents
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDocuments()
    {
        return $this->documents;
    }

    /**
     * Add clips
     *
     * @param \Entities\Clip $clips
     * @return Subject
     */
    public function addClip(\Entities\Clip $clips)
    {
        $this->clips[] = $clips;

        return $this;
    }

    /**
     * Remove clips
     *
     * @param \Entities\Clip $clips
     */
    public function removeClip(\Entities\Clip $clips)
    {
        $this->clips->removeElement($clips);
    }

    /**
     * Get clips
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getClips()
    {
        return $this->clips;
    }

    /**
     * @param int $schoolYear
     */
    public function setSchoolYear($schoolYear)
    {
        $this->schoolYear = $schoolYear;
    }

    /**
     * @return int
     */
    public function getSchoolYear()
    {
        return $this->schoolYear;
    }
}
