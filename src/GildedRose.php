<?php

declare(strict_types=1);

namespace GildedRose;

/**
 * Class GildedRose
 * @package GildedRose
 */
final class GildedRose
{
    /**
     * The array of Items for sale in the GildedRose.
     *
     * @var Item[]
     */
    private $items;

    /**
     * GildedRose constructor. Requires an array of Items to be passed.
     *
     * @param array $items
     */
    public function __construct(array $items)
    {
        $this->items = $items;
    }

    /**
     * Updates all items in the GildedRose item Collection.
     * Lowers sell in and lowers or rises quality in accordance with the Requirements Specification.
     * (should be invoked once per day, at the end of the day, every day)
     */
    public function updateQuality(): void
    {
        foreach ($this->items as $item) {
            if ($item->name != 'Aged Brie' and $item->name != 'Backstage passes to a TAFKAL80ETC concert') {
                if ($item->quality > 0) {
                    if ($item->name != 'Sulfuras, Hand of Ragnaros') {
                        $item->quality = $item->quality - 1;
                        if ($item->name == 'Conjured Mana Muffin' && $item->quality > 0){
                            $item->quality = $item->quality - 1;
                        }
                    }
                }
            } else {
                if ($item->quality < 50) {
                    $item->quality = $item->quality + 1;
                    if ($item->name == 'Backstage passes to a TAFKAL80ETC concert') {
                        if ($item->sell_in < 11) {
                            if ($item->quality < 50) {
                                $item->quality = $item->quality + 1;
                            }
                        }
                        if ($item->sell_in < 6) {
                            if ($item->quality < 50) {
                                $item->quality = $item->quality + 1;
                            }
                        }
                    }
                }
            }

            if ($item->name != 'Sulfuras, Hand of Ragnaros') {
                $item->sell_in = $item->sell_in - 1;
            }

            if ($item->sell_in < 0) {
                if ($item->name != 'Aged Brie') {
                    if ($item->name != 'Backstage passes to a TAFKAL80ETC concert') {
                        if ($item->quality > 0) {
                            if ($item->name != 'Sulfuras, Hand of Ragnaros') {
                                $item->quality = $item->quality - 1;
                                if ($item->name == 'Conjured Mana Muffin' && $item->quality > 0){
                                    $item->quality = $item->quality - 1;
                                }
                            }
                        }
                    } else {
                        $item->quality = $item->quality - $item->quality;
                    }
                } else {
                    if ($item->quality < 50) {
                        $item->quality = $item->quality + 1;
                    }
                }
            }
        }
    }
}
