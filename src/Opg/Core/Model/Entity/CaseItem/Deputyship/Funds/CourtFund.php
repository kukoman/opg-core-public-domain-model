<?php


namespace Opg\Core\Model\Entity\CaseItem\Deputyship\Funds;

use Doctrine\ORM\Mapping as ORM;
use Opg\Common\Model\Entity\HasIdInterface;
use Opg\Common\Model\Entity\HasStatusDate;
use Opg\Common\Model\Entity\Traits\HasId;
use JMS\Serializer\Annotation\GenericAccessor;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\Groups;

/**
 * Class CourtFunds
 * @package Opg\Core\Model\Entity\CaseItem\Deputyship\Funds
 *
 * @ORM\Entity
 */
class CourtFund implements HasIdInterface
{
    use HasId;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @var float
     * @Groups({"api-poa-list","api-task-list","api-person-get"})
     */
    protected $previousBalance = 0;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @var float
     * @Groups({"api-poa-list","api-task-list","api-person-get"})
     */
    protected $accountBalance = 0;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @var \DateTime
     * @Groups({"api-poa-list","api-task-list","api-person-get"})
     * @GenericAccessor(getter="getDateAsString", setter="setDateFromString", propertyName="lastUpdatedDate")
     * @Type("string")
     */
    protected $lastUpdatedDate;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     * @Groups({"api-poa-list","api-task-list","api-person-get"})
     * @GenericAccessor(getter="getDateAsString", setter="setDateFromString", propertyName="orderDate")
     * @Type("string")
     */
    protected $fundStatus;

    /**
     * @param float $accountBalance
     * @return CourtFund
     */
    public function setAccountBalance($accountBalance)
    {
        $this->accountBalance = (float)$accountBalance;

        return $this;
    }

    /**
     * @return float
     */
    public function getAccountBalance()
    {
        return $this->accountBalance;
    }

    /**
     * @param string $fundStatus
     * @return CourtFund
     */
    public function setFundsStatus($fundStatus)
    {
        $this->fundStatus = $fundStatus;

        return $this;
    }

    /**
     * @return string
     */
    public function getFundStatus()
    {
        return $this->fundStatus;
    }

    /**
     * @param \DateTime $lastUpdatedDate
     * @return CourtFund
     */
    public function setLastUpdatedDate(\DateTime $lastUpdatedDate)
    {
        $this->lastUpdatedDate = $lastUpdatedDate;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getLastUpdatedDate()
    {
        return $this->lastUpdatedDate;
    }

    /**
     * @param float $previousBalance
     * @return CourtFund
     */
    public function setPreviousBalance($previousBalance)
    {
        $this->previousBalance = (float)$previousBalance;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPreviousBalance()
    {
        return $this->previousBalance;
    }


}
