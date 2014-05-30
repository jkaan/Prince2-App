<?php

namespace Entities;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Clip
 *
 * @ORM\Entity()
 * @ORM\Table(name="clips")
 */
class Clip
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
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $path;

    /**
     * @var integer
     *
     * @ORM\Column(name="schoolyear", type="integer")
     */
    private $schoolYear;

    /**
     * @var Subject
     *
     * @ORM\ManyToOne(targetEntity="Subject", inversedBy="clips")
     */
    private $subject;

    /**
     * @var string
     *
     * @ORM\Column(name="mimetype", type="string")
     */
    private $mimeType;

    private $clip;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->subject = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Sets the clip
     *
     * @param UploadedFile $clip
     */
    public function setClip(UploadedFile $clip = null)
    {
        $this->clip = $clip;
    }

    /**
     * @return mixed
     */
    public function getClip()
    {
        return $this->clip;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Clip
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set path
     *
     * @param string $path
     * @return Clip
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set schoolYear
     *
     * @param integer $schoolYear
     * @return Clip
     */
    public function setSchoolYear($schoolYear)
    {
        $this->schoolYear = $schoolYear;

        return $this;
    }

    /**
     * Get schoolYear
     *
     * @return integer 
     */
    public function getSchoolYear()
    {
        return $this->schoolYear;
    }

    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    /**
     * Get subject
     *
     * @return Subject
     */
    public function getSubject()
    {
        return $this->subject;
    }

    public function getAbsolutePath()
    {
        return null === $this->path
            ? null
            : $this->getUploadRootDir().'/'.$this->path;
    }

    public function getWebPath()
    {
        return null === $this->path
            ? null
            : $this->getUploadDir().'/'.$this->path;
    }

    public function getUploadRootDir()
    {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__ . '/../../' . $this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return 'uploads/clips';
    }

    public function upload()
    {
        if (null === $this->getClip()) {
            return;
        }

        $this->getClip()->move(
            $this->getUploadRootDir(),
            $this->getClip()->getClientOriginalName()
        );

        $this->setPath($this->getClip()->getClientOriginalName());
        $this->setMimeType($this->getClip()->getClientMimeType());

        $this->setClip(null);
    }

    /**
     * @param string $mimeType
     */
    public function setMimeType($mimeType)
    {
        $this->mimeType = $mimeType;
    }

    /**
     * @return string
     */
    public function getMimeType()
    {
        return $this->mimeType;
    }
}
