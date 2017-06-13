<?php

namespace Cmp\FeatureBalancer;

use Cmp\FeatureBalancer\Config\Identifier;
use Cmp\FeatureBalancer\Config\Percentage;

/**
 * Class Identifier
 */
class Feature
{
    /**
     * @var Identifier
     */
    private $name;

    /**
     * @var Percentage[]
     */
    private $percentages;

    /**
     * @param string $name
     * @param array  $percentages
     *
     * @throws \InvalidArgumentException When any parameter given is not acceptable 
     */
    public function __construct($name, array $percentages)
    {
        $this->name = new Identifier($name);

        $total = 0;
        foreach ($percentages as $path => $percentage) {
            $path = new Identifier($path);
            if (isset($this->percentages[(string) $path])) {
                throw new \InvalidArgumentException("The path '$path' on feature '$name' is duplicated");
            }

            $percentage = new Percentage($percentage);
            $total += $percentage->number();

            $this->percentages[(string) $path] = $percentage;
        }

        if ($total !== 100) {
            throw new \InvalidArgumentException("The total amount of paths for feature '$name' doesn't add up to 100%");
        }
    }

    /**
     * @return string
     */
    public function name()
    {
        return $this->name->name();
    }

    /**
     * @param Seed $seed
     *
     * @return string
     */
    public function get(Seed $seed)
    {
        $total = 0;
        foreach ($this->percentages as $path => $percentage) {
            $total += $percentage->number();
            if ($seed->seed() < $total) {
                break;
            }
        }

        return $path;
    }
}
