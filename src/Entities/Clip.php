<?php
/**
 * Created by PhpStorm.
 * User: joey
 * Date: 5/10/14
 * Time: 2:49 PM
 */

namespace Entities;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class Clip
 * @package Entities
 *
 * @ORM\Entity
 * @ORM\Table(name="clips")
 */
class Clip
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $path;

    private $clip;

    /**
     * @return mixed
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
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
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

        $this->setClip(null);
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

    protected function getUploadRootDir()
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



} 