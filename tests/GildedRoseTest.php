<?php

declare(strict_types=1);

namespace Tests;

use GildedRose\GildedRose;
use GildedRose\Item;
use PHPUnit\Framework\TestCase;

class GildedRoseTest extends TestCase
{
    /**
     * @param array $input
     * @param string $expected
     *
     * @covers       \Item
     * @uses         Item
     *
     * @dataProvider itemProvider
     */
    public function testItemCreation(array $input, string $expected): void
    {
        $item = new Item($input['name'], $input['sellIn'], $input['quality']);
        $this->assertSame($expected, (string)$item);
    }

    public function itemProvider(): array
    {
        return [
            [
                'item' => [
                    'name' => '+7 Agility Vambrace',
                    'sellIn' => 5,
                    'quality' => 10,
                ],
                'expected' => '+7 Agility Vambrace, 5, 10'
            ],
            [
                'item' => [
                    'name' => '+3 Defense Shield',
                    'sellIn' => 0,
                    'quality' => 7,
                ],
                'expected' => '+3 Defense Shield, 0, 7'
            ],
            [
                'item' => [
                    'name' => 'Backstage passes to a TAFKAL80ETC concert',
                    'sellIn' => 4,
                    'quality' => 0,
                ],
                'expected' => 'Backstage passes to a TAFKAL80ETC concert, 4, 0'
            ],
            // legendary Item - only one allowed to have a quality of 80 (over 50)
            [
                'item' => [
                    'name' => 'Sulfuras, Hand of Ragnaros',
                    'sellIn' => 0,
                    'quality' => 80,
                ],
                'expected' => 'Sulfuras, Hand of Ragnaros, 0, 80'
            ],
            // is it even OK to create new Items already after the Sell In date?
            [
                'item' => [
                    'name' => 'Conjured Mana Muffin',
                    'sellIn' => -2,
                    'quality' => 5,
                ],
                'expected' => 'Conjured Mana Muffin, -2, 5'
            ],
            /** what about creating new Items wth stats already outside of the rules:
             * The Quality of an item is never negative
             * The Quality of an item is never more than 50
             * TODO: block the possibility to create such items somehow
             * [
             * 'item' => [
             * 'name' => 'cheap knockoff of Sulfuras, not legendary',
             * 'sellIn' => 5,
             * 'quality' => 77,
             * ],
             * 'expected' => 'some error during creation'
             * ],
             * [
             * 'item' => [
             * 'name' => 'useless junk',
             * 'sellIn' => 50,
             * 'quality' => -10,
             * ],
             * 'expected' => 'some error during creation'
             * ],
             */
        ];
    }
}
