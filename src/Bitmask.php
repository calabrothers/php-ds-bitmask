<?php
/*-----------------------------------------------------------------------------
*	File:			Bitmask.php
*   Author:         Vincenzo Calabro' <vincenzo@calabrothers.com>
*   Copyright:      Calabrothers Corporation
-----------------------------------------------------------------------------*/

namespace Ds;

class Bitmask {

    protected $nValue;

    public static function create(int $nValue) {
        return new Bitmask($nValue);
    }

    public static function intRepresentationSize() : int {
        return PHP_INT_SIZE; 
    }

    public static function numberOfBits() : int {
        return (self::intRepresentationSize()) * 8; 
    }

    private static function validateInputBit(int $nBit) {
        $nMachine   = self::numberOfBits()-1;
        $bValid     = $nBit >= 0 && $nBit<=$nMachine;
        if (!$bValid) {
            throw new \UnexpectedValueException(
                "Invalid bit has been specified $nBit not in [0,$nMachine]."
            );
        }
    }

    private static function getInput($oValue) : Bitmask {
        if (is_object($oValue)) {
            $oClass = new \ReflectionClass(Bitmask::class);
            $oObj   = new \ReflectionObject($oValue);
            $szoObjClass = $oObj->getName();                
            if ($oClass->isInstance($oValue)    || 
                $oClass->isSubclassOf($szoObjClass)) {
                $oValue = $oValue->nValue;
            } else {
                throw new \UnexpectedValueException(
                    "Bitmask requires an object of Bitmask type to perform copy."
                );
            }
        } elseif (!is_integer($oValue)) {
            throw new \UnexpectedValueException(
                "Bitmask requires a valid input"
            );
        }
        return new Bitmask($oValue);
    }
    
    // Object methods
    public function __construct($oValue = 0) {
        if (is_object($oValue)) {
            $oClass = new \ReflectionClass(Bitmask::class);
            $oObj   = new \ReflectionObject($oValue);
            $szoObjClass = $oObj->getName();                
            if ($oClass->isInstance($oValue)    || 
                $oClass->isSubclassOf($szoObjClass)) {
                $oValue = $oValue->nValue;
            } else {
                throw new \UnexpectedValueException(
                    "Bitmask requires an object of Bitmask type to perform copy."
                );
            }
        } elseif (!is_integer($oValue)) {
            throw new \UnexpectedValueException(
                "Bitmask requires a valid input"
            );
        }
        // Getting data into the object
        $this->nValue = $oValue;
    }

    public function __toString() : string {
        $szHeader = 'Bitmask(';
        $szBinary = '';
        $nMachine     = self::numberOfBits();
        $szFormat = '%0'.$nMachine.'b';
        $szBinary .= sprintf($szFormat, $this->nValue);
        $nRepresent = strlen($szBinary);
        // Compressing and formatting
        $szBinary   = preg_replace('/^([0]+)([^0].*$)/', '${2}', $szBinary);
        $nBits      = strlen($szBinary);
        $nAlignment = (8-($nBits % 8));
        $szBinary   = str_repeat('0', $nAlignment) . $szBinary;
        $nZeros     = $nRepresent - $nBits;
        $szHeader  .= $nRepresent."|".$nZeros."|".$nBits.") [ ";
        $szFooter   = " ]";
        $szBinary   = trim(chunk_split($szBinary, 4, ' '));
        return trim($szHeader.$szBinary.$szFooter);
    }

    public function setValue($oValue) : self {
        $oValue = self::getInput($oValue);
        $this->nValue = $oValue->nValue;
        return $this;
    }

    public function setBit(int $nBit) : self {
        self::validateInputBit($nBit);
        return $this->setMask(1 << $nBit);
    }

    public function checkBit(int $nBit) : bool {
        self::validateInputBit($nBit);
        $oMask = new Bitmask(1 << $nBit);
        return $this->checkMask($oMask);
    }

    public function clearBit(int $nBit) : self {
        self::validateInputBit($nBit);
        return $this->clearMask(1 << $nBit);
    }

    public function setMask($oValue) : self {
        $oValue = self::getInput($oValue);
        $this->nValue = $this->nValue | $oValue->nValue;
        return $this;
    }

    public function clearMask($oValue) : self {
        $oValue = self::getInput($oValue);
        $this->nValue = $this->nValue & (~$oValue->nValue);
        return $this;
    }

    public function getValue() : int {
        return $this->nValue;
    }

    public function and($oValue) : Bitmask {
        $oValue = self::getInput($oValue);
        return new Bitmask($this->nValue & $oValue->nValue);
    }

    public function or($oValue) : Bitmask {
        $oValue = self::getInput($oValue);
        return new Bitmask($this->nValue | $oValue->nValue);
    }

    public function not() : Bitmask {
        return new Bitmask(~($this->nValue));
    }

    public function checkMask($oValue) : bool {
        $oValue = self::getInput($oValue);
        $oAnd = $this->and($oValue);
        return ($oAnd->nValue > 0);
    }

}


?>