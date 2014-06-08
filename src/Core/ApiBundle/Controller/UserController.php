<?php

namespace Core\ApiBundle\Controller;

use Core\ApiBundle\Routing\Annotations\RestResource;
use Core\ApiBundle\Routing\RestfulController;

/**
 * @RestResource(
 *      route="user",
 *      entity="CoreCoreBundle:User"
 * )
 */
class UserController extends RestfulController
{

}
