<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(
 *     name="euromillions_draws",
 *     uniqueConstraints={@ORM\UniqueConstraint(name="renditions_unique_name", columns={"draw_date"})}
 * )
 * @ORM\Entity(repositoryClass="App\Repository\DrawDbRepository")
 */
class Draw
{
    /**
     * @var int
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var int
     * @ORM\Column(name="lottery_id", type="int", length=128, nullable=true)
     */
    private $lotteryId;

    /**
     * @var string
     * @ORM\Column(name="draw_date", type="datetime", length=128, nullable=false)
     */
    private $drawDate;

    /**
     * @var int
     * @ORM\Column(name="result_regular_number_one", type="integer", nullable=true)
     */
    private $resultRegularNumberOne;

    /**
     * @var int
     * @ORM\Column(name="result_regular_number_two", type="integer", nullable=true)
     */
    private $resultRegularNumberTwo;

    /**
     * @var int
     * @ORM\Column(name="result_regular_number_three", type="integer", nullable=true)
     */
    private $resultRegularNumberThree;

    /**
     * @var int
     * @ORM\Column(name="result_regular_number_four", type="integer", nullable=true)
     */
    private $resultRegularNumberFour;

    /**
     * @var int
     * @ORM\Column(name="result_regular_number_five", type="integer", nullable=true)
     */
    private $resultRegularNumberFive;

    /**
     * @var int
     * @ORM\Column(name="result_lucky_number_one", type="integer", nullable=true)
     */
    private $resultLuckyNumberOne;

    /**
     * @var int
     * @ORM\Column(name="result_lucky_number_two", type="integer", nullable=true)
     */
    private $resultLuckyNumberTwo;

    /**
     * @var int
     * @ORM\Column(name="jackpot_amount", type="integer", nullable=true)
     */
    private $jackpoAmount;

    /**
     * @var int
     * @ORM\Column(name="jackpot_currency_name", type="integer", nullable=true)
     */
    private $jackpotCurrencyName;

    /**
     * Test constructor.
     * @param int $id
     * @param int $lotteryId
     * @param string $drawDate
     * @param int $resultRegularNumberOne
     * @param int $resultRegularNumberTwo
     * @param int $resultRegularNumberThree
     * @param int $resultRegularNumberFour
     * @param int $resultRegularNumberFive
     * @param int $resultLuckyNumberOne
     * @param int $resultLuckyNumberTwo
     * @param int $jackpoAmount
     * @param int $jackpotCurrencyName
     */
    public function __construct(
        $id,
        $lotteryId,
        $drawDate,
        $resultRegularNumberOne,
        $resultRegularNumberTwo,
        $resultRegularNumberThree,
        $resultRegularNumberFour,
        $resultRegularNumberFive,
        $resultLuckyNumberOne,
        $resultLuckyNumberTwo,
        $jackpoAmount,
        $jackpotCurrencyName
    ) {
        $this->id = $id;
        $this->lotteryId = $lotteryId;
        $this->drawDate = $drawDate;
        $this->resultRegularNumberOne = $resultRegularNumberOne;
        $this->resultRegularNumberTwo = $resultRegularNumberTwo;
        $this->resultRegularNumberThree = $resultRegularNumberThree;
        $this->resultRegularNumberFour = $resultRegularNumberFour;
        $this->resultRegularNumberFive = $resultRegularNumberFive;
        $this->resultLuckyNumberOne = $resultLuckyNumberOne;
        $this->resultLuckyNumberTwo = $resultLuckyNumberTwo;
        $this->jackpoAmount = $jackpoAmount;
        $this->jackpotCurrencyName = $jackpotCurrencyName;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getLotteryId()
    {
        return $this->lotteryId;
    }

    /**
     * @return string
     */
    public function getDrawDate()
    {
        return $this->drawDate;
    }

    /**
     * @return int
     */
    public function getResultRegularNumberOne()
    {
        return $this->resultRegularNumberOne;
    }

    /**
     * @return int
     */
    public function getResultRegularNumberTwo()
    {
        return $this->resultRegularNumberTwo;
    }

    /**
     * @return int
     */
    public function getResultRegularNumberThree()
    {
        return $this->resultRegularNumberThree;
    }

    /**
     * @return int
     */
    public function getResultRegularNumberFour()
    {
        return $this->resultRegularNumberFour;
    }

    /**
     * @return int
     */
    public function getResultRegularNumberFive()
    {
        return $this->resultRegularNumberFive;
    }

    /**
     * @return int
     */
    public function getResultLuckyNumberOne()
    {
        return $this->resultLuckyNumberOne;
    }

    /**
     * @return int
     */
    public function getResultLuckyNumberTwo()
    {
        return $this->resultLuckyNumberTwo;
    }

    /**
     * @return int
     */
    public function getJackpotAmount()
    {
        return $this->jackpoAmount;
    }

    /**
     * @return int
     */
    public function getJackpotCurrencyName()
    {
        return $this->jackpotCurrencyName;
    }

    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'drawdate' => $this->drawDate,
            'regular_number_one' => $this->getResultRegularNumberOne(),
            'regular_number_two' => $this->getResultRegularNumberTwo(),
            'regular_number_three' => $this->getResultRegularNumberThree(),
            'regular_number_for' => $this->getResultRegularNumberFour(),
            'regular_number_five' => $this->getResultRegularNumberFive(),
            'lucky_number_one' => $this->getResultLuckyNumberOne(),
            'lucky_number_two' => $this->getResultLuckyNumberTwo(),
            'jackpot_amount' => $this->getJackpotAmount(),
            'jackpot_currency_name' => $this->getJackpotCurrencyName()
        ];
    }
}

