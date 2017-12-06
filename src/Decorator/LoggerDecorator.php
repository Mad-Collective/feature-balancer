<?php

namespace Cmp\FeatureBalancer\Decorator;

use Cmp\FeatureBalancer\ConfigurableBalancerInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Psr\Log\NullLogger;

class LoggerDecorator extends BalancerDecorator
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var string
     */
    private $level;

    /**
     * @param ConfigurableBalancerInterface $balancer
     * @param LoggerInterface|null          $logger
     * @param string                        $level
     */
    public function __construct(ConfigurableBalancerInterface $balancer, LoggerInterface $logger = null, $level = LogLevel::INFO)
    {
        parent::__construct($balancer);
        $this->logger = $logger ?: new NullLogger();
        $this->level  = $level;
    }

    /**
     * {@inheritdoc}
     */
    public function get($feature, $seed = null)
    {
        $path = $this->balancer->get($feature, $seed);

        $this->logger->log($this->level, "Feature path returned from the balancer: $feature -> $path", [
            "feature" => $feature,
            "seed"    => (string) $seed,
            "path"    => $path,
        ]);

        return $path;
    }
}
