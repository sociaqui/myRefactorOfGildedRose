<?php

declare(strict_types=1);

namespace GildedRose;

use GildedRose\Item;

/**
 * Class ItemKind
 * @package \GildedRose
 */
abstract class ItemKind
{
    /* The default values for a new Item Kind */

    /**
     * The name of the Item Kind
     *
     * @var string
     */
    const NAME = '';

    /**
     * An array containing possible/typical names of Items of this class
     *
     * @var string[]
     */
    const ITEM_NAMES = [];

    /**
     * The highest quality an Item of this Kind can have.
     *
     * @var int
     */
    protected static $highestQuality = 50;

    /**
     * The lowest quality an Item of this Kind can have.
     *
     * @var int
     */
    protected static $lowestQuality = 0;

    /* End of default values for new Item Kind */

    /**
     * The sell by date. 0 (obviously). Declared for readability, not to be changed.
     * The sell in parameter means how many days until this deadline (negative sell in means days after).
     *
     * @var int DEADLINE
     */
    private const DEADLINE = 0;

    /**
     * @var
     */
    protected $item;

    /**
     * Item Kind constructor.
     *
     * @param $item
     */
    public function __construct($item)
    {
        $this->item = $item;
    }

    /**
     *  Updates the sell in and quality values.
     */
    public function update(): void
    {
        $this->updateSellIn();
        $this->updateQuality();
    }

    /**
     *  Updates the sell in and quality values.
     */
    public function updateSellIn(): void
    {
        //TODO: move the updating logic here from the Gilded Rose class
        // so each Item Kind "knows" how to update itself
    }

    /**
     *  Updates the sell in and quality values.
     */
    public function updateQuality(): void
    {
        //TODO: move the updating logic here from the Gilded Rose class
        // so each Item Kind "knows" how to update itself
    }

    /**
     * Returns the Item
     *
     * @return Item
     */
    public function getItem(): Item
    {
        return $this->item;
    }

    /**
     * Returns the highest quality an Item of this Kind can have.
     *
     * @return int
     */
    public static function getHighestQuality(): int
    {
        return static::$highestQuality;
    }

    /**
     * Returns the lowest quality an Item of this Kind can have.
     *
     * @return int
     */
    public static function getLowestQuality(): int
    {
        return static::$lowestQuality;
    }
}