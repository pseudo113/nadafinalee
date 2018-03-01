<?php
/**
 * Created by PhpStorm.
 * User: mzark
 * Date: 18/02/2018
 * Time: 18:21
 */

namespace nadaBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 */

class Commentaire
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="Commentaire")
     * @ORM\JoinColumn(name="id_user", referencedColumnName="id")
     */
    private $id_user;

    /**
     * @ORM\ManyToOne(targetEntity="fichier", inversedBy="Commentaire")
     * @ORM\JoinColumn(name="id_fichier", referencedColumnName="id",onDelete="CASCADE")
     */
    private $id_fichier;
    /**
     * @ORM\Column(type="text",length=65000,nullable=true)
     */
    private $commentaire ;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getIdUser()
    {
        return $this->id_user;
    }

    /**
     * @param mixed $id_user
     */
    public function setIdUser($id_user)
    {
        $this->id_user = $id_user;
    }

    /**
     * @return mixed
     */
    public function getIdFichier()
    {
        return $this->id_fichier;
    }

    /**
     * @param mixed $id_fichier
     */
    public function setIdFichier($id_fichier)
    {
        $this->id_fichier = $id_fichier;
    }

    /**
     * @return mixed
     */
    public function getCommentaire()
    {
        return $this->commentaire;
    }

    /**
     * @param mixed $commentaire
     */
    public function setCommentaire($commentaire)
    {
        $this->commentaire = $commentaire;
    }

}