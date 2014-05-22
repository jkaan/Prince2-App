<?php
/**
 * Created by PhpStorm.
 * User: joey
 * Date: 5/22/14
 * Time: 2:14 PM
 */

namespace Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Subject
 * @package Entities
 *
 * @ORM\Entity()
 * @ORM\Table(name="subjects")
 */
class Subject
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @ORM\Column(name="title", type="string")
     */
    private $title;

    /**
     * @ORM\Column(name="message", type="string")
     */
    private $message;

    /**
     * @ORM\ManyToMany(targetEntity="Document")
     */
    private $documents;

    /**
     * @ORM\ManyToMany(targetEntity="Clip")
     */
    private $clips;
} 