<?php
namespace SimUser\Entity;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{

    public function findByUsernameAndPassword($username, $password)
    {
        $user = $this->findOneBy(array('username' => $username, 'active' => 1));

        if ($user) {
            $hashSenha = $user->encryptPassword($password);
            if ($hashSenha == $user->getPassword())
                return $user;
            else
                return false;
        } else
            return false;
    }

    public function findArray()
    {
        $users = $this->findAll();
        $a = array();
        foreach ($users as $user) {
            $a[$user->getId()]['id'] = $user->getId();
            $a[$user->getId()]['name'] = $user->getName();
            $a[$user->getId()]['email'] = $user->getEmail();
        }

        return $a;
    }
}
