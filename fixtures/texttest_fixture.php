<?php

require_once __DIR__ . '/../vendor/autoload.php';

use GildedRose\GildedRose;
use GildedRose\Item;
use GildedRose\WareFactory;
use GildedRose\Wares\Common;
use GildedRose\Wares\Conjured;
use GildedRose\Wares\Legendary;
use GildedRose\Wares\Ticket;
use GildedRose\Wares\Uncommon;
use GildedRose\Wares\WellAging;
use GildedRose\WaresRegistry;

$items = array(
    new Item('+5 Dexterity Vest', 10, 20),
    new Item('Aged Brie', 2, 0),
    new Item('Elixir of the Mongoose', 5, 7),
    new Item('Sulfuras, Hand of Ragnaros', 0, 80),
    new Item('Sulfuras, Hand of Ragnaros', -1, 80),
    new Item('Backstage passes to a TAFKAL80ETC concert', 15, 20),
    new Item('Backstage passes to a TAFKAL80ETC concert', 10, 49),
    new Item('Backstage passes to a TAFKAL80ETC concert', 5, 49),
    // this new type - conjured item should work fine now
    new Item('Conjured Mana Muffin', 5, 20)
);

$registry = new WaresRegistry();

$registry->register(Common::class);
$registry->register(Uncommon::class);
$registry->register(Legendary::class);
$registry->register(WellAging::class);
$registry->register(Ticket::class);
$registry->register(Conjured::class);

$app = new GildedRose($items, new WareFactory($registry));

$days = 2;
if (count($argv) > 1) {
    $days = (int) $argv[1];
}

for ($i = 0; $i < $days; $i++) {
    echo("-------- day $i --------" . PHP_EOL);
    echo("name, sellIn, quality" . PHP_EOL);
    foreach ($items as $item) {
        echo $item . PHP_EOL;
    }
    echo PHP_EOL;
    $app->updateQuality();
}
