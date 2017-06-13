<?php

namespace Cmp\FeatureBalancer;

class Balancer
{
    /**
     * @var Feature[]
     */
    private $features;

    /**
     * Adds a new feature in the balancer
     *
     * @param string $name
     * @param array  $percentages
     */
    public function add($name, array $percentages)
    {
        $feature = new Feature($name, $percentages);
        $this->features[$feature->name()] = $feature;
    }

    /**
     * Gets the path tha a seedd has to follow for a given feature 
     *
     * @param string     $feature
     * @param string|int $seed
     *
     * @return string
     * 
     * @throws \InvalidArgumentException When the seed is not valid
     * @throws \OutOfBoundsException When the feature has not been configured
     */
    public function get($feature, $seed = null)
    {
        if (!isset($this->features[$feature])) {
            throw new \OutOfBoundsException("The feature $feature has not been configured");
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
