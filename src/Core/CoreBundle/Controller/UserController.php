<?php

namespace Core\CoreBundle\Controller;

use Core\CoreBundle\Routing\Annotations\RestResource;
use Core\CoreBundle\Routing\RestfulController;

/**
 * @RestResource(
 *      route="user",
 *      entity="CoreCoreBundle:User"
 * )
 */
class UserController extends RestfulController
{

}
