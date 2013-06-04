<?php
/**
* (c) Netvlies Internetdiensten
*
* @author Sjoerd Peters <speters@netvlies.nl>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/


namespace Symfony\Cmf\Bundle\BlockBundle\Admin;

use Sonata\AdminBundle\Admin\BaseFieldDescription;

class IdFieldDescription extends BaseFieldDescription
{

    public function setFieldMapping($fieldMapping){}

    public function setAssociationMapping($associationMapping){}

    public function setParentAssociationMappings(array $parentAssociationMappings){}

    /**
     * return the related Target Entity
     *
     * @return string|null
     */
    public function getTargetEntity()
    {
        return null;
    }

    /**
     * return true if the FieldDescription is linked to an identifier field
     *
     * @return bool
     */
    public function isIdentifier()
    {
        return true;
    }

    /**
     * return the value linked to the description
     *
     * @param mixed $object
     *
     * @return bool|mixed
     */
    public function getValue($object)
    {
//        $id = $this->getAdmin()->getSubAdmin($object)->getModelManager()->getIdentifierValues($object);

//        echo "<pre>";
//        var_dump($id);
//        echo "</pre>";
//        die;
        return 'lalala';
    }

}
