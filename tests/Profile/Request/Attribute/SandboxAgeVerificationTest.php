<?php

declare(strict_types=1);

namespace Yoti\Sandbox\Test\Profile\Request\Attribute;

use Yoti\Profile\UserProfile;
use Yoti\Sandbox\Profile\Request\Attribute\SandboxAgeVerification;
use Yoti\Sandbox\Test\TestCase;

/**
 * @coversDefaultClass \Yoti\Sandbox\Profile\Request\Attribute\SandboxAgeVerification
 */
class SandboxAgeVerificationTest extends TestCase
{
    private const SOME_TIMESTAMP = 1171502725;
    private const SOME_TIMESTAMP_DATE_STRING = '2007-02-15';
    private const SOME_DERIVATION = 'age_under:18';

    /**
     * @var SandboxAgeVerification
     */
    private $ageVerification;

    public function setup(): void
    {
        $this->ageVerification = new SandboxAgeVerification(
            (new \DateTime())->setTimestamp(self::SOME_TIMESTAMP),
            self::SOME_DERIVATION
        );
    }

    /**
     * @covers ::jsonSerialize
     * @covers ::__construct
     */
    public function testJsonSerialize()
    {
        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'name' => UserProfile::ATTR_DATE_OF_BIRTH,
                'value' => self::SOME_TIMESTAMP_DATE_STRING,
                'derivation' => self::SOME_DERIVATION,
                'optional' => true,
                'anchors' => [],
            ]),
            json_encode($this->ageVerification)
        );
    }

    /**
     * @covers ::setAgeOver
     * @covers ::__construct
     */
    public function testGetAgeOver()
    {
        $this->ageVerification->setAgeOver(20);

        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'name' => UserProfile::ATTR_DATE_OF_BIRTH,
                'value' => self::SOME_TIMESTAMP_DATE_STRING,
                'derivation' => 'age_over:20',
                'optional' => true,
                'anchors' => [],
            ]),
            json_encode($this->ageVerification)
        );
    }

    /**
     * @covers ::setAgeUnder
     * @covers ::__construct
     */
    public function testAgeUnder()
    {
        $this->ageVerification->setAgeUnder(30);

        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'name' => UserProfile::ATTR_DATE_OF_BIRTH,
                'value' => self::SOME_TIMESTAMP_DATE_STRING,
                'derivation' => 'age_under:30',
                'optional' => true,
                'anchors' => [],
            ]),
            json_encode($this->ageVerification)
        );
    }
}