<?php
namespace Opg\Core\Model\Entity\CaseItem\Lpa\Party;

use Opg\Common\Model\Entity\Traits\ExchangeArray;
use Opg\Common\Model\Entity\Traits\ToArray;
use Opg\Core\Model\Entity\CaseItem\Lpa\Traits\RelationshipToDonor;
use Opg\Core\Model\Entity\Person\Person as BasePerson;
use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\Factory as InputFactory;
use Zend\Validator\Callback;
use JMS\Serializer\Annotation\Type;

/**
 * @ORM\Entity
 *
 * @package Opg Domain Model
 *
 */
class CertificateProvider extends BasePerson implements PartyInterface, HasRelationshipToDonor
{
    use ToArray {
        toArray as toTraitArray;
    }
    use ExchangeArray;
    use RelationshipToDonor;

    /**
     * @ORM\Column(type = "string")
     * @var string
     */
    protected $certificateProviderStatementType;

    /**
     * @ORM\Column(type = "string")
     * @var string
     */
    protected $statement;

    /**
     * @return string $certificateProviderStatementType
     */
    public function getCertificateProviderStatementType()
    {
        return $this->certificateProviderStatementType;
    }

    /**
     * @param string $certificateProviderStatementType
     * @return CertificateProvider
     */
    public function setCertificateProviderStatementType(
        $certificateProviderStatementType
    ) {
        $this->certificateProviderStatementType = $certificateProviderStatementType;
        return $this;
    }

    /**
     * @return string $statement
     */
    public function getStatement()
    {
        return $this->statement;
    }

    /**
     * @param string $statement
     * @return CertificateProvider
     */
    public function setStatement($statement)
    {
        $this->statement = $statement;
        return $this;
    }

    /**
     * @param bool $exposeClassName
     *
     * @return array
     */
    public function toArray($exposeClassName = TRUE)
    {
        return $this->toTraitArray($exposeClassName);
    }

    /**
     * @return void|InputFilterInterface
     */
    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = parent::getInputFilter();

            $factory = new InputFactory();

            $inputFilter->add(
                $factory->createInput(
                    array(
                        'name'       => 'powerOfAttorneys',
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

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }
}
