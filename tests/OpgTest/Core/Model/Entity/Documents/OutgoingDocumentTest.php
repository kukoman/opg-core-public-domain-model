<?php
namespace OpgTest\Core\Model\Entity\Documents;

use Opg\Core\Model\Entity\CaseItem\Lpa\Lpa;
use Opg\Core\Model\Entity\CaseActor\Donor;
use Opg\Core\Model\Entity\Documents\Document;
use PHPUnit_Framework_TestCase;
use Opg\Core\Model\Entity\Documents\OutgoingDocument;
use Opg\Common\Model\Entity\DateFormat as OPGDateFormat;

class OutgoingDocumentTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var OutgoingDocument
     */
    private $correspondence;

    private $data = array(
        'id'            => '123',
        'type'          => null,
        'filename'      => null,
        'case'          => null,
        'person'        => null,
        'errorMessages' => array(),
        'recipientName' => null,
        'address'       => null,
        'systemType'    => null,
    );

    public function setUp()
    {
        $this->correspondence = new OutgoingDocument();
    }

    public function testGetIterator()
    {
        $this->assertInstanceOf('RecursiveArrayIterator', $this->correspondence->getIterator());
    }

    /**
     * Kept it simple as validation rules should go to its own class
     */
    public function testGetInputFilter()
    {
        $inputFilter = $this->correspondence->getInputFilter();

        $this->assertInstanceOf('Zend\InputFilter\InputFilter', $inputFilter);
    }

    public function testSetGetId()
    {
        $this->correspondence->setId($this->data['id']);

        $this->assertEquals($this->data['id'], $this->correspondence->getId());
    }

    public function testSetGetFileName()
    {
        $filename = 'TestFile';
        $this->correspondence->setFilename($filename);
        $this->assertEquals($filename, $this->correspondence->getFilename());
    }

    public function testSetGetCase()
    {
        $case = new Lpa();
        $this->correspondence->setCase($case);
        $this->assertInstanceOf('Opg\Core\Model\Entity\CaseItem\Lpa\Lpa', $this->correspondence->getCase());
    }

    public function testSetGetPerson()
    {
        $donor = new Donor();
        $this->correspondence->setPerson($donor);
        $this->assertInstanceOf('Opg\Core\Model\Entity\CaseActor\Donor', $this->correspondence->getPerson());
    }

    public function testSetGetDocumentStoreFilename()
    {
        $this->correspondence->setId('10');
        $this->correspondence->setFilename('document');
        $expectedOutput = '10_document';
        $this->assertEquals($expectedOutput, $this->correspondence->getDocumentStoreFilename());
    }

    public function testGetSetRecipientName()
    {
        $expected = 'Test Recipient';

        $this->correspondence->setRecipientName($expected);
        $this->assertEquals($expected, $this->correspondence->getRecipientName());
    }

    public function testGetSetAddress()
    {
        $expected = 'Test Address, Some Town, Postcode';

        $this->correspondence->setAddress($expected);
        $this->assertEquals($expected, $this->correspondence->getAddress());
    }

    public function testGetSetSystemType()
    {
        $expected = 'LP-3A';

        $this->assertEmpty($this->correspondence->getSystemType());
        $this->assertTrue($this->correspondence->setSystemType($expected) instanceof Document);
        $this->assertEquals($expected, $this->correspondence->getSystemType());
    }

    public function testGetSetCreatedDateNulls()
    {
        $expectedDate = new \DateTime();
        $this->assertNotEmpty($this->correspondence->getCreatedDate());
        $this->correspondence->setCreatedDate();
        $this->assertEquals(
            $expectedDate->format(OPGDateFormat::getDateTimeFormat()),
            $this->correspondence->getCreatedDate()->format(OPGDateFormat::getDateTimeFormat())
        );
    }

    public function testGetSetCreatedDateString()
    {
        $expected = date(OPGDateFormat::getDateTimeFormat());
        $this->correspondence->setCreatedDateString($expected);
        $this->assertEquals($expected, $this->correspondence->getCreatedDateString());
    }


    public function testGetSetCreatedDateEmptyString()
    {
        $expectedDate = new \DateTime();
        $this->correspondence->setCreatedDateString(null);
        $returnedDate = $this->correspondence->getCreatedDate();

        $this->assertEquals(
            $expectedDate->format(OPGDateFormat::getDateTimeFormat()),
            $returnedDate->format(OPGDateFormat::getDateTimeFormat())
        );
    }

    public function testGetSetType()
    {
        $expected = 'Client Notification';

        $this->correspondence->setType($expected);

        $this->assertEquals($expected, $this->correspondence->getType());
    }
}
