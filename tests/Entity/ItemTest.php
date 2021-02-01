<?php

declare(strict_types=1);

use App\Entity\Item;
use PHPUnit\Framework\TestCase;

class ItemTest extends TestCase
{
    public function provider(): array
    {
        $today = new DateTime();
        $start = time();
        $before = new DateTime(date('Y-m-d H:i:s', strtotime('-2 days', $start)));
        $after = new DateTime(date('Y-m-d H:i:s', strtotime('+2 days', $start)));

        return [
            [$today, $before, $after],
            [$today, $before, null],
            [$today, $today, $after],
            [$today, $today, null],
            [$today, null, null],
            [$today, null, $after],
        ];
    }

    /**
     * @dataProvider provider
     * @param DateTime $toTest
     * @param DateTime|null $fromDate
     * @param DateTime|null $toDate
     */
    public function testIsLiveReturnsTrueIfActiveAndInSchedule(
        DateTime $toTest,
        ?DateTime $fromDate,
        ?DateTime $toDate
    ): void {
        $item = new Item();
        $item->setIsActive(true);
        $item->setActiveFrom($fromDate);
        $item->setActiveTo($toDate);

        $this->assertTrue($item->isLive());
    }

    /**
     * @dataProvider provider
     * @param DateTime $toTest
     * @param DateTime|null $fromDate
     * @param DateTime|null $toDate
     */
    public function testIsLiveReturnsFalseIfInactiveAndInSchedule(
        DateTime $toTest,
        ?DateTime $fromDate,
        ?DateTime $toDate
    ): void {
        $item = new Item();
        $item->setIsActive(false);
        $item->setActiveFrom($fromDate);
        $item->setActiveTo($toDate);

        $this->assertFalse($item->isLive());
    }

    /**
     * @dataProvider provider
     * @param DateTime $toTest
     * @param DateTime|null $fromDate
     * @param DateTime|null $toDate
     */
    public function testIsInSchedule(DateTime $toTest, ?DateTime $fromDate, ?DateTime $toDate): void
    {
        $item = new Item();
        $item->setActiveFrom($fromDate);
        $item->setActiveTo($toDate);

        $this->assertTrue($item->isInSchedule($toTest));
    }

    /**
     * @dataProvider provider
     * @param DateTime $toTest
     * @param DateTime|null $fromDate
     * @param DateTime|null $toDate
     */
    public function testHasSchedule(DateTime $toTest, ?DateTime $fromDate, ?DateTime $toDate): void
    {
        $item = new Item();
        $item->setActiveFrom($fromDate);
        $item->setActiveTo($toDate);

        if (!$fromDate && !$toDate) {
            $this->assertFalse($item->hasSchedule());
        } else {
            $this->assertTrue($item->hasSchedule());
        }
    }
}
