<?php

namespace InterestModels;

/**
 * Created by PhpStorm.
 * User: ahmetgunes
 * Date: 14.04.2016
 * Time: 20:59
 */
class Interest
{
    private $days;

    private $amount;

    public function __construct($days, $amount)
    {
        $this->days = $days;
        $this->amount = $amount;
    }

    public function calculateTotalInterest()
    {
        $divisibleBy15 = floor($this->days / 15);
        $divisibleBy3 = floor($this->days / 3 - $divisibleBy15);
        $divisibleBy5 = floor($this->days / 5 - $divisibleBy15);
        $nonDivisibles = floor($this->days - $divisibleBy15 - $divisibleBy3 - $divisibleBy5);

        $interest = $this->amount * (round($divisibleBy15) * 3 + round($divisibleBy3) * 1 + round($divisibleBy5) * 2 + 4 * round($nonDivisibles)) / 100;
        return $interest;
    }

    /**
     * @return mixed
     */
    public function getDays()
    {
        return $this->days;
    }

    /**
     * @param mixed $days
     */
    public function setDays($days)
    {
        $this->days = $days;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param mixed $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }
}