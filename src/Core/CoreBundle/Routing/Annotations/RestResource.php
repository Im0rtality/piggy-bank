<?php

namespace Core\CoreBundle\Routing\Annotations;

/**
 * @Annotation
 */
class RestResource
{
    /** @var string */
    public $route = null;
    /** @var string */
    public $entity = null;
} 
