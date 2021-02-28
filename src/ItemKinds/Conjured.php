<?php

declare(strict_types=1);

namespace GildedRose\ItemKinds;

use GildedRose\ItemKind;

/**
 * Class Conjured
 * @package GildedRose\ItemKinds
 */
class Conjured extends ItemKind
{
    /**
     * @inheritdoc
     */
    const NAME = 'Conjured';

    /**
     * @inheritdoc
     */
    const ITEM_NAMES = [
        'Conjured Mana Cake',
        'Conjured Mana Muffin',
        'Conjured Mana Bun',
        'Conjured Mana Brownie',
        'Conjured Mana Biscuit',
        'Conjured Mana Strudel',
        'Conjured Mana Bread',
        'Conjured Mana Sourdough',
        'Conjured Mana Cookie',
        'Conjured Mana Croissant',
        'Conjured Mana Crystal',
        'Conjured Mana Gem',
        'Conjured Mana Ruby',
        'Conjured Mana Citron',
        'Conjured Mana Jade',
        'Conjured Mana Agate',
        'Conjured Mana Agate',
        'Conjured Water',
        'Conjured Fresh Water',
        'Conjured Purified Water',
        'Conjured Spring Water',
        'Conjured Mineral Water',
        'Conjured Sparkling Water',
        'Conjured Crystal Water',
        'Conjured Mountain Spring Water',
        'Conjured Glacier Water',
    ];

    /**
     * Quality decreases by 2 every day for Conjured Items
     *
     * @var int
     */
    protected static $qualityStep = -2;
}