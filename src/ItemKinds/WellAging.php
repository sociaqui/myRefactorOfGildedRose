<?php

declare(strict_types=1);

namespace GildedRose\ItemKinds;

use GildedRose\ItemKind;

/**
 * Class WellAging
 * @package GildedRose\ItemKinds
 */
class WellAging extends ItemKind
{
    /**
     * @inheritdoc
     */
    const NAME = 'WellAging';

    /**
     * @inheritdoc
     */
    const ITEM_NAMES = [
        'Aged Brie',
        'Aged Camembert',
        'Aged Roquefort',
        'Well Aged Wine',
        'Exquisite Wine',
        'Great Champagne',
        'Intriguing Porto',
        'Single Malt Whiskey',
        'Well Aged Scotch',
        'Triple-distilled Cognac',
    ];

    /**
     * Quality increases instead of decreasing for Well Aging Items
     *
     * @var int
     */
    protected static $qualityStep = 1;
}