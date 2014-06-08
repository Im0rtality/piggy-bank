<?php

namespace Core\ApiBundle\Controller;

use Core\ApiBundle\Routing\Annotations\RestResource;
use Core\ApiBundle\Routing\RestfulController;

/**
 * @RestResource(
 *      route="transaction",
 *      entity="CoreCoreBundle:Transaction"
 * )
 */
class TransactionController extends RestfulController
{

}
