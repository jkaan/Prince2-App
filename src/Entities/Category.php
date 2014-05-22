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
 * Class Category
 * @package Entities
 *
 * @ORM\Entity()
 * @ORM\Table("categories")
 */
class Category
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