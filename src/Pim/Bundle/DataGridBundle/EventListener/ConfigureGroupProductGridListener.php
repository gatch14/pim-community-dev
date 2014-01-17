<?php

namespace Pim\Bundle\DataGridBundle\EventListener;

use Oro\Bundle\DataGridBundle\Datagrid\Common\DatagridConfiguration;
use Pim\Bundle\DataGridBundle\Datagrid\Flexible\ConfiguratorInterface;
use Pim\Bundle\FlexibleEntityBundle\Model\AbstractAttribute;
use Pim\Bundle\DataGridBundle\Datagrid\Flexible\GroupColumnsConfigurator;

/**
 * Grid listener to configure column, filter and sorter based on attributes and business rules
 *
 * @author    Nicolas Dupont <nicolas@akeneo.com>
 * @copyright 2013 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class ConfigureGroupProductGridListener extends ConfigureFlexibleGridListener
{
    /**
     * @param DatagridConfiguration $datagridConfig
     * @param AbstractAttribute[]   $attributes
     *
     * @return ConfiguratorInterface
     */
    protected function getColumnsConfigurator(DatagridConfiguration $datagridConfig, $attributes)
    {
        $groupId = $this->request->get('id', null);
        if (!$groupId) {
            $groupId = $this->requestParams->get('currentGroup', null);
        }

        $flexibleEntity = $datagridConfig->offsetGetByPath(self::FLEXIBLE_ENTITY_PATH);
        $flexibleManager = $this->getFlexibleManager($flexibleEntity);
        $em = $flexibleManager->getEntityManager();
        $group = $em->getRepository('Pim\Bundle\CatalogBundle\Entity\Group')->findOne($groupId);

        return new GroupColumnsConfigurator($datagridConfig, $this->confRegistry, $attributes, $group);
    }
}
