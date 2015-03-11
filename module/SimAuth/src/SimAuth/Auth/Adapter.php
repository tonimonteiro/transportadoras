<?php
namespace SimAuth\Auth;

use Zend\Authentication\Adapter\AdapterInterface;
use Zend\Authentication\Result;
use Doctrine\ORM\EntityManager;

class Adapter implements AdapterInterface
{

    protected $entityManager;

    protected $entity;

    protected $username;

    protected $password;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Gets the $entity.
     *
     * @return field_type
     */
    public function getEntity()
    {
        return $this->entity;
    }

	/**
     * Sets the $entity.
     *
     * @param field_type $entity
     */
    public function setEntity($entity)
    {
        $this->entity = $entity;
        return $this;
    }

	public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

	public function authenticate()
    {
        $repository = $this->entityManager->getRepository($this->getEntity());
        $credentials = $repository->findByUsernameAndPassword($this->getUsername(), $this->getPassword());

        if ($credentials)
            return new Result(Result::SUCCESS, array('credentials' => $credentials), array(true));
        else
            return new Result(Result::FAILURE_CREDENTIAL_INVALID, null, array(false));
    }
}
