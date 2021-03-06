<?php
namespace Opg\Core\Model\Entity;

use Opg\Common\Model\Entity\EntityInterface;
use Opg\Common\Model\Entity\HasIdInterface;
use Opg\Common\Model\Entity\Traits\HasId;
use Opg\Common\Model\Entity\Traits\InputFilter;
use Opg\Common\Model\Entity\Traits\ToArray;
use Opg\Core\Model\Entity\Assignable\User;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\Type;
use Opg\Common\Model\Entity\DateFormat as OPGDateFormat;

/**
 * @ORM\Entity
 * @ORM\Table(name = "events")
 * @ORM\ChangeTrackingPolicy("DEFERRED_EXPLICIT")
 * @ORM\entity(repositoryClass="Application\Model\Repository\EventRepository")
 *
 * @package Opg Core
 *
 */
class Event implements EntityInterface, HasIdInterface
{
    use ToArray;
    use InputFilter;
    use HasId;

    /**
     * @ORM\Column(type = "string", options = {"unsigned": true})
     * @var int $sourceId
     */
    protected $sourceEntityId;

    /**
     * @ORM\Column(type = "string")
     * @var string $sourceTable
     */
    protected $sourceEntityClass;

    /**
     * @ORM\ManyToOne(targetEntity = "Opg\Core\Model\Entity\Assignable\User", fetch="EAGER")
     * @var User $user
     */
    protected $user;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var \DateTime
     * @Type("string")
     * @Accessor(getter="getCreatedOnString",setter="setCreatedOnString")
     */
    protected $createdOn;

    /**
     * Read/Insert/Update/Delete (CRUD)
     *
     * @ORM\Column(type = "string")
     * @var string $type
     */
    protected $type;

    /**
     * @ORM\Column(type = "integer", options = {"unsigned": true}, nullable = true)
     */
    protected $owningEntityId;

    /**
     * @ORM\Column(type = "string", nullable = true)
     */
    protected $owningEntityClass;

    /**
     * @ORM\Column(type = "json_array", nullable = true)
     */
    protected $changeset;

    /**
     * @ORM\Column(type= "json_array", nullable = true)
     * @var string $name
     */
    protected $entity;

    /**
     * @ORM\Column(type= "json_array", nullable = true)
     * @var array $userDetails
     */
    protected $userDetails;

    public function __construct($owningEntityId = null, $owningEntityClass = null, array $changeset = null)
    {
        $this->owningEntityId    = $owningEntityId;
        $this->owningEntityClass = $owningEntityClass;
        $this->changeset         = $changeset;
    }

    public function getOwningEntityId()
    {
        return $this->owningEntityId;
    }

    public function getOwningEntityClass()
    {
        return $this->owningEntityClass;
    }

    /**
     * @param \DateTime $createdOn
     * @return Event
     */
    public function setCreatedOn(\DateTime $createdOn = null)
    {
        $this->createdOn = $createdOn;

        return $this;
    }

    /**
     * @param string $createdOn
     *
     * @return Event
     */
    public function setCreatedOnString($createdOn)
    {
        if (!empty($createdOn)) {
            $result = OPGDateFormat::createDateTime($createdOn);
            return $this->setCreatedOn($result);
        }

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedOn()
    {
        return $this->createdOn;
    }

    /**
     * @return string
     */
    public function getCreatedOnString()
    {
        if (!empty($this->createdOn)) {
            return $this->createdOn->format(OPGDateFormat::getDateTimeFormat());
        }

        return '';
    }

    /**
     * @throws \LogicException
     * @return array
     */
    public function getChangeset()
    {
        if (empty($this->changeset)) {
            throw new \LogicException('This event has no changeset.');
        }

        return $this->changeset;
    }

    public function hasChangeset()
    {
        return !empty($this->changeset);
    }

    /**
     * @param int $sourceId
     *
     * @return Event
     */
    public function setSourceEntityId($sourceId)
    {
        $this->sourceEntityId = (int)$sourceId;

        return $this;
    }

    /**
     * @return int
     */
    public function getSourceEntityId()
    {
        return $this->sourceEntityId;
    }

    /**
     * @param string $sourceTable
     *
     * @return Event
     */
    public function setSourceTable($sourceTable)
    {
        $this->sourceTable = (string)$sourceTable;

        return $this;
    }

    /**
     * @return string
     */
    public function getSourceTable()
    {
        return $this->sourceTable;
    }

    /**
     * @return string
     */
    public function getSourceEntityClass()
    {
        return $this->sourceEntityClass;
    }

    /**
     * @param string $type
     *
     * @return Event
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
     * @param User $user
     *
     * @return Event
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return \Opg\Core\Model\Entity\Assignable\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @throws \Exception
     * @return InputFilter
     */
    public function getInputFilter()
    {
        throw new \Exception('Not used yet');
    }

    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * @return array
     */
    public function getUserDetails()
    {
        return $this->userDetails;
    }

    /**
     * @param array $userDetails
     * @return User
     */
    public function setUserDetails(array $userDetails)
    {
        $this->userDetails = $userDetails;

        return $this;
    }
}
