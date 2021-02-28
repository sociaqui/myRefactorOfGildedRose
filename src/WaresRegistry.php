<?php

namespace GildedRose;

use GildedRose\Wares\Common;

/**
 * Class WaresRegistry
 * @package \GildedRose
 */
class WaresRegistry
{
    /**
     * List of wares
     * @var array
     */
    protected $wares = [];

    /**
     * List of item names
     * @var array
     */
    protected $items = [];

    /**
     * Fully qualified name of the most common Ware (default class)
     */
    const DEFAULT_WARE = Common::class;

    /**
     * Adds a ware to the wares list
     * and it's item name list to the item names list
     *
     * @param class-string $ware
     */
    public function register(string $ware): void
    {
        $this->wares[$ware::NAME] = $ware;
        $newItems = array_fill_keys($ware::ITEM_NAMES, $ware::NAME);
        $this->items += $newItems;
    }

    /**
     * Returns a list of wares
     * @return array
     */
    public function getWares(): array
    {
        return $this->wares;
    }

    /**
     * Returns a list of item names with Ware Class names assigned to them
     * @return array
     */
    public function getItemNames(): array
    {
        return $this->items;
    }
}