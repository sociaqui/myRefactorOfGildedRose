<?php

namespace GildedRose;

/**
 * Class WareFactory
 * @package \GildedRose
 */
class WareFactory
{
    /**
     * @var WaresRegistry
     */
    private $waresRegistry;

    /**
     * WareFactory constructor.
     * @param WaresRegistry $wareFactoryRegistry
     */
    public function __construct(WaresRegistry $wareFactoryRegistry)
    {
        $this->waresRegistry = $wareFactoryRegistry;
    }

    /**
     * Returns a Ware of the appropriate class
     * built from an existing Item
     *
     * @param Item $item
     * @return Ware
     */
    public function build(Item $item): Ware
    {
        return self::newObject($this->findWareInRegistryByItemName($item->name), $item);
    }

    /**
     * @return array
     */
    protected function getWaresFromRegistry(): array
    {
        return $this->waresRegistry->getWares();
    }

    /**
     * @return array
     */
    protected function getItemNamesFromRegistry(): array
    {
        return $this->waresRegistry->getItemNames();
    }

    /**
     * Finds a Ware Class in the Registry by it's name.
     *
     * @param string $name
     * @return string
     */
    protected function findWareInRegistryByName(string $name): string
    {
        $wares = $this->getWaresFromRegistry();
        if (array_key_exists($name, $wares)) {
            return $wares[$name];
        } else {
            return WaresRegistry::DEFAULT_WARE;
        }
    }

    /**
     * Finds a Ware Class in the Registry by the name of an Item assigned to it.
     *
     * @param string $itemName
     * @return string
     */
    protected function findWareInRegistryByItemName(string $itemName): string
    {
        $itemNames = $this->getItemNamesFromRegistry();
        if (array_key_exists($itemName, $itemNames)) {
            return $this->findWareInRegistryByName($itemNames[$itemName]);
        } else {
            return WaresRegistry::DEFAULT_WARE;
        }
    }

    /**
     * Creates a new Object of the given class
     * (one that was part of the WaresRegistry)
     * with the given Item at it's core
     *
     * @param string $className
     * @param Item $item
     * @return Ware
     */
    protected static function newObject(string $className, Item $item): Ware
    {
        return new $className($item);
    }

    /**
     * Item maker. Make an Item following given Ware Class limitations.
     * Provide a name and/or sell in value and/or quality value
     * or let the semi-random generator decide for you.
     *
     * @param class-string $wareClass
     * @param string|null $name
     * @param int|null $sellIn
     * @param int|null $quality
     *
     * @return Item
     */
    public static function makeItem(string $wareClass, ?string $name = null, ?int $sellIn = null, ?int $quality = null): Item
    {
        // If no name was provided to constructor -- get a semi-random one!
        if (is_null($name)) {
            $name = $wareClass::generateName();
        }

        // If no sell in value was provided to constructor -- get a semi-random one!
        if (is_null($sellIn)) {
            $sellIn = $wareClass::generateSellInValue();
        }

        // If no quality was provided to constructor -- get a semi-random one!
        if (is_null($quality)) {
            $quality = $wareClass::generateQualityValue();
        }

        return new Item($name, $sellIn, $quality);
    }
}