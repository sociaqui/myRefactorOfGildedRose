<?php

declare(strict_types=1);

namespace Tests;

use GildedRose\Item;
use GildedRose\WareFactory;
use GildedRose\Wares\Common;
use GildedRose\Wares\Conjured;
use GildedRose\Wares\Legendary;
use GildedRose\Wares\Ticket;
use GildedRose\Wares\Uncommon;
use GildedRose\Wares\WellAging;
use GildedRose\WaresRegistry;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class WareFactoryTest extends TestCase
{

    /**
     * @var wareFactory
     */
    private $wareFactory;

    /**
     * @var WaresRegistry | MockObject
     */
    private $waresRegistry;

    /**
     *  Set up WareFactory with a Mock Registry
     */
    protected function setUp(): void
    {
        $this->waresRegistry = $this->getMockBuilder(WaresRegistry::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->wareFactory = new wareFactory($this->waresRegistry);
    }

    /**
     * @covers       GildedRose\WareFactory::build
     * @dataProvider buildableClassDataProvider
     *
     * @param $itemName
     * @param $expectedClass
     */
    public function testIfBuildsTheRightClass($itemName, $expectedClass)
    {
        $this->waresRegistry
            ->expects($this->any())
            ->method('getWares')
            ->will($this->returnValue([$expectedClass => $expectedClass]));

        $this->waresRegistry
            ->expects($this->any())
            ->method('getItemNames')
            ->will($this->returnValue([$itemName => $expectedClass]));

        $this->assertInstanceOf($expectedClass, $this->wareFactory->build(new Item($itemName, 10, 0)));
    }

    /**
     * @return array
     */
    public function buildableClassDataProvider()
    {
        return [
            'Some common junk' => ['Regular Product', Common::class],
            'An uncommon item' => ['+5 Dexterity Vest', Uncommon::class],
            'An uncommon elixir' => ['Elixir of the Mongoose', Uncommon::class],
            'A legendary weapon' => ['Sulfuras, Hand of Ragnaros', Legendary::class],
            'Some well aging cheese' => ['Aged Brie', WellAging::class],
            'Some tickets' => ['Backstage passes to a TAFKAL80ETC concert', Ticket::class],
            'Different tickets' => ['Tickets to the Zoo', Ticket::class],
            'A conjured mirage' => ['Conjured Mana Muffin', Conjured::class],
            'Some totally random name' => ['AK-47', Common::class],
        ];
    }
}
