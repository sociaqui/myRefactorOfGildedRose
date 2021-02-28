<?php

declare(strict_types=1);

namespace GildedRose\Wares;

use GildedRose\Ware;

/**
 * Class Ticket
 * @package GildedRose\Wares
 */
class Ticket extends Ware
{
    /**
     * @inheritdoc
     */
    const NAME = 'Ticket';

    /**
     * @inheritdoc
     */
    const ITEM_NAMES = [
        'Backstage passes to a TAFKAL80ETC concert',
        'Backstage passes to a Lady Gaga concert',
        'Backstage passes to a System of a Down concert',
        'Backstage passes to the Opera',
        'Backstage passes to a Heineken\'s Brewery',
        'Tickets to the Circus',
        'Tickets to the Zoo',
        'Tickets to the New Keanu Reeves Movie',
        'Tickets to a Scary Movie Marathon',
        'Tickets to a Star Wars Marathon',
    ];

    /**
     * Quality increases instead of decreasing for Tickets
     *
     * @var int
     */
    protected static $qualityStep = 1;

    /**
     * Quality step multiplayer range -- below how many days to the sell by date,
     * the quality starts to change faster, and by how much -- for Tickets it's:
     *
     * After 10th day to sale date; it's twice as fast
     * After 5th day to sale date; it's three times as fast
     *
     * @var array
     */
    protected static $qualityStepMultiplier = [
        10 => 2,
        5 => 3,
    ];

    /**
     * @inheritdoc
     */
    protected static $perishable = true;
}