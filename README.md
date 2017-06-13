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
 * Valid seeds are non-empty strings and unsigned numbers
 */
$path = $balancer->get("after_update_email", 78549612);
$path = $balancer->get("after_update_email", -4.75);
$path = $balancer->get("after_update_email", "my_user@example.com");
```

## Building the balancer
The library comes with a builder to ease the creation of the balancer.
```php
$balancer = (new BalancerBuilder())->create();
```

### Adding logging
If you install the `Psr\Log` library you can add logging to every decision made by the balancer. You can choose the log level that will be use to record log entries
```php
// Add a logger when building the balancer
$balancer = (new BalancerBuilder())->->withLogger($logger, LogLevel::DEBUG)->create($config);

/** 
 * This will log: "Feature path returned from the balancer: home_banner -> amazing_offer"
 * Plus some context information:
 * - feature
 * - path
 * - seed
 */
$balancer->get("home_banner", 9874562);
```

### Adding monitoring
If you install the `pluggit\monitoring` library you can add monitoring to every decision made by the balancer. 

You **have** to choose the metric name to increment
```php
// Add a monitor when building the balancer
$balancer = (new BalancerBuilder())->->withMonitor($monitor, "balanced_feature")->create($config);

/** 
 * This will increment the metric: "balanced_feature", plus some tags
 * - feature
 * - path
 * - seed: true/false
 */
$balancer->get("home_banner", 9874562);
```

## Adding features to the balancer
You can always add features to the balancer trough the method `add`. The rules are:
* Every feature must have a non-empty unique string identifier, adding the same feature will overwrite the previous configuration
* Every feature must have at least one possible path
* Every feature path must have a non-empty unique string identifier for the given feature
* Every path has assigned a percentage
* The **percentage** for every path has to be an unsigned integer **between 0 and 100**
* All the path percentages **must sum exactly 100**

Any violation of the following rules will make the balancer throw a `Cmp\FeatureBalancer\Exception\InvalidArgumentException` exception

*Valid examples*
```php
$balancer->add("my_super_feature",  [
    "do_not_show"   => 20,
    "amazing_offer" => 80,
]);

$balancer->add("my_super_feature",  [
    "do_not_show"   => 0,
    "amazing_offer" => 100,
]);

$balancer->add("my_super_feature",  [
    "amazing_offer" => 100,
]);
```

*Invalid examples*
```php
// No paths defined
$balancer->add("my_super_feature",  []);

// Percentages sum 90
$balancer->add("my_super_feature",  [
    "do_not_show"   => 90,
]);

// Percentages sum 140
$balancer->add("my_super_feature",  [
    "do_not_show"   => 60,
    "amazing_offer" => 80,
]);

// Percentages is not a valid unsigned integer
$balancer->add("my_super_feature",  [
    "do_not_show"   => "60",
    "amazing_offer" => 40,
]);
```

## Getting a path
Once you have configured a feature, you can request a path to the balancer

### Random Non-deterministic retrieval
If you don't pass a seed, the path will be choosen randomly taking into account the defined percentages
```php
$path = $balancer->get("home_banner");
```

### Seed based deterministic retrieval
If you pass a seed, the path will be decided using a simple yet infallible algorithm so that for *every given configuration and seed, it will always choose the same path*

**NOTE** This means that the path can change if either the configuration or the seed changes

You can pass both signed numbers (integers and doubles) or non-empty strings as seed

```php
$path = $balancer->get("after_update_email", 78549612);
$path = $balancer->get("after_update_email", -23.54);
$path = $balancer->get("after_update_email", "my_user@example.com");
```
