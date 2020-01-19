<?php
/*-----------------------------------------------------------------------------
*	File:			BitmaskTest.php
*   Author:         Vincenzo Calabro' <vincenzo@calabrothers.com>
*   Copyright:      Calabrothers Corporation
-----------------------------------------------------------------------------*/

namespace Tests;

use PHPUnit\Framework\TestCase;
use Ds\Bitmask;

final class BitmaskTest extends TestCase
{
    public function testReadmeFunctionality(): void
    {  
        $oX = new Bitmask(3);       // 000...0011
        $oY = Bitmask::create(5);   // 000...0101

        // echo $oX."\n";
        // echo $oY."\n";
        // echo $oX->and($oY)."\n";
        // echo $oX->or($oY)."\n";

        // echo $oX->clearBit(0)."\n";
        // echo $oX->setBit(4)."\n";
        
        // echo $oX->checkBit(2) ? "true":"false";
        // echo $oX->checkBit(4) ? "true":"false";

        $this->assertTrue(true);

    }

    public function testLimitsFunctionality(): void
    {        
        $oX = new Bitmask(2);   // 010

        switch (Bitmask::numberOfBits()) {
            case 32: {
                // Ok Case
                $oX->setBit(31);
                $this->assertTrue(true);

                // Invalid argument
                try {
                    $oX->setBit(32);
                    $this->assertTrue(false);
                } catch(\Exception $e) {
                    $this->assertTrue(true);
                }

            break;
            }
            case 64: {
                // Ok Case
                $oX->setBit(63);
                $this->assertTrue(true);

                // Invalid argument
                try {
                    $oX->setBit(64);
                    $this->assertTrue(false);
                } catch(\Exception $e) {
                    $this->assertTrue(true);
                }

            break;
            }
        }
    }

    public function testBasicFunctionality(): void
    {        
        $oX = new Bitmask(2);   // 010
        $this->assertEquals(2, $oX->getValue());
        $this->assertFalse($oX->checkBit(0));
        $this->assertTrue( $oX->checkBit(1));
        $this->assertFalse($oX->checkBit(2));
        
        // Not
        $oY = $oX->not();
        $this->assertTrue( $oY->checkBit(0));
        $this->assertFalse($oY->checkBit(1));
        $this->assertTrue( $oY->checkBit(2));

        // Or
        $oX = new Bitmask(2);   // 010
        $oY = new Bitmask(5);   // 101
        $oZ = $oX->or($oY);     // 111
        $this->assertTrue($oZ->checkBit(0));
        $this->assertTrue($oZ->checkBit(1));
        $this->assertTrue($oZ->checkBit(2));

        // And
        $oX = new Bitmask(3);   // 011
        $oY = new Bitmask(6);   // 110
        $oZ = $oX->and($oY);    // 010
        $this->assertFalse($oZ->checkBit(0));
        $this->assertTrue( $oZ->checkBit(1));
        $this->assertFalse($oZ->checkBit(2));

        // Chear bit
        $oZ = new Bitmask(5);   // 101
        $oZ->clearBit(0);       // 100
        $this->assertFalse($oZ->checkBit(0));
        $this->assertFalse($oZ->checkBit(1));
        $this->assertTrue( $oZ->checkBit(2));

        // Set bit
        $oZ->setBit(1);         // 100
        $this->assertFalse($oZ->checkBit(0));
        $this->assertTrue( $oZ->checkBit(1));
        $this->assertTrue( $oZ->checkBit(2));
        
        // Set value
        $oZ->setValue(5);       // 101
        $this->assertTrue( $oZ->checkBit(0));
        $this->assertFalse($oZ->checkBit(1));
        $this->assertTrue( $oZ->checkBit(2));

        // Copy constructor
        $oX = new Bitmask($oZ); // 101
        $this->assertTrue( $oX == $oZ);

        // String function
        $szExp = 'Bitmask(64|61|3) [ 0000 0101 ]';
        $this->assertEquals($oX , $szExp);

        // Testing set mask (accepts negative numbers but for a reason)
        $nMask = ~$oX->getValue();          // 010
        $this->assertTrue($nMask < 0);
        $oX->setMask($nMask);               // 111
        $this->assertTrue($oX->checkBit(0));
        $this->assertTrue($oX->checkBit(1));
        $this->assertTrue($oX->checkBit(2));
    }

    public function testInvalidUsage(): void
    {        
        // Invalid argument
        try {
            $oX = new Bitmask('a');
            $this->assertTrue(false);
        } catch(\Exception $e) {
            $this->assertTrue(true);
        }

        // Invalid argument: object is allowed only for copy
        try {
            $oX = new Bitmask(new \Exception('object'));
            $this->assertTrue(false);
        } catch(\Exception $e) {
            $this->assertTrue(true);
        }  
        
        // Invalid argument: set negative bit?
        try {
            $oX = new Bitmask(0);
            $this->assertTrue(true);
            $oX->setBit(-1);
            $this->assertTrue(false);            
        } catch(\Exception $e) {
            $this->assertTrue(true);
        }  

        // Invalid argument: set negative bit?
        try {
            $oX = new Bitmask(0);
            $this->assertTrue(true);
            $oX->setMask(new \Exception('what?'));
            $this->assertTrue(false);            
        } catch(\Exception $e) {
            $this->assertTrue(true);
        }  

        // Invalid argument: set negative bit?
        try {
            $oX = new Bitmask(0);
            $this->assertTrue(true);
            $oX->setMask('what?');
            $this->assertTrue(false);            
        } catch(\Exception $e) {
            $this->assertTrue(true);
        }  
    
    }
}