<?php

declare(strict_types=1);

namespace GildedRose;

/**
 * Class Ware
 * @package \GildedRose
 */
abstract class Ware
{
    /* The default values for a new type of Ware */

    /**
     * The name of the Ware
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
     * The highest quality an Item of this Class can have.
     *
     * @var int
     */
    protected static $highestQuality = 50;

    /**
     * The lowest quality an Item of this Class can have.
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

    /**
     * Determines whether the Ware is perishable or not (loses all quality after the sale by date)
     * False by default.
     *
     * @var bool
     */
    protected static $perishable = false;

    /* End of default values for new Ware */

    /**
     * The sell by date. 0 (obviously). Declared for readability, not to be changed.
     * The sell in parameter means how many days until this deadline (negative sell in means days after).
     *
     * @var int DEADLINE
     */
    protected const DEADLINE = 0;

    /**
     * @var Item
     */
    protected $item;

    /**
     * Ware constructor.
     *
     * @param Item $item
     */
    public function __construct(Item $item)
    {
        $this->item = $item;
    }

    /**
     * Updates the sell in and quality values.
     * If Item is perishable, it expires after the sale by date
     */
    public function update(): void
    {
        $this->updateSellIn();
        $this->updateQuality();
        $this->expiresAfterSale();
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
     * Returns the highest quality an Item of this Class can have.
     *
     * @return int
     */
    public static function getHighestQuality(): int
    {
        return static::$highestQuality;
    }

    /**
     * Returns the lowest quality an Item of this Class can have.
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

    /**
     * Returns true if the Item is past the sale by date
     *
     * @return bool
     */
    public function isAfterSale(): bool
    {
        return $this->item->sell_in < self::DEADLINE;
    }

    /**
     * Returns true if the Item is perishable (loses all quality after the sale by date)
     *
     * @return bool
     */
    public function isPerishable(): bool
    {
        return static::$perishable;
    }

    /**
     * Changes the quality to the lowest possible value for the Ware if Ware is perishable
     * and the date is after the sell by date.
     */
    public function expiresAfterSale(): void
    {
        if ($this->isPerishable() && $this->isAfterSale()) {
            $this->setToLowestQuality();
        }
    }

    /**
     * Randomly return one of the names in the ITEM_NAMES array
     *
     * @return string
     */
    public static function generateName(): string
    {
        return self::randomArrayElement(self::ITEM_NAMES);
    }

    /**
     * Randomly return a value between the sell by DEADLINE and 99
     *
     * @return int
     */
    public static function generateSellInValue(): int
    {
        return rand(self::DEADLINE, 99);
    }

    /**
     * Randomly return a value between the lowest and highest possible qualities for this Ware
     *
     * @return int
     */
    public static function generateQualityValue(): int
    {
        return rand(self::getLowestQuality(), self::getHighestQuality());
    }

    /**
     * Returns a random element from the provided array
     *
     * @param array $possibilities
     *
     * @return mixed
     */
    protected static function randomArrayElement(array $possibilities)
    {
        return $possibilities[rand(0, count($possibilities)-1)];
    }
}