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
        return self::newObject($this->findWareInRegistryByName($item->name), $item);
    }

    protected function getWaresFromRegistry(): array
    {
        return $this->waresRegistry->getWares();
    }

    protected function getItemNamesFromRegistry(): array
    {
        return $this->waresRegistry->getWares();
    }

    protected function findWareInRegistryByName($name): string
    {
        $wares = $this->getWaresFromRegistry();
        if (array_key_exists($name, $wares)) {
            return $wares[$name];
        } else {
            return WaresRegistry::DEFAULT_WARE;
        }
    }

    protected function findWareInRegistryByItemName($itemName): string
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
}