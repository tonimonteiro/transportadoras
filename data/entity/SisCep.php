<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * SisCep
 *
 * @ORM\Table(name="sis_cep", indexes={@ORM\Index(name="cep", columns={"cep_final", "cep_inicial"}), @ORM\Index(name="fk_sis_cep_sis_transportadora_idx", columns={"transportadora_id"})})
 * @ORM\Entity
 */
class SisCep
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
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
     * @ORM\Column(name="peso_a", type="integer", nullable=true)
     */
    private $pesoA;

    /**
     * @var integer
     *
     * @ORM\Column(name="peso_z", type="integer", nullable=true)
     */
    private $pesoZ;

    /**
     * @var string
     *
     * @ORM\Column(name="valor", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $valor;

    /**
     * @var \SisTransportadora
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="SisTransportadora")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="transportadora_id", referencedColumnName="id")
     * })
     */
    private $transportadora;


}
