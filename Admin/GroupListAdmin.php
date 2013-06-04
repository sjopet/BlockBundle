<?php

namespace Symfony\Cmf\Bundle\BlockBundle\Admin;

use Sonata\DoctrinePHPCRAdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;

use Sonata\DoctrinePHPCRAdminBundle\Datagrid\ProxyQuery;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\ODM\PHPCR\DocumentManager;

class GroupListAdmin extends Admin
{
    protected $translationDomain = 'SymfonyCmfBlockBundle';

    /** @var $listFieldTemplate string */
    protected $listFieldTemplate = 'SymfonyCmfBlockBundle::base_list_field.html.twig';

    /**
     * @param \Sonata\AdminBundle\Datagrid\DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id', 'doctrine_phpcr_string', array('label' => 'ID'))
            ->add('name',  'doctrine_phpcr_nodename')
            ->add('type', 'doctrine_phpcr_string', array('label' => 'Type'))
        ;
    }

    /**
     * @param \Sonata\AdminBundle\Datagrid\ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $adminField = new SubAdminFieldDescription();
        $adminField->setFieldName('type');

        $idField = new IdFieldDescription();
        $idField->setFieldName('id');

        $listMapper
            ->addIdentifier('id', 'text')
            ->add('name', 'text')
            ->add($adminField, 'text')
        ;
    }

    /**
     * @param string $context
     * @return ProxyQuery
     */
    public function createQuery($context = 'list')
    {
        $dm = $this->getModelManager()->getDocumentManager();
        /** @var \Doctrine\ODM\PHPCR\Query\QueryBuilder $qb */
        $qb = $dm->createQueryBuilder();
        $query = new ProxyQuery($qb);
        $query->setDocumentManager($dm);
        $qb->nodeType('nt:unstructured');

        foreach ($this->getSubClasses() as $class => $admin) {
            $exp = $qb->expr()->eq('phpcr:class', $class);
            $qb->orWhere($exp);
        }
        return $query;
    }

    /**
     * @param $name
     * @return string
     */
    public function getSubAdmin($name)
    {
        if(is_object($name)){
            $name = \Doctrine\Common\Util\ClassUtils::getRealClass(get_class($name));
        }

        return $this->getConfigurationPool()->getAdminByClass($name);
    }

    /**
     * Because of the structure of the subclasses array
     * We need to change this function slightly
     *
     * @param  string $name The name of the sub class
     * @return string the subclass
     */
    protected function getSubClass($name)
    {
        if ($this->hasSubClass($name)) {
            return $name;
        }

        return null;
    }
}
