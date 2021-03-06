<?php
namespace Opg\Core\Model\Entity\CaseActor;

use Opg\Core\Model\Entity\CaseActor\Decorators\RelationshipToDonor;
use Opg\Core\Model\Entity\CaseActor\Interfaces\HasRelationshipToDonor;
use Opg\Core\Model\Entity\CaseActor\Person as BasePerson;
use Opg\Core\Model\Entity\CaseActor\Decorators\Company;
use Opg\Common\Model\Entity\Traits\ToArray;

use Doctrine\ORM\Mapping as ORM;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterInterface;
use Zend\Validator\Callback;
use JMS\Serializer\Annotation\Type;

/**
 * @ORM\Entity
 *
 * @package Opg Domain Model
 */
class Correspondent extends BasePerson implements HasRelationshipToDonor
{
    use Company;
    use ToArray;
    use RelationshipToDonor;

    /**
     * @return InputFilterInterface
     * @codeCoverageIgnore
     */
    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = parent::getInputFilter();

            $factory = new InputFactory();

            $inputFilter->add(
                $factory->createInput(
                    array(
                        'name'       => 'cases',
                        'required'   => true,
                        'validators' => array(
                            array(
                                'name'    => 'Callback',
                                'options' => array(
                                    'messages' => array(
                                        //@Todo figure out why the default is_empty message is displaying
                                        Callback::INVALID_VALUE    => 'This person needs an attached case',
                                        Callback::INVALID_CALLBACK => "An error occurred in the validation"
                                    ),
                                    'callback' => function () {
                                            return $this->hasAttachedCase();
                                        }
                                )
                            )
                        )
                    )
                )
            );

            $this->inputFilter->merge($inputFilter);
        }

        return $this->inputFilter;
    }
}
