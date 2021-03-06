<?php

namespace Opg\Core\Model\Entity\CaseActor;

use Doctrine\Common\Collections\ArrayCollection;
use Opg\Common\Model\Entity\Traits\ToArray;
use Opg\Core\Model\Entity\CaseItem\CaseItem;
use Opg\Core\Model\Entity\CaseItem\CaseItemInterface;
use Opg\Core\Model\Entity\CaseActor\Person as BasePerson;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\ReadOnly;
use JMS\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;
use Opg\Core\Model\Entity\LegalEntity\LegalEntity;

/**
 * @ORM\Entity
 * Class NoneCaseContact
 * @package Opg\Core\Model\Entity\CaseActor
 */
class NonCaseContact extends BasePerson
{
    use ToArray;

    /**
     * @var ArrayCollection
     * @ReadOnly
     * @Exclude
     */
    protected $cases = null;

    /**
     * @ORM\Column(type = "string", nullable = true)
     * @var string
     * @Groups({"api-case-list","api-task-list","api-person-get"})
     */
    protected $fullname = null;

    /**
     * @param ArrayCollection $cases
     * @return PartyInterface|void
     * @throws \LogicException
     */
    public function setCases(ArrayCollection $cases)
    {
        return $this;
    }

    /**
     * @param CaseItem $case
     * @return BasePerson|void
     * @throws \LogicException
     */
    public function addCase(CaseItem $case)
    {
        return $this;
    }

    /**
     *
     * @return string $fullname
     */
    public function getFullname()
    {
        if(empty($this->fullname) && (!empty($this->surname)||!empty($this->firstname)||!empty($this->middlenames))) {
            $this->fullname = implode(' ', array($this->firstname, $this->middlenames, $this->surname));
        }

        return $this->fullname;
    }

    /**
     *
     * @param  string $fullname
     *
     * @return LegalEntity
     */
    public function setFullname($fullname)
    {
        $this->fullname = $fullname;

        if($fullname != null) {
            $names = explode(' ', $fullname);

            $no_of_words_in_fullname = sizeof($names);
            if($no_of_words_in_fullname > 1) {
                $this->firstname = $names[0];
                $this->surname = $names[$no_of_words_in_fullname-1];

                if($no_of_words_in_fullname > 2) {
                    array_shift($names);
                    array_pop($names);
                    $this->middlenames = implode(' ', $names);
                }
            }
            else {
                $this->surname = $names[0];
            }
        }

        return $this;
    }
}
