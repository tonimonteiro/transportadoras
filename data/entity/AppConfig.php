<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * AppConfig
 *
 * @ORM\Table(name="app_config", indexes={@ORM\Index(name="name", columns={"name"})})
 * @ORM\Entity
 */
class AppConfig
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="value", type="string", length=255, nullable=false)
     */
    private $value;

    /**
     * @var string
     *
     * @ORM\Column(name="registered_by", type="string", length=45, nullable=false)
     */
    private $registeredBy;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="registered_in", type="datetime", nullable=false)
     */
    private $registeredIn;

    /**
     * @var string
     *
     * @ORM\Column(name="modified_by", type="string", length=45, nullable=true)
     */
    private $modifiedBy;

    /**
     * @var string
     *
     * @ORM\Column(name="modified_in", type="string", length=45, nullable=true)
     */
    private $modifiedIn;


}
