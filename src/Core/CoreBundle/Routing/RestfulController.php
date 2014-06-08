<?php

namespace Core\CoreBundle\Routing;

use Doctrine\ORM\EntityRepository;
use JMS\Serializer\Serializer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class RestfulController extends Controller
{
    public function listAction($resource, $limit, $offset)
    {
        $repository = $this->getRepository($resource);
        $entities   = $repository->findBy([], null, $limit, $offset);

        return $this->renderData($entities);
    }

    public function getAction($resource, $id)
    {
        $repository = $this->getRepository($resource);
        $entities   = $repository->find($id);

        return $this->renderData($entities);
    }

    /**
     * @param string $entities
     * @return Response
     */
    protected function renderData($entities)
    {
        /** @var $serializer Serializer */
        $serializer = $this->get('jms_serializer');
        $data       = $serializer->serialize($entities, 'json');
        return new Response($data);
    }

    /**
     * @param $resource
     * @return EntityRepository
     */
    protected function getRepository($resource)
    {
        $em = $this->getDoctrine()->getManager();
        /** @var $repository EntityRepository */
        $repository = $em->getRepository($resource);
        return $repository;
    }
}
