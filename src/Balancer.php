<?php

namespace Cmp\FeatureBalancer;

use Cmp\FeatureBalancer\Exception\OutOfBoundsException;

class Balancer
{
    /**
     * @var Feature[]
     */
    private $features;

    /**
     * {@inheritdoc}
     */
    public function add($name, array $percentages)
    {
        $feature = new Feature($name, $percentages);
        $this->features[$feature->name()] = $feature;
    }

    /**
     * {@inheritdoc}
     */
    public function get($feature, $seed = null)
    {
        if (!isset($this->features[$feature])) {
            throw new OutOfBoundsException("The feature $feature has not been configured");
        }

        return $this->features[$feature]->get($this->seed($seed));
    }

    /**
     * @param int|string|null $seed
     *
     * @return Seed
     */
    private function seed($seed = null)
    {
        if ($seed === null) {
            $seed = mt_rand(0, 99);
        }

        return new Seed($seed);
    }
}
