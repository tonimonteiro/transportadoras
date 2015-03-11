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
 * @ORM\Table(name="cep_paises")
 * @ORM\Entity(repositoryClass="SimCep\Entity\CepPaisesRepository")
 * @ORM\HasLifecycleCallbacks
 */
class CepPaises extends AbstractEntity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id = '1058';

    /**
     * @var string
     *
     * @ORM\Column(name="nome", type="string", length=100, nullable=true)
     */
    private $nome;

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
     * Gets the $id.
     *
     * @return number
     */
    public function getId()
    {
        return $this->id;
    }

	/**
     * Sets the $id.
     *
     * @param number $id
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

	/**
     * Gets the $nome.
     *
     * @return string
     */
    public function getNome()
    {
        return ucwords(strtolower($this->nome));
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
