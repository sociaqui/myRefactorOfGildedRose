<?php

declare(strict_types=1);

namespace GildedRose\ItemKinds;

use GildedRose\ItemKind;

/**
 * Class Common
 * @package GildedRose\ItemKinds
 */
class Common extends ItemKind
{
    /**
     * @inheritdoc
     */
    const NAME = 'Common';

    /**
     * @inheritdoc
     */
    const ITEM_NAMES = [
        'Bread',
        'Stale bread',
        'Hunk of meat',
        'Weak Wine',
        'Water',
        'Health Potion',
        'Vile Vambrace',
        'Mundane Staff of Mundanity',
        'Wooden Shield',
        'Rusty Chainail',
        'Blunt Sword',
    ];
}