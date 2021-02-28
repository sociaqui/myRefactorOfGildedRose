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

    /**
     * Quality step -- quality decreases by this amount each day.
     *
     * @var int
     */
    protected static $qualityStep = -1;

    /**
     * Quality step multiplayer range -- below how many days to the sell by date, the quality starts to change faster,
     * and by how much (default: on the sell by day -- twice)
     *
     * After sale date; it's twice as fast
     *
     * @var array
     */
    protected static $qualityStepMultiplier = [
        self::DEADLINE => 2,
    ];

    /* End of default values for new Item Kind */

    /**
     * The sell by date. 0 (obviously). Declared for readability, not to be changed.
     * The sell in parameter means how many days until this deadline (negative sell in means days after).
     *
     * @var int DEADLINE
     */
    private const DEADLINE = 0;

    /**
     * @var Item
     */
    protected $item;

    /**
     * ItemOfAKind constructor.
     *
     * @param Item $item
     */
    public function __construct(Item $item)
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
        $this->getItem()->sell_in--;
    }

    /**
     *  Updates the sell in and quality values.
     */
    public function updateQuality(): void
    {
        $this->getItem()->quality = $this->getNewQuality();

        if ($this->isQualityOverHighestValue()) {
            $this->setToHighestQuality();
        }
        if ($this->isQualityUnderLowestValue()) {
            $this->setToLowestQuality();
        }
    }

    /**
     * Returns the quality step multiplayer
     * depending on sell in value and internal settings.
     *
     * @return int
     */
    public function getMultiplier(): int
    {
        $multiplier = 1;

        foreach (static::$qualityStepMultiplier as $day => $dayMultiplier) {
            if ($this->getItem()->sell_in <= $day) {
                $multiplier = $dayMultiplier;
            }
        }

        return $multiplier;
    }

    /**
     * Returns the proper quality step of this Item
     * taking into account the proper multiplier.
     *
     * @return int
     */
    public function getQualityStep(): int
    {
        return static::$qualityStep * $this->getMultiplier();
    }

    /**
     * Returns the quality with a step
     *
     * @return int
     */
    public function getNewQuality(): int
    {
        return $this->item->quality + $this->getQualityStep();
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

    /**
     * @return bool
     */
    protected function isQualityOverHighestValue(): bool
    {
        return $this->getItem()->quality > $this->getHighestQuality();
    }

    /**
     * @return bool
     */
    protected function isQualityUnderLowestValue(): bool
    {
        return $this->getItem()->quality < $this->getLowestQuality();
    }

    /**
     * @return void
     */
    protected function setToHighestQuality(): void
    {
        $this->getItem()->quality = $this->getHighestQuality();
    }

    /**
     * Sets Item Quality to it's lowest possible value.
     *
     * @return void
     */
    protected function setToLowestQuality(): void
    {
        $this->getItem()->quality = $this->getLowestQuality();
    }
}