<?php
namespace SimUser\Fixture;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use SimUser\Entity\User;

class LoadUser extends AbstractFixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $role = $manager->getReference('SimAcl\Entity\Role', 1);

        $user = new User();
        $user->setName('Toni')
            ->setEmail('tonimonteiro@gmail.com')
            ->setActive(1)
            ->setUsername('tonimonteiro')
            ->setPassword('1234567')
            ->setRole($role);
        $manager->persist($user);

        $user = new User();
        $user->setName('Jorge')
            ->setEmail('jorge@brmidia.com.br')
            ->setActive(0)
            ->setUsername('jorge')
            ->setPassword('1234567')
            ->setRole($role);
        $manager->persist($user);

        $manager->flush();
    }

    public function getDependencies()
    {
        return array('\SimAcl\Fixture\LoadRole', '\SimAcl\Fixture\LoadResource', '\SimAcl\Fixture\LoadPrivilege');
    }

    public function getOrder()
    {
        return 4;
    }
}
