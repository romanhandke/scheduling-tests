<?php

declare(strict_types=1);

namespace App\Entity;

use DateTime;

class Item
{
    protected bool $isActive;
    protected ?DateTime $activeFrom;
    protected ?DateTime $activeTo;

    public function isLive(): bool
    {
        if (!$this->isActive()) {
            return false;
        }

        if (!$this->hasSchedule()) {
            return true;
        }

        if ($this->isInSchedule(new DateTime())) {
            return true;
        }

        return false;
    }

    public function hasSchedule(): bool
    {
        return $this->getActiveFrom() || $this->getActiveTo();
    }

    public function isInSchedule(DateTime $date): bool
    {
        if ($this->getActiveFrom() && $date < $this->getActiveFrom()) {
            return false;
        }

        if ($this->getActiveTo() && $date > $this->getActiveTo()) {
            return false;
        }

        return true;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): Item
    {
        $this->isActive = $isActive;
        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getActiveFrom(): ?DateTime
    {
        return $this->activeFrom;
    }

    /**
     * @param DateTime|null $activeFrom
     * @return Item
     */
    public function setActiveFrom(?DateTime $activeFrom): Item
    {
        $this->activeFrom = $activeFrom;
        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getActiveTo(): ?DateTime
    {
        return $this->activeTo;
    }

    /**
     * @param DateTime|null $activeTo
     * @return Item
     */
    public function setActiveTo(?DateTime $activeTo): Item
    {
        $this->activeTo = $activeTo;
        return $this;
    }
}

