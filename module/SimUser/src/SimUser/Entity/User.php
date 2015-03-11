<?php
namespace SimUser\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Math\Rand, Zend\Crypt\Key\Derivation\Pbkdf2;
use SimBase\Hydrator\Strategy\DateTimeStrategy;

/**
 * User
 *
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="app_user", uniqueConstraints={@ORM\UniqueConstraint(name="username", columns={"username"})}, indexes={@ORM\Index(name="fk_app_user_app_role1_idx", columns={"role_id"})})
 * @ORM\Entity(repositoryClass="SimUser\Entity\UserRepository")
 */
class User
{

    /**
     *
     * @var integer @ORM\Column(name="id", type="integer", precision=0, scale=0, nullable=false, unique=false)
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     *
     * @var string @ORM\Column(name="name", type="string", length=255, precision=0, scale=0, nullable=false, unique=false)
     */
    private $name;

    /**
     *
     * @var string @ORM\Column(name="email", type="string", length=45, precision=0, scale=0, nullable=true, unique=false)
     */
    private $email;

    /**
     *
     * @var string @ORM\Column(name="username", type="string", length=20, precision=0, scale=0, nullable=false, unique=true)
     */
    private $username;

    /**
     *
     * @var string @ORM\Column(name="password", type="string", length=10, precision=0, scale=0, nullable=false, unique=false)
     */
    private $password;

    /**
     *
     * @var string @ORM\Column(name="active", type="string", length=1, precision=0, scale=0, nullable=false, unique=false)
     */
    private $active;

    /**
     *
     * @var \DateTime @ORM\Column(name="expire_in", type="datetime", precision=0, scale=0, nullable=true, unique=false)
     */
    private $expireIn;

    /**
     * @var string @ORM\Column(name="salt", type="string", length=255, nullable=false)
     */
    private $salt;

    /**
     *
     * @var string @ORM\Column(name="registered_by", type="string", length=45, precision=0, scale=0, nullable=false, unique=false)
     */
    private $registeredBy;

    /**
     *
     * @var \DateTime @ORM\Column(name="registered_in", type="datetime", precision=0, scale=0, nullable=false, unique=false)
     */
    private $registeredIn;

    /**
     *
     * @var string @ORM\Column(name="modified_by", type="string", length=45, precision=0, scale=0, nullable=true, unique=false)
     */
    private $modifiedBy;

    /**
     *
     * @var \DateTime @ORM\Column(name="modified_in", type="datetime", precision=0, scale=0, nullable=true, unique=false)
     */
    private $modifiedIn;

    /**
     *
     * @var \SimAcl\Entity\Role @ORM\ManyToOne(targetEntity="SimAcl\Entity\Role", cascade={"persist"})
     *      @ORM\JoinColumn(name="role_id", referencedColumnName="id")
     */
    private $role;

    /**
     * Construct users.
     *
     * @param array $options
     */
    public function __construct(array $options = array())
    {
        $hydrator = new ClassMethods();
        $hydrator->addStrategy('expire_in', new DateTimeStrategy('d/m/Y'));
        $hydrator->hydrate($options, $this);

        $this->salt = base64_encode(Rand::getBytes(8, true));

        $this->registeredIn = new \DateTime("now");
        //TODO Colocar o session do usuário logado
        $this->registeredBy = 'SessionName';

        $this->modifiedIn = new \DateTime("now");
        //TODO Colocar o session do usuário logado
        $this->modifiedBy = 'SessionName';
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return User
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set username
     *
     * @param string $username
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $this->encryptPassword($password);

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return string
     */
    public function encryptPassword($password)
    {
        return base64_encode(Pbkdf2::calc('sha256', $password, $this->salt, 10000, strlen($password * 2)));
    }

    /**
     * Set active
     *
     * @param string $active
     * @return User
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return string
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set expireIn
     *
     * @param \DateTime $expireIn
     * @return User
     */
    public function setExpireIn($expireIn)
    {
        $this->expireIn = $expireIn;
        return $this;
    }

    /**
     * Get expireIn
     *
     * @return \DateTime
     */
    public function getExpireIn()
    {
        return $this->expireIn;
    }

    /**
     * @return the $salt
     */
    public function getSalt()
    {
        return $this->salt;
    }

	/**
     * @param string $salt
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
        return $this;
    }

	/**
     * Set registeredBy
     *
     * @param string $registeredBy
     * @return User
     */
    public function setRegisteredBy()
    {
        //TODO Colocar o session do usuário logado
        $this->registeredBy = 'SessionName';

        return $this;
    }

    /**
     * Get registeredBy
     *
     * @return string
     */
    public function getRegisteredBy()
    {
        return $this->registeredBy;
    }

    /**
     * Set registeredIn
     *
     * @param \DateTime $registeredIn
     * @return User
     */
    public function setRegisteredIn()
    {
        $this->registeredIn = new \Datetime("now");

        return $this;
    }

    /**
     * Get registeredIn
     *
     * @return \DateTime
     */
    public function getRegisteredIn()
    {
        return $this->registeredIn;
    }

    /**
     * Set modifiedBy
     *
     * @ORM\PrePersist
     * @ORM\PreUpdate
     *
     * @param string $modifiedBy
     * @return User
     */
    public function setModifiedBy()
    {
        //TODO Colocar o session do usuário logado
        $this->modifiedBy = 'SessionName';
        return $this;
    }

    /**
     * Get modifiedBy
     *
     * @return string
     */
    public function getModifiedBy()
    {
        return $this->modifiedBy;
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function setModifiedIn()
    {
        $this->modifiedIn = new \Datetime("now");
        return $this;
    }

    /**
     * Get modifiedIn
     *
     * @return \DateTime
     */
    public function getModifiedIn()
    {
        return $this->modifiedIn;
    }

    /**
     * @return the $role
     */
    public function getRole()
    {
        return $this->role;
    }

	/**
     * @param \SimAcl\Entity\Role $role
     */
    public function setRole($role)
    {
        $this->role = $role;
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
        $hydrator->addStrategy('expire_in', new DateTimeStrategy('d/m/Y'));

        $objectVars = $hydrator->extract($this);
        $objectVars['role'] = $this->getRole()->getId();
        $objectVars['roleName'] = $this->getRole()->getName();
        $objectVars['expireIn'] = $objectVars['expire_in'];
        unset($objectVars['password']);

        return $objectVars;
    }
}