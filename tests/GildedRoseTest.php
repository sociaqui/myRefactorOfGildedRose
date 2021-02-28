<?php

declare(strict_types=1);

namespace Tests;

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
use PHPUnit\Framework\TestCase;

class GildedRoseTest extends TestCase
{
    /**
     * @covers       GildedRose\GildedRose::updateQuality()
     * @dataProvider updateQualityProvider
     *
     * @param Item $item
     * @param Item $expected
     */
    public function testUpdateQuality(Item $item, Item $expected): void
    {
        $registry = new WaresRegistry();
        $registry->register(Common::class);
        $registry->register(Uncommon::class);
        $registry->register(Legendary::class);
        $registry->register(WellAging::class);
        $registry->register(Ticket::class);
        $registry->register(Conjured::class);
        $gildedRose = new GildedRose([$item], new WareFactory($registry));
        $gildedRose->updateQuality();
        $this->assertSame((string)$expected, (string)$item);
    }

    /**
     * @return array
     */
    public function updateQualityProvider(): array
    {
        return [
            //Normal Item, typical state => sell in drops by 1, quality drops by 1
            [
                'item' =>
                    new Item('Mundane Staff of Mundanity', 5, 10),

                'expected' =>
                    new Item('Mundane Staff of Mundanity', 4, 9),
            ],
            //Normal Item, boundary state => sell in drops to 0, quality still drops by 1
            [
                'item' =>
                    new Item('Mundane Staff of Mundanity', 1, 7),

                'expected' =>
                    new Item('Mundane Staff of Mundanity', 0, 6),
            ],
            //Normal Item, after sell by date => sell in keeps falling, quality drops by 2, but not below 0
            [
                'item' =>
                    new Item('Mundane Staff of Mundanity', 0, 3),

                'expected' =>
                    new Item('Mundane Staff of Mundanity', -1, 1),
            ],
            [
                'item' =>
                    new Item('Mundane Staff of Mundanity', -3, 2),

                'expected' =>
                    new Item('Mundane Staff of Mundanity', -4, 0),
            ],
            [
                'item' =>
                    new Item('Mundane Staff of Mundanity', -5, 1),

                'expected' =>
                    new Item('Mundane Staff of Mundanity', -6, 0),
            ],
            [
                'item' =>
                    new Item('Mundane Staff of Mundanity', -9, 0),

                'expected' =>
                    new Item('Mundane Staff of Mundanity', -10, 0),
            ],
            //Legendary Item, neither stat changes
            [
                'item' =>
                    new Item('Sulfuras, Hand of Ragnaros', 0, 80),

                'expected' =>
                    new Item('Sulfuras, Hand of Ragnaros', 0, 80),
            ],
            //Well Aging Item => actually increases in Quality the older it gets, but not over 50
            [
                'item' =>
                    new Item('Aged Brie', 10, 25),

                'expected' =>
                    new Item('Aged Brie', 9, 26),
            ],
            [
                'item' =>
                    new Item('Aged Brie', 9, 49),

                'expected' =>
                    new Item('Aged Brie', 8, 50),
            ],
            [
                'item' =>
                    new Item('Aged Brie', 8, 50),

                'expected' =>
                    new Item('Aged Brie', 7, 50),
            ],
            //Well Aging Item, after sell by date => sell in keeps falling, quality rises by 2, but not over 50
            [
                'item' =>
                    new Item('Aged Brie', 0, 30),

                'expected' =>
                    new Item('Aged Brie', -1, 32),
            ],
            [
                'item' =>
                    new Item('Aged Brie', -1, 48),

                'expected' =>
                    new Item('Aged Brie', -2, 50),
            ],
            [
                'item' =>
                    new Item('Aged Brie', -2, 49),

                'expected' =>
                    new Item('Aged Brie', -3, 50),
            ],
            [
                'item' =>
                    new Item('Aged Brie', -3, 50),

                'expected' =>
                    new Item('Aged Brie', -4, 50),
            ],
            //Backstage passes increase in Quality as their sell by date approaches, but not over 50
            [
                'item' =>
                    new Item('Backstage passes to a TAFKAL80ETC concert', 20, 25),

                'expected' =>
                    new Item('Backstage passes to a TAFKAL80ETC concert', 19, 26),
            ],
            [
                'item' =>
                    new Item('Backstage passes to a TAFKAL80ETC concert', 19, 49),

                'expected' =>
                    new Item('Backstage passes to a TAFKAL80ETC concert', 18, 50),
            ],
            [
                'item' =>
                    new Item('Backstage passes to a TAFKAL80ETC concert', 18, 50),

                'expected' =>
                    new Item('Backstage passes to a TAFKAL80ETC concert', 17, 50),
            ],
            //Backstage passes increase in Quality by 2 when there are 10 days or less to their sell by date, but not over 50
            [
                'item' =>
                    new Item('Backstage passes to a TAFKAL80ETC concert', 10, 33),

                'expected' =>
                    new Item('Backstage passes to a TAFKAL80ETC concert', 9, 35),
            ],
            [
                'item' =>
                    new Item('Backstage passes to a TAFKAL80ETC concert', 9, 48),

                'expected' =>
                    new Item('Backstage passes to a TAFKAL80ETC concert', 8, 50),
            ],
            [
                'item' =>
                    new Item('Backstage passes to a TAFKAL80ETC concert', 8, 49),

                'expected' =>
                    new Item('Backstage passes to a TAFKAL80ETC concert', 7, 50),
            ],
            [
                'item' =>
                    new Item('Backstage passes to a TAFKAL80ETC concert', 7, 50),

                'expected' =>
                    new Item('Backstage passes to a TAFKAL80ETC concert', 6, 50),
            ],
            //Backstage passes increase in Quality by 3 when there are 5 days or less to their sell by date, but not over 50
            [
                'item' =>
                    new Item('Backstage passes to a TAFKAL80ETC concert', 5, 44),

                'expected' =>
                    new Item('Backstage passes to a TAFKAL80ETC concert', 4, 47),
            ],
            [
                'item' =>
                    new Item('Backstage passes to a TAFKAL80ETC concert', 4, 47),

                'expected' =>
                    new Item('Backstage passes to a TAFKAL80ETC concert', 3, 50),
            ],
            [
                'item' =>
                    new Item('Backstage passes to a TAFKAL80ETC concert', 3, 48),

                'expected' =>
                    new Item('Backstage passes to a TAFKAL80ETC concert', 2, 50),
            ],
            [
                'item' =>
                    new Item('Backstage passes to a TAFKAL80ETC concert', 2, 49),

                'expected' =>
                    new Item('Backstage passes to a TAFKAL80ETC concert', 1, 50),
            ],
            [
                'item' =>
                    new Item('Backstage passes to a TAFKAL80ETC concert', 1, 50),

                'expected' =>
                    new Item('Backstage passes to a TAFKAL80ETC concert', 0, 50),
            ],
            //Backstage passes Quality drops to 0 after the concert, but never drops below 0 afterwards
            [
                'item' =>
                    new Item('Backstage passes to a TAFKAL80ETC concert', 0, 35),

                'expected' =>
                    new Item('Backstage passes to a TAFKAL80ETC concert', -1, 0),
            ],
            [
                'item' =>
                    new Item('Backstage passes to a TAFKAL80ETC concert', 0, 50),

                'expected' =>
                    new Item('Backstage passes to a TAFKAL80ETC concert', -1, 0),
            ],
            [
                'item' =>
                    new Item('Backstage passes to a TAFKAL80ETC concert', -2, 0),

                'expected' =>
                    new Item('Backstage passes to a TAFKAL80ETC concert', -3, 0),
            ],
            [
                'item' =>
                    new Item('Backstage passes to a TAFKAL80ETC concert', -9, 0),

                'expected' =>
                    new Item('Backstage passes to a TAFKAL80ETC concert', -10, 0),
            ],
            //Conjured Item degrades in Quality twice as fast as normal items
            [
                'item' =>
                    new Item('Conjured Mana Muffin', 10, 33),

                'expected' =>
                    new Item('Conjured Mana Muffin', 9, 31),
            ],
            [
                'item' =>
                    new Item('Conjured Mana Muffin', 0, 10),

                'expected' =>
                    new Item('Conjured Mana Muffin', -1, 6),
            ],
            [
                'item' =>
                    new Item('Conjured Mana Muffin', -3, 4),

                'expected' =>
                    new Item('Conjured Mana Muffin', -4, 0),
            ],
            [
                'item' =>
                    new Item('Conjured Mana Muffin', -3, 3),

                'expected' =>
                    new Item('Conjured Mana Muffin', -4, 0),
            ],
            [
                'item' =>
                    new Item('Conjured Mana Muffin', -3, 2),

                'expected' =>
                    new Item('Conjured Mana Muffin', -4, 0),
            ],
            [
                'item' =>
                    new Item('Conjured Mana Muffin', -3, 1),

                'expected' =>
                    new Item('Conjured Mana Muffin', -4, 0),
            ],
            [
                'item' =>
                    new Item('Conjured Mana Muffin', -3, 0),

                'expected' =>
                    new Item('Conjured Mana Muffin', -4, 0),
            ],
        ];
    }
}
