<?php

namespace Opg\Core\Model\Entity\Document;

use Opg\Common\Model\Entity\DateFormat as OPGDateFormat;
use Opg\Common\Model\Entity\HasDateTimeAccessor;
use Opg\Common\Model\Entity\HasIdInterface;
use Opg\Common\Model\Entity\Traits\DateTimeAccessor;
use Opg\Common\Model\Entity\Traits\HasId;
use Opg\Core\Model\Entity\Assignable\AssignableComposite;
use Doctrine\ORM\Mapping as ORM;
use Opg\Common\Model\Entity\EntityInterface;
use Opg\Common\Model\Entity\Traits\InputFilter;
use Opg\Common\Model\Entity\Traits\ToArray;
use Opg\Core\Model\Entity\CaseActor\Person;
use Opg\Core\Model\Entity\CaseItem\CaseItem;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\ReadOnly;
use JMS\Serializer\Annotation\GenericAccessor;

/**
 * @ORM\Entity(repositoryClass="Application\Model\Repository\DocumentRepository")
 * @ORM\Table(name = "documents")
 * @ORM\ChangeTrackingPolicy("DEFERRED_EXPLICIT")
 *
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="correspondence_type", type="string")
 * @ORM\DiscriminatorMap({
 *     "incoming_document" = "Opg\Core\Model\Entity\Document\IncomingDocument",
 *     "outgoing_document" = "Opg\Core\Model\Entity\Document\OutgoingDocument",
 * })
 *
 * Class Document
 * @package Opg\Core\Model\Entity\Document
 */
abstract class Document implements EntityInterface, \IteratorAggregate, HasDateTimeAccessor, HasIdInterface
{
    use ToArray;
    use InputFilter;
    use DateTimeAccessor;
    use HasId;

    const DOCUMENT_INCOMING_CORRESPONDENCE = 0;

    const DOCUMENT_OUTGOING_CORRESPONDENCE = 1;

    const DIRECTION_INCOMING = 'Incoming';

    const DIRECTION_OUTGOING = 'Outgoing';


    /**
     * @ORM\ManyToOne(
     *      targetEntity = "Opg\Core\Model\Entity\Assignable\AssignableComposite",
     *      fetch = "EAGER",
     *      cascade={"persist"}
     * )
     * @var AssignableComposite
     */
    protected $assignee;

    /**
     * @ORM\Column(type = "string", nullable = true)
     * @var string
     */
    protected $type;

    /**
     * @ORM\Column(type="string", nullable = true)
     * @var string
     */
    protected $friendlyDescription;

    /**
     * @ORM\Column(type = "string", nullable = true)
     * @var string
     */
    protected $title;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var \DateTime
     * @Type("string")
     * @ReadOnly
     * @GenericAccessor(getter="getDateAsString", setter="setDateFromString", propertyName="paymentDate")
     */
    protected $createdDate;

    /**
     * @ORM\Column(type="integer", nullable=true, options={"default"=0})
     * @var int
     * @Accessor(getter="getDirection")
     */
    protected $direction = self::DOCUMENT_INCOMING_CORRESPONDENCE;

    /**
     * @ORM\Column(type = "text", nullable = true)
     * @var string
     */
    protected $filename;

    /**
     * Don't persist this
     * @var CaseItem $case
     * @Type("Opg\Core\Model\Entity\CaseItem\CaseItem")
     */
    protected $case;


    /**
     * @ORM\OneToOne(targetEntity="Opg\Core\Model\Entity\CaseActor\Person")
     * @ORM\JoinColumn(name="correspondent_id", referencedColumnName="id")
     * @var Person
     * @Type("Opg\Core\Model\Entity\CaseActor\Person")
     */
    protected $correspondent;

    /**
     * Fulfil IteratorAggregate interface requirements
     *
     * @return \RecursiveArrayIterator|\Traversable
     */
    public function getIterator()
    {
        return new \RecursiveArrayIterator($this->toArray());
    }

    /**
     * @param string $title
     *
     * @return BaseCorrespondence
     */
    public function setTitle($title)
    {
        $this->title = (string)$title;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $type
     *
     * @return BaseCorrespondence
     */
    public function setType($type)
    {
        $this->type = (string)$type;

        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param \DateTime $createdDate
     * @return BaseCorrespondence
     */
    public function setCreatedDate(\DateTime $createdDate = null)
    {
        if (null === $createdDate) {
            $this->createdDate = new \DateTime();
        } else {
            $this->createdDate = $createdDate;
        }

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedDate()
    {
        return $this->createdDate;
    }

    /**
     * @param $direction
     * @return BaseCorrespondence
     */
    public function setDirection($direction)
    {
        if (0 === strcasecmp($direction, self::DIRECTION_INCOMING)) {
            $this->direction = self::DOCUMENT_INCOMING_CORRESPONDENCE;
        } else {
            $this->direction = self::DOCUMENT_OUTGOING_CORRESPONDENCE;
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getDirection()
    {
        return ($this->direction === self::DOCUMENT_INCOMING_CORRESPONDENCE)
            ? self::DIRECTION_INCOMING : self::DIRECTION_OUTGOING;
    }

    /**
     * @param Person $correspondent
     * @return BaseCorrespondence
     * @throws \LogicException
     */
    public function setCorrespondent(Person $correspondent = null)
    {
        if ($correspondent !== null && null !== $this->correspondent) {
            throw new \LogicException('The correspondent is already set for the document');
        }
        $this->correspondent = $correspondent;

        return $this;
    }

    /**
     * @return \Opg\Core\Model\Entity\CaseActor\Person
     */
    public function getCorrespondent()
    {
        return $this->correspondent;
    }

    /**
     * @param AssignableComposite $assignee
     * @return BaseCorrespondence
     */
    public function setAssignee(AssignableComposite $assignee = null)
    {
        $this->assignee = $assignee;

        return $this;
    }

    /**
     * @return AssignableComposite
     */
    public function getAssignee()
    {
        return $this->assignee;
    }

    /**
     * @return string $filename
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * @param string $filename
     *
     * @return BaseCorrespondence
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;

        return $this;
    }

    /**
     * @return string
     */
    public function getDocumentStoreFilename()
    {
        return $this->getId() . "_" . $this->getFilename();
    }

    /**
     * @param \Opg\Core\Model\Entity\CaseItem\CaseItem $case
     *
     * @return BaseCorrespondence
     */
    public function setCase($case)
    {
        $this->case = $case;

        return $this;
    }

    /**
     * @return \Opg\Core\Model\Entity\CaseItem\CaseItem
     */
    public function getCase()
    {
        return $this->case;
    }

    /**
     * @param string $friendlyDescription
     * @return BaseCorrespondence
     */
    public function setFriendlyDescription($friendlyDescription)
    {
        $this->friendlyDescription = (string)$friendlyDescription;

        return $this;
    }

    /**
     * @return string
     */
    public function getFriendlyDescription()
    {
        return $this->friendlyDescription;
    }

}
