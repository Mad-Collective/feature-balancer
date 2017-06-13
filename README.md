# Feature Balancer
This PHP library will allow to switch on/off or balance with a percentage between features

[![Build Status](https://scrutinizer-ci.com/g/CMProductions/feature-balancer/badges/build.png?b=master&s=9fe7f6a0144ed3bea324683cdda71c6389a5237d)](https://scrutinizer-ci.com/g/CMProductions/feature-balancer/build-status/master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/CMProductions/feature-balancer/badges/quality-score.png?b=master&s=2145a438dfeccbb80cb45bf07ad91c2db5497404)](https://scrutinizer-ci.com/g/CMProductions/feature-balancer/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/CMProductions/feature-balancer/badges/coverage.png?b=master&s=b3ebd4804862014430b2cfb73f0233a786417370)](https://scrutinizer-ci.com/g/CMProductions/feature-balancer/?branch=master)

## TLDR;
```php
$balancer = (new BalancerBuilder())
    ->withLogger($logger, LogLevel::INFO)
    ->withMonitor($monitor, "my_app.feature_balanced")
    ->create([
        "home_banner" => [
            "do_not_show"   => 20,
            "amazing_offer" => 80,
        ],
        "after_update_email" => [
            "normal"        => 60,
            "special_offer" => 30,
            "do_not_send"   => 10,
        ]
    ]);

/**
 * Random Non-deterministic balance
 * - 20% change to get "do_not_show", 80% chance to get "amazing_offer"
 */
$path = $balancer->get("home_banner");

/**
 * Deterministic balance, given a configuration and a valid seed, 
 * you'll always get the same result
 *
 * Valid seeds are non-empty strings and unsigned integers
 */
$path = $balancer->get("after_update_email", 78549612);
$path = $balancer->get("after_update_email", "my_user@example.com");
```
