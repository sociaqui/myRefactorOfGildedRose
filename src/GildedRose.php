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
     * Some basic settings that define how GildedRose functions
     *
     * @var array SETTINGS
     */
    private const SETTINGS = [
        'lowestQuality' => 0, // The lowest quality an Item can have.
        'highestQuality' => 50, // The highest quality a non-legendary Item can have.
        'legendaryQuality' => 80, // The special quality of a legendary Item.
        'fasterQualityGain' => 10, // The number of days before the concert date, when passes double gaining quality.
        'fastestQualityGain' => 5, // The number of days before the concert date, when passes triple gaining quality.
    ];

    /**
     * The sell by date. 0 (obviously). Declared for readability, not to be changed.
     * Each Item's sell in parameter means how many days until this deadline (negative sell in means days after).
     *
     * @var int DEADLINE
     */
    private const DEADLINE = 0;

    /**
     * The array of Items for sale in the GildedRose.
     *
     * @var Item[] $items
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

            if ($item->name != 'Sulfuras, Hand of Ragnaros') {
                $item->sell_in--;
            }

            switch ($item->name) {
                case 'Sulfuras, Hand of Ragnaros':
                    break;
                case 'Aged Brie':
                    $item->quality++;
                    if ($item->sell_in < self::DEADLINE) {
                        $item->quality++;
                    }
                    break;
                case 'Backstage passes to a TAFKAL80ETC concert':
                    $item->quality++;
                    if ($item->sell_in < self::SETTINGS['fasterQualityGain']) {
                        $item->quality++;
                    }
                    if ($item->sell_in < self::SETTINGS['fastestQualityGain']) {
                        $item->quality++;
                    }
                    if ($item->sell_in < self::DEADLINE) {
                        $item->quality = self::SETTINGS['lowestQuality'];
                    }
                    break;
                case 'Conjured Mana Muffin':
                    $item->quality--;
                    if ($item->sell_in < self::DEADLINE) {
                        $item->quality--;
                    }
                default:
                    $item->quality--;
                    if ($item->sell_in < self::DEADLINE) {
                        $item->quality--;
                    }
                    break;
            }

            if ($item->name != 'Sulfuras, Hand of Ragnaros') {
                if ($item->quality > self::SETTINGS['highestQuality']) {
                    $item->quality = self::SETTINGS['highestQuality'];
                }
                if ($item->quality < self::SETTINGS['lowestQuality']) {
                    $item->quality = self::SETTINGS['lowestQuality'];
                }
            }
        }
    }
}
