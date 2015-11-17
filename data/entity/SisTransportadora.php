<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * SisTransportadora
 *
 * @ORM\Table(name="sis_transportadora", indexes={@ORM\Index(name="ativo", columns={"ativo"})})
 * @ORM\Entity
 */
class SisTransportadora
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
     * @ORM\Column(name="nome", type="string", length=255, nullable=true)
     */
    private $nome;

    /**
     * @var integer
     *
     * @ORM\Column(name="ativo", type="integer", nullable=true)
     */
    private $ativo;


}
