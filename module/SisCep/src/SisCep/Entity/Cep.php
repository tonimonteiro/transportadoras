<?php
namespace SisCep\Entity;

use Doctrine\ORM\Mapping as ORM;
use SimBase\Entity\AbstractEntity;
use Zend\Stdlib\Hydrator\ClassMethods;


/**
 * SisCep
 *
 * @ORM\Table(name="sis_cep", indexes={@ORM\Index(name="cep", columns={"cep_final", "cep_inicial"}), @ORM\Index(name="fk_sis_cep_sis_transportadora_idx", columns={"transportadora_id"})})
 * @ORM\Entity(repositoryClass="SisCep\Entity\CepRepository")
 */
class Cep extends AbstractEntity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="cep_inicial", type="string", length=8, nullable=true)
     */
    private $cepInicial;

    /**
     * @var string
     *
     * @ORM\Column(name="cep_final", type="string", length=8, nullable=true)
     */
    private $cepFinal;

    /**
     * @var integer
     *
     * @ORM\Column(name="peso", type="integer", nullable=true)
     */
    private $peso;

    /**
     * @var string
     *
     * @ORM\Column(name="valor", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $valor;

    /**
     * @var \SisTransportadora\Entity\Transportadora
     *
     * @ORM\OneToOne(targetEntity="SisTransportadora\Entity\Transportadora")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="transportadora_id", referencedColumnName="id")
     * })
     */
    private $transportadora;

    /**
     * Constructor
     */
    public function __construct()
    {}

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
     * @return string
     */
    public function getCepInicial()
    {
        return $this->cepInicial;
    }

    /**
     * @param string $cepInicial
     */
    public function setCepInicial($cepInicial)
    {
        $this->cepInicial = $cepInicial;
    }

    /**
     * @return string
     */
    public function getCepFinal()
    {
        return $this->cepFinal;
    }

    /**
     * @param string $cepFinal
     */
    public function setCepFinal($cepFinal)
    {
        $this->cepFinal = $cepFinal;
    }

    /**
     * @return int
     */
    public function getPeso()
    {
        return $this->peso;
    }

    /**
     * @param int $peso
     */
    public function setPeso($peso)
    {
        $this->peso = $peso;
    }

    /**
     * @return string
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * @param string $valor
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
    }

    /**
     * @return \SisTransportadora\Entity\Transportadora
     */
    public function getTransportadora()
    {
        return $this->transportadora;
    }

    /**
     * @param \SisTransportadora\Entity\Transportadora $transportadora
     */
    public function setTransportadora($transportadora)
    {
        $this->transportadora = $transportadora;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $hydrator = new ClassMethods();
        $objectVars = $hydrator->extract($this);
        $objectVars = $this->prepare($hydrator->extract($this));
        return $objectVars;
    }
}