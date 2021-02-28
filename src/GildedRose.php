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
     * @var Item[] $items
     */
    private static $items = [];

    /**
     * @var WareFactory
     */
    public static $wareFactory;

    /**
     * GildedRose constructor.
     * Requires an array of Items (current inventory) to be passed.
     * Requires a WareFactory (builder of Wares) to be passed.
     *
     * @param array $items
     * @param WareFactory $wareFactory
     */
    public function __construct(array $items, WareFactory $wareFactory)
    {
        static::$items = $items;
        static::$wareFactory = $wareFactory;
    }

    /**
     * Updates all items in the GildedRose item Collection.
     * Lowers sell in and lowers or rises quality in accordance with the Requirements Specification.
     * (should be invoked once per day, at the end of the day, every day)
     */
    public function updateQuality(): void
    {
        foreach (static::$items as $item) {
            static::$wareFactory->build($item)->update();
        }
    }
}
