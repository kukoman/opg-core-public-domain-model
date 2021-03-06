<?php

namespace Opg\Core\Model\Entity\Warning;

use Opg\Common\Model\Entity\DateFormat;
use Opg\Common\Model\Entity\EntityInterface;
use Opg\Common\Model\Entity\HasIdInterface;
use Opg\Common\Model\Entity\HasSystemStatusInterface;
use Opg\Common\Model\Entity\Traits\HasId;
use Opg\Common\Model\Entity\Traits\HasSystemStatus;
use Doctrine\ORM\Mapping as ORM;
use Opg\Common\Model\Entity\Traits\InputFilter;
use Opg\Common\Model\Entity\Traits\ToArray;
use Opg\Core\Model\Entity\Assignable\User as UserEntity;
use Opg\Core\Model\Entity\CaseActor\Person as PersonEntity;
use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\ReadOnly;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\Groups;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterInterface;

/**
 * Class Warning
 * @package Opg\Core\Model\Entity\Warning
 *
 * @ORM\Entity
 * @ORM\Table(name = "warnings")
 * @ORM\ChangeTrackingPolicy("DEFERRED_EXPLICIT")
 *
 * @ORM\entity(repositoryClass="Application\Model\Repository\WarningRepository")
 */
class Warning implements HasSystemStatusInterface, EntityInterface, \IteratorAggregate, HasIdInterface
{
    use HasSystemStatus;
    use ToArray;
    use InputFilter;
    use HasId;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     * @Groups({"api-warning-list"})
     */
    protected $warningType;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @var string
     * @Groups({"api-warning-list"})
     */
    protected $warningText;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @var \DateTime
     * @Accessor(getter="getDateAddedString", setter="setDateAddedString")
     * @Type("string")
     * @ReadOnly
     * @Groups({"api-warning-list"})
     */
    protected $dateAdded;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @var \DateTime
     * @Accessor(getter="getDateClosedString", setter="setDateClosedString")
     * @Type("string")
     * @Groups({"api-warning-list"})
     */
    protected $dateClosed;

    /**
     * @ORM\ManyToOne(targetEntity="Opg\Core\Model\Entity\Assignable\User")
     * @ORM\JoinColumn(name="added_by", referencedColumnName="id")
     * @var UserEntity
     * @Groups({"api-warning-list"})
     */
    protected $addedBy;

    /**
     * @ORM\ManyToOne(targetEntity="Opg\Core\Model\Entity\Assignable\User")
     * @ORM\JoinColumn(name="closed_by", referencedColumnName="id")
     * @var UserEntity
     * @Groups({"api-warning-list"})
     */
    protected $closedBy;

    public function __construct()
    {
        $this->dateAdded = new \DateTime();
    }

    /**
     * @param \Opg\Core\Model\Entity\Assignable\User $addedBy
     *
     * @return Warning
     */
    public function setAddedBy(UserEntity $addedBy)
    {
        $this->addedBy = $addedBy;

        return $this;
    }

    /**
     * @return \Opg\Core\Model\Entity\Assignable\User
     */
    public function getAddedBy()
    {
        return $this->addedBy;
    }

    /**
     * @param \Opg\Core\Model\Entity\Assignable\User $closedBy
     *
     * @return Warning
     */
    public function setClosedBy(UserEntity $closedBy)
    {
        $this->closedBy = $closedBy;

        return $this;
    }

    /**
     * @return \Opg\Core\Model\Entity\Assignable\User
     */
    public function getClosedBy()
    {
        return $this->closedBy;
    }

    /**
     * @param \DateTime $dateAdded
     *
     * @return Warning
     */
    public function setDateAdded(\DateTime $dateAdded)
    {
        $this->dateAdded = $dateAdded;

        return $this;
    }


    /**
     * @param string $dateAdded
     * @return Warning
     */
    public function setDateAddedString($dateAdded)
    {
        if (!empty($dateAdded)) {
            return $this->setDateAdded(DateFormat::createDateTime($dateAdded));
        }

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateAdded()
    {
        return $this->dateAdded;
    }

    /**
     * @return string
     */
    public function getDateAddedString()
    {
        if (!empty($this->dateAdded)) {
            return $this->getDateAdded()->format(DateFormat::getDateFormat());
        }

        return '';
    }

    /**
     * @param \DateTime $dateClosed
     *
     * @return Warning
     */
    public function setDateClosed(\DateTime $dateClosed)
    {
        $this->dateClosed = $dateClosed;

        return $this;
    }

    /**
     * @param $dateClosed
     *
     * @return Warning
     */
    public function setDateClosedString($dateClosed)
    {
        if (!empty($dateClosed)) {
            return $this->setDateClosed(DateFormat::createDateTime($dateClosed));
        }

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateClosed()
    {
        return $this->dateClosed;
    }

    /**
     * @return string
     */
    public function getDateClosedString()
    {
        if (!empty($this->dateClosed)) {
            return $this->getDateClosed()->format(DateFormat::getDateFormat());
        }

        return '';
    }

    /**
     * @param string $warningText
     *
     * @return Warning
     */
    public function setWarningText($warningText)
    {
        $this->warningText = (string)$warningText;

        return $this;
    }

    /**
     * @return string
     */
    public function getWarningText()
    {
        return $this->warningText;
    }

    /**
     * @param string $warningType
     *
     * @return Warning
     */
    public function setWarningType($warningType)
    {
        $this->warningType = (string)$warningType;

        return $this;
    }

    /**
     * @return string
     */
    public function getWarningType()
    {
        return $this->warningType;
    }

    /**
     * @return \Zend\InputFilter\InputFilter|InputFilterInterface
     */
    public function getInputFilter()
    {
        if( !$this->inputFilter) {
            $this->inputFilter = new \Zend\InputFilter\InputFilter();

            $inputFactory = new InputFactory();

            $this->inputFilter->add($inputFactory->createInput(
                    array(
                        'name'       => 'warningType',
                        'required'   => true,
                    )
                )
            );

            $this->inputFilter->add($inputFactory->createInput(
                    array(
                        'name'       => 'warningText',
                        'required'   => true,
                    )
                )
            );
        }

        return $this->inputFilter;
    }

    /**
     * @return \RecursiveArrayIterator|\Traversable
     */
    public function getIterator()
    {
        return new \RecursiveArrayIterator($this->toArray());
    }
}
