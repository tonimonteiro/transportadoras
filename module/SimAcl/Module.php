<?php
namespace SimAcl;

class Module
{

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__
                )
            )
        );
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'SimAcl\Form\Role' => function ($serviceManager)
                {
                    $entityManager = $serviceManager->get('Doctrine\ORM\EntityManager');
                    $repository = $entityManager->getRepository('SimAcl\Entity\Role');
                    $parent = $repository->fetchParent();

                    return new Form\Role($entityManager, 'role', $parent);
                },
                'SimAcl\Service\Role' => function ($sm)
                {
                    return new Service\Role($sm->get('Doctrine\ORM\Entitymanager'));
                },
                'SimAcl\Permissions\Acl' => function ($sm)
                {
                    $em = $sm->get('Doctrine\ORM\EntityManager');

                    $repoRole = $em->getRepository("SimAcl\\Entity\\Role");
                    $roles = $repoRole->findAll();

                    return new Permission\Acl($roles);
                }
            )
        );
    }
}
