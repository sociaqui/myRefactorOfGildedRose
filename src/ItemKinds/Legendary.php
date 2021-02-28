<?php

declare(strict_types=1);

namespace GildedRose\ItemKinds;

use GildedRose\ItemKind;

/**
 * Class Common
 * @package GildedRose\ItemKinds
 */
class Legendary extends ItemKind
{
    /**
     * @inheritdoc
     */
    const NAME = 'Legendary';

    /**
     * @inheritdoc
     */
    const ITEM_NAMES = [
        'Sulfuras, Hand of Ragnaros',
        'Thunderfury, Blessed Blade of the Windseeker',
        'Andonisus, Reaper of Souls',
        'Atiesh, Greatstaff of the Guardian',
        'Cosmic Infuser',
        'Infinity Blade',
        'Phaseshift Bulwark',
        'Staff of Disintegration',
        'Warp Slicer',
        'Warglaive of Azzinoth',
        'Thori\'dal, the Stars\' Fury',
        'The Philosopher\'s Stone',
        'Excalibur',
        'Abyssal Mask.',
        'Archangel\'s Staff.',
        'Ardent Censer.',
        'Banshee\'s Veil',
        'Black Mist Scythe',
        'Blade of the Ruined King',
        'Bloodthirster',
    ];

    /**
     *  The quality is 80 and it NEVER alters
     */
    const QUALITY = 80;

    /**
     * Legendary Item constructor. Legendary Items will always have a quality of 80.
     * Provide a name and/or sell in value or let the semi-random generator decide for you.
     *
     * @param string|null $name
     * @param int|null $sellIn
     */
    public function __construct(?string $name = null, ?int $sellIn = null)
    {
        parent::__construct($name, $sellIn, self::QUALITY);
    }

    /**
     * Do nothing (both quality and sell in stay the same)
     */
    public function update(): void
    {
    }
}