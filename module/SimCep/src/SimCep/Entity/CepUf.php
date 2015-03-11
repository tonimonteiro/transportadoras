<?php
/**
 * Sim Tecnologia Application
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.simtecnologia.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@zend.com so we can send you a copy immediately.
 *
 * @category   Calendar.php
 * @package    Entity
 * @copyright  Copyright (c) 2014 Sim Tecnologia. (http://www.simtencologia.com)
 * @license    http://www.simtecnologia.com/license/new-bsd      New BSD License
 */
namespace SimCep\Entity;

use Doctrine\ORM\Mapping as ORM;
use SimBase\Entity\AbstractEntity;
use Zend\Stdlib\Hydrator\ClassMethods;

/**
 * CepUf
 *
 * @ORM\Table(name="cep_uf")
 * @ORM\Entity(repositoryClass="SimCep\Entity\CepUfRepository")
 * @ORM\HasLifecycleCallbacks
 */
class CepUf extends AbstractEntity
{
    /**
     * @var string
     *
     * @ORM\Column(name="uf", type="string", length=2, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $uf = '';

    /**
     * @var string
     *
     * @ORM\Column(name="nome", type="string", length=72, nullable=false)
     */
    private $nome = '';

    /**
     * @var string
     *
     * @ORM\Column(name="cep1", type="string", length=5, nullable=false)
     */
    private $cep1 = '';

    /**
     * @var string
     *
     * @ORM\Column(name="cep2", type="string", length=5, nullable=false)
     */
    private $cep2 = '';

    /**
     * Construct.
     *
     * @param array $options
     */
    public function __construct(array $options = array())
    {
        $hydrator = new ClassMethods();
        $hydrator->hydrate($options, $this);
    }

	/**
     * Gets the $uf.
     *
     * @return string
     */
    public function getUf()
    {
        return $this->uf;
    }

	/**
     * Sets the $uf.
     *
     * @param string $uf
     */
    public function setUf($uf)
    {
        $this->uf = $uf;
        return $this;
    }

	/**
     * Gets the $nome.
     *
     * @return string
     */
    public function getNome()
    {
        return $this->nome;
    }

	/**
     * Sets the $nome.
     *
     * @param string $nome
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
        return $this;
    }

	/**
     * Gets the $cep1.
     *
     * @return string
     */
    public function getCep1()
    {
        return $this->cep1;
    }

	/**
     * Sets the $cep1.
     *
     * @param string $cep1
     */
    public function setCep1($cep1)
    {
        $this->cep1 = $cep1;
        return $this;
    }

	/**
     * Gets the $cep2.
     *
     * @return string
     */
    public function getCep2()
    {
        return $this->cep2;
    }

	/**
     * Sets the $cep2.
     *
     * @param string $cep2
     */
    public function setCep2($cep2)
    {
        $this->cep2 = $cep2;
        return $this;
    }

    /**
     * Get array copy.
     *
     * @return multitype:
     */
    public function toArray()
    {
        $hydrator = new ClassMethods();
        $objectVars = $this->prepare($hydrator->extract($this));
        return $objectVars;
    }

}
