# GildedRose Kata - PHP Version

This is my solution for the PHP Version of the Kata. See the [readme](https://github.com/emilybache/GildedRose-Refactoring-Kata/blob/master/README.md) in the [original repo](https://github.com/emilybache/GildedRose-Refactoring-Kata) for general information about this exercise.

## My Refactor

This exercise was really entertaining. I even managed to squeeze in a couple of design patterns:

* `Decorator Pattern` for `Ware` to modify `Items` without braking the rule about not touching their code (damn Goblin!).
* `Abstract Factory Pattern` to build `Wares` (my extended implementations of `Items`).

### I also tried to my best extent to:

* Reach as much code coverage as possible
  * test at least all main methods
  * cover all border cases, and in general all possible scenarios, with DataProviders
* Refactor all classes for dependency injection
* Make classes mockable & 
  * mock classes in tests
* Add PHPDoc tags wherever applicable
  
### Wares:

All aspects of a Ware can be set dynamically.

* Properties
  * const `NAME`. The name by which WareFactory identifies the Ware. Default: empty
  * const `ITEM_NAMES`. A list of names that Items assigned to the given Ware can have.
  * `highestQuality`. Determines the highest possible value for the quality. Default: 50
  * `lowestQuality`. Determines the lowest possible value for the quality. Default: 0
  * `qualityStep`. Determines the direction and rate at which quality changes every day. Default: -1
  * `qualityStepMultiplier`. Determines how quality changes value depending on the sell in value. Default: [0 => 2] which means that after the 'sell by' date the quality step gets multiplied by 2.
* Public methods
  * `update()`. Updates the Item's values at the end of the day.
  * `getItem()`. Returns the Item assigned to the Ware.
  * `getHighestQuality()` Returns the highest possible value for the quality.
  * `getLowestQuality()` Returns the lowest possible value for the quality.
  * `getQualityStep()`. Returns the quality step for the day taking multipliers into consideration.
  * `getNewQuality()`. Returns the new quality calculated for the next day. Warning: It does not take some rules into account (like highest, lowest values). Those rules are enforced during property assignment.
  * `isAfterSale()`. Returns `true` if the Ware has passed the 'sell by' date.

### Adding a new Ware
If you want to introduce a new Ware, just create a new Class extending the `Wares` Class and put it in the `Wares` directory.    
    e.g.    
  ```php
  <?php
  
  namespace GildedRose\Wares;
  
  use GildedRose\Ware;
  
  /**
   * Class Uncommon
   * @package GildedRose\Wares
   */
  class Uncommon extends Ware
  {
      /**
       * @inheritdoc
       */
      const NAME = 'Uncommon';
  
      /**
       * @inheritdoc
       */
      const ITEM_NAMES = [
          '+3 Dexterity Vest',
          '+5 Stamina Shiny Buckler',
          '+7 Strength War-axe',
          'Enchanted Wooden Shield of Entanglement',
      ];
  }
```
Then register it with the WaresRegistry.
   ```php
/** @var WaresRegistry $waresRegistry */
$waresRegistry->register(Uncommon::class);
   ```
## Installation

The kata uses:

- PHP 7.2+
- [Composer](https://getcomposer.org)

Recommended:
- [Git](https://git-scm.com/downloads)

Clone the repository

```sh
git clone git@github.com:emilybache/GildedRose-Refactoring-Kata.git
```

or

```shell script
git clone https://github.com/emilybache/GildedRose-Refactoring-Kata.git
```

Install all the dependencies using composer

```shell script
cd ./GildedRose-Refactoring-Kata/php
composer install
```

## Dependencies

The project uses composer to install:

- [PHPUnit](https://phpunit.de/)
- [ApprovalTests.PHP](https://github.com/approvals/ApprovalTests.php)
- [PHPStan](https://github.com/phpstan/phpstan)
- [Easy Coding Standard (ECS)](https://github.com/symplify/easy-coding-standard) 
- [PHP CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer/wiki)

## Folders

- `src` - contains the two classes:
  - `Item.php` - this class should not be changed.
  - `GildedRose.php` - this class needs to be refactored, and the new feature added.
- `tests` - contains the tests
  - `GildedRoseTest.php` - Starter test.
  - `ApprovalTest.php` - alternative approval test (set to 30 days)
- `Fixture`
  - `texttest_fixture.php` used by the approval test, or can be run from the command line

## Testing

PHPUnit is pre-configured to run tests. PHPUnit can be run using a composer script. To run the unit tests, from the
 root of the PHP project run:

```shell script
composer test
```

On Windows a batch file has been created, similar to an alias on Linux/Mac (e.g. `alias pu="composer test"`), the same
 PHPUnit `composer test` can be run:

```shell script
pu
```

### Tests with Coverage Report

To run all test and generate a html coverage report run:

```shell script
composer test-coverage
```

The test-coverage report will be created in /builds, it is best viewed by opening **index.html** in your browser.

## Code Standard

Easy Coding Standard (ECS) is used to check for style and code standards, **PSR-12** is used. The current code is not
 upto standard!

### Check Code

To check code, but not fix errors:

```shell script
composer check-cs
``` 

On Windows a batch file has been created, similar to an alias on Linux/Mac (e.g. `alias cc="composer check-cs"`), the
 same PHPUnit `composer check-cs` can be run:

```shell script
cc
```

### Fix Code

There are may code fixes automatically provided by ECS, if advised to run --fix, the following script can be run:

```shell script
composer fix-cs
```

On Windows a batch file has been created, similar to an alias on Linux/Mac (e.g. `alias fc="composer fix-cs"`), the same
 PHPUnit `composer fix-cs` can be run:

```shell script
fc
```

## Static Analysis

PHPStan is used to run static analysis checks:

```shell script
composer phpstan
```

On Windows a batch file has been created, similar to an alias on Linux/Mac (e.g. `alias ps="composer phpstan"`), the
 same PHPUnit `composer phpstan` can be run:

```shell script
ps
```

**Happy coding**!