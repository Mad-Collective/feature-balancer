<?php

namespace Cmp\FeatureBalancer\Exception;

/**
 * Interface the describe all balancer exceptions
 */
interface BalancerException
{
    /**
     * @return string
     */
    public function getMessage();
}
