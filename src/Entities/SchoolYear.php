<?php
/**
 * Created by PhpStorm.
 * User: joey
 * Date: 5/22/14
 * Time: 11:29 AM
 */

namespace Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class SchoolYear
 * @package Entities
 *
 * @ORM\Entity()
 * @ORM\Table("schoolyears")
 */
class SchoolYear
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

} 