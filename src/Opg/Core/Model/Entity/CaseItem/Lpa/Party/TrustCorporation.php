<?php
namespace Opg\Core\Model\Entity\CaseItem\Lpa\Party;

use Doctrine\ORM\Mapping as ORM;
use Opg\Common\Model\Entity\Traits\ExchangeArray;
use Opg\Common\Model\Entity\Traits\ToArray;

/**
 * @ORM\Entity
 *
 * Class TrustCorporation
 * @package Opg\Core\Model\Entity\CaseItem\Lpa\Party
 */
class TrustCorporation extends AttorneyAbstract
{
    use ToArray;
    use ExchangeArray;

    const AS_ATTORNEY             = 'Attorney';
    const AS_REPLACEMENT_ATTORNEY = 'Replacement Attorney';

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    protected $trustCorporationAppointedAs;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    protected $signatoryOne;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    protected $signatoryTwo;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    protected $companySeal;

    /**
     * @param string $trustCorporationAppointedAs
     * @return TrustCorporation
     */
    public function setTrustCorporationAppointedAs($trustCorporationAppointedAs)
    {
        $this->trustCorporationAppointedAs = $trustCorporationAppointedAs;

        return $this;
    }

    /**
     * @return string
     */
    public function getTrustCorporationAppointedAs()
    {
        return $this->trustCorporationAppointedAs;
    }

    /**
     * @param string $companySeal
     * @return TrustCorporation
     */
    public function setCompanySeal($companySeal)
    {
        $this->companySeal = $companySeal;

        return $this;
    }

    /**
     * @return string
     */
    public function getCompanySeal()
    {
        return $this->companySeal;
    }

    /**
     * @param string $signatoryOne
     * @return TrustCorporation
     */
    public function setSignatoryOne($signatoryOne)
    {
        $this->signatoryOne = $signatoryOne;

        return $this;
    }

    /**
     * @return string
     */
    public function getSignatoryOne()
    {
        return $this->signatoryOne;
    }

    /**
     * @param string $signatoryTwo
     * @return TrustCorporation
     */
    public function setSignatoryTwo($signatoryTwo)
    {
        $this->signatoryTwo = $signatoryTwo;

        return $this;
    }

    /**
     * @return string
     */
    public function getSignatoryTwo()
    {
        return $this->signatoryTwo;
    }
}
