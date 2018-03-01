<?php
/**
 * Created by PhpStorm.
 * User: mzark
 * Date: 23/02/2018
 * Time: 22:16
 */

namespace nadaBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
/**
 *
 *
 * @ORM\Table(name="archivefichier")
 * @ORM\Entity
 * @Vich\Uploadable
 */

class archivefichier
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
     * @ORM\ManyToOne(targetEntity="User", inversedBy="fichier")
     * @ORM\JoinColumn(name="id_user", referencedColumnName="id")
     */
    private $id_user;

    /**
     * @ORM\ManyToOne(targetEntity="Classe", inversedBy="fichier")
         * @ORM\JoinColumn(name="id_classe", referencedColumnName="id")
     */
    private $id_classe;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", nullable=true)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", nullable=true)
     */
    private $nom;
    /**
     * @var string
     *
     * @ORM\Column(name="module", type="string", nullable=true)
     */
    private $module;

    /**
     * @ORM\Column(name="Datecreation",type="datetime", nullable=false)
     * @ORM\Version
     * @var \DateTime
     */
    public $reDatecreation = null;

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
    public function getIdClasse()
    {
        return $this->id_classe;
    }

    /**
     * @param mixed $id_classe
     */
    public function setIdClasse($id_classe)
    {
        $this->id_classe = $id_classe;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return \DateTime
     */
    public function getReDatecreation()
    {
        return $this->reDatecreation;
    }

    /**
     * @param \DateTime $reDatecreation
     */
    public function setReDatecreation($reDatecreation)
    {
        $this->reDatecreation = $reDatecreation;
    }

    /**
     * @return mixed
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param mixed $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * @return mixed
     */
    public function getModule()
    {
        return $this->module;
    }

    /**
     * @param mixed $module
     */
    public function setModule($module)
    {
        $this->module = $module;
    }




    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="product_image", fileNameProperty="imageName")
     *
     */
    public $imageFile;
    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     *
     * @var string
     */
    public $imageName;
    /**
     * @ORM\Column(type="datetime",nullable=true)
     *
     * @var \DateTime
     */
    public $updatedAt;

    /**
     * FRepresent constructor.
     * @param null $reDatecreation
     */
    public function __construct()
    {
        $this->reDatecreation = new \DateTime();
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the  update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
     *
     * @return fichier
     */
    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;
        if ($image) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
        return $this;
    }
    /**
     * @return File|null
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }
    /**
     * @param string $imageName
     *
     * @return fichier
     */
    public function setImageName($imageName)
    {
        $this->imageName = $imageName;
        return $this;
    }
    /**
     * @return string|null
     */
    public function getImageName()
    {
        return $this->imageName;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

}