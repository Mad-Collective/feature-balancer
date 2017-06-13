<?php

namespace Cmp\FeatureBalancer\Decorator;

use Cmp\FeatureBalancer\BalancerInterface;
use Cmp\FeatureBalancer\Exception\BalancerException;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

class ExceptionSilencerDecorator extends BalancerDecorator implements BalancerInterface
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @param BalancerInterface    $balancer
     * @param LoggerInterface|null $logger
     */
    public function __construct(BalancerInterface $balancer, LoggerInterface $logger = null)
    {
        parent::__construct($balancer);
        $this->logger = $logger ?: new NullLogger();
    }

    /**
     * {@inheritdoc}
     */
    public function get($feature, $seed = null)
    {
        try {
            return $this->balancer->get($feature, $seed);
        } catch (BalancerException $exception) {
            $this->logger->error("Exception thrown balancing feature '$feature'", [
                "feature"   => $feature,
                "exception" => $exception,
            ]);
        }

        return "";
    }
}
