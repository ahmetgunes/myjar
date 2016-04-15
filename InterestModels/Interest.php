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

    protected function calculateInterest()
    {
        $divisibleBy15 = floor($this->days / 15);
        $divisibleBy3 = floor($this->days / 3) - $divisibleBy15;
        $divisibleBy5 = floor($this->days / 5) - $divisibleBy15;
        $nonDivisibles = $this->days - $divisibleBy15 - $divisibleBy3 - $divisibleBy5;
        $interest = $this->amount * ($divisibleBy15 * 3 + $divisibleBy3 * 1 + $divisibleBy5 * 2 + $nonDivisibles * 4) / 100;
        return round($interest, 2);
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

    public function getLoanResult()
    {
        $interest = $this->calculateInterest();
        $loanInfo = array();
        $loanInfo['sum'] = $this->amount;
        $loanInfo['days'] = $this->days;
        $loanInfo['interest'] = $interest;
        $loanInfo['totalSum'] = $interest + $this->amount;
        $loanInfo['token'] = 'MasterYoda';
        return $loanInfo;
    }
}
