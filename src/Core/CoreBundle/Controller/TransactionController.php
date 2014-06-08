<?php

namespace Core\CoreBundle\Controller;

use Core\CoreBundle\Routing\Annotations\RestResource;
use Core\CoreBundle\Routing\RestfulController;

/**
 * @RestResource(
 *      route="transaction",
 *      entity="CoreCoreBundle:Transaction"
 * )
 */
class TransactionController extends RestfulController
{

}
