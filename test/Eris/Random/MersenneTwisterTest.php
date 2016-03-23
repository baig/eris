<?php
namespace Eris\Random;

class MersenneTwisterTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->enableAssertions();
    }

    public function tearDown()
    {
        $this->disableAssertions();
    }

    public static function sequences()
    {
        return [
            [424242, 100],
            [0, 100],
            [0xffffffff, 100],
            [0xfffffffffffffff, 100],
        ];
    }
    
    /**
     * @dataProvider sequences
     */
    public function testGeneratesTheSameSequenceAsThePythonOracle($seed, $sample)
    {
        $seed = 424242;
        $sample = 100;
        $twister = new MersenneTwister($seed);
        $numbers = [];
        for ($i = 0; $i < $sample; $i++) {
            $numbers[$i] = $twister->extractNumber();
        }
        $oracle = "python " . __DIR__ . "/mt.py $seed $sample";
        exec($oracle, $oracleOutput, $returnCode);
        $this->assertEquals(0, $returnCode);
        $this->assertEquals($oracleOutput, $numbers);
    }

    private function enableAssertions()
    {
        assert_options(ASSERT_ACTIVE, 1);
        assert_options(ASSERT_CALLBACK, function($file, $line, $code) {
            throw new \LogicException($code);
        });
    }

    private function disableAssertions()
    {
        assert_options(ASSERT_ACTIVE, 0);
    }
}