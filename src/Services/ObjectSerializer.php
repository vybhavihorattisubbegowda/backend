<?php
namespace App\Services\Api\Serializer;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Doctrine\Common\Annotations\AnnotationReader;

class ObjectSerializer
{
    private $object;
    private $specifics_attributes;

    public function __construct($object, Array $groups = ['default'], Array $specifics_attributes = null)
    {
        $this->object = $object;
        $this->groups = $groups;
        $this->specifics_attributes = $specifics_attributes;
    }

    public function serializeObject(): ?Array
    {
        $object = $this->object;

        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                return $object;
            },
        ];

        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $normalizer = [  new ObjectNormalizer($classMetadataFactory, null, null, null, null, null, $defaultContext)];
        $serializer = new Serializer($normalizer);

        return $serializer->normalize($object, null, $this->normalizerFilters());
    }

    private function normalizerFilters():Array
    {
        $groups = $this->groups;
        $specifics_attributes = $this->specifics_attributes;

        $normalizer_filter = [
            'groups' => $groups,
        ];

        if ($specifics_attributes) {
            $normalizer_filter['attributes'] = $specifics_attributes;
        }

        return $normalizer_filter;
    }
}