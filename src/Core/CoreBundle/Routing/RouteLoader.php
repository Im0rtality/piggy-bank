<?php

namespace Core\CoreBundle\Routing;

use Core\CoreBundle\Routing\Annotations\RestResource;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Inflector\Inflector;
use Symfony\Component\Config\Loader\Loader;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Config\FileLocator;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class RouteLoader extends Loader
{
    /** @var  AnnotationReader */
    protected $reader;

    /**
     * Loads a resource.
     *
     * @param mixed  $resource The resource
     * @param string $type     The resource type
     *
     * @return RouteCollection
     */
    public function load($resource, $type = null)
    {
        if (true === $this->loaded) {
            throw new \RuntimeException('Do not add the "extra" loader twice');
        }

        $controller  = $resource;
        $routes      = new RouteCollection();
        $ref         = new \ReflectionClass($resource);
        $annotations = $this->reader->getClassAnnotations($ref, 'RestResource');

        /** @var $restResource RestResource */
        $restResource = reset($annotations);
        if ($restResource) {
            $routeCollection = [];
            $routeCollection += $this->buildGetRoute($controller, $restResource);
            $routeCollection += $this->buildListRoute($controller, $restResource);

            foreach ($routeCollection as $routeName => $route) {
                $routes->add($routeName, $route);
            }
        }
        return $routes;
    }

    /**
     * Returns true if this class supports the given resource.
     *
     * @param mixed  $resource A resource
     * @param string $type     The resource type
     *
     * @return bool    true if this class supports the given resource, false otherwise
     */
    public function supports($resource, $type = null)
    {
        return 'restful' === $type;
    }

    /**
     * @param AnnotationReader $reader
     */
    public function setReader(AnnotationReader $reader)
    {
        $this->reader = $reader;
    }

    /**
     * @param string       $controller
     * @param RestResource $restResource
     * @return array
     */
    protected function buildGetRoute($controller, $restResource)
    {
        return $this->buildRoute($controller, $restResource, 'get', '/%s/{id}', ['id' => '\d+']);
    }

    /**
     * @param string       $controller
     * @param RestResource $restResource
     * @return array
     */
    protected function buildListRoute($controller, $restResource)
    {
        return $this->buildRoute($controller, $restResource, 'list', '/%s');
    }

    /**
     * @param string       $controller
     * @param RestResource $restResource
     * @param string       $action
     * @param string       $pattern
     * @param array        $requirements
     * @return array
     */
    protected function buildRoute($controller, $restResource, $action, $pattern, $requirements = [])
    {
        $defaults = [
            '_controller' => sprintf('%s::%sAction', $controller, $action),
            'resource'    => $restResource->entity,
            'offset'      => 0,
            'limit'       => 20
        ];

        $pattern = sprintf($pattern, Inflector::pluralize($restResource->route));
        $route   = new Route($pattern, $defaults, $requirements);

        // add the new route to the route collection:
        $routeName = sprintf('api.%s.%s', $restResource->route, $action);
        return array($routeName => $route);
    }
}
