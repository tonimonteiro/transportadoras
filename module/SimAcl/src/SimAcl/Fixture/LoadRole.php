<?php
namespace SimAcl\Fixture;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use SimAcl\Entity\Role;

class LoadRole extends AbstractFixture implements OrderedFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $role = new Role();
        $role->setNome("Visitante");
        $manager->persist($role);

        $visitante = $manager->getReference('SimAcl\Entity\Role', 1);

        $role = new Role();
        $role->setNome("Registrado")->setParent($visitante);
        $manager->persist($role);

        $registrado = $manager->getReference('SimAcl\Entity\Role', 2);

        $role = new Role();
        $role->setNome("Redator")->setParent($registrado);
        $manager->persist($role);

        $role = new Role();
        $role->setNome("Administrador")->setIsAdmin(true);

        $manager->persist($role);

        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }
}
