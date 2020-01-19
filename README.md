<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

# PHP Bitmask Support


[![Build Status](https://travis-ci.org/calabrothers/php-ds-bitmask.svg?branch=master)](https://travis-ci.org/calabrothers/php-ds-bitmask.svg?branch=master) [![Coverage Status](https://coveralls.io/repos/github/calabrothers/php-ds-bitmask/badge.svg?branch=master)](https://coveralls.io/github/calabrothers/php-ds-bitmask?branch=master) [![Total Downloads](https://poser.pugx.org/calabrothers/php-ds-bitmask/downloads)](https://packagist.org/packages/calabrothers/php-ds-bitmask) [![License](https://poser.pugx.org/calabrothers/php-ds-bitmask/license)](https://packagist.org/packages/calabrothers/php-ds-bitmask) -->

A class to support bitmask operations.
## Install
    composer require calabrothers/php-ds-bitmask

## Test
    composer install
    composer test

## HowTo
Building an object is done via constructor or factory function:
    
    $X = new Bitmask(3);       // 000...0011
    $Y = Bitmask::create(5);   // 000...0101

### Available functions:
Let us consider the classic three logical operators:
<div class="container">
<table class="table">
<thead>
<tr>
<th>Operator</th>
<th>Notation</th>
</tr>
</thead>
<tbody>

<tr><td>
 
AND(a,b)

</td><td>
    
![AND](https://latex.codecogs.com/gif.latex?a%20%5Cwedge%20b)
<!-- $$ a \wedge b --> 

</td></tr>

<tr><td>
 
OR(a,b)

</td><td>
    
![OR](https://latex.codecogs.com/gif.latex?a%20%5Cvee%20b)
<!-- $$  a \vee b $$ -->

</td></tr>

<tr><td>

NOT(a)

</td><td>
    
![NOT](https://latex.codecogs.com/gif.latex?%5Cbar%20a)
<!-- $$  \bar{a} $$ -->

</td></tr>

</tbody>
</table>
</div>

Then the basic **Bitmask** object will provide the following operators:

<div class="container">
<table class="table">
<thead>
<tr>
<th>PHP Command</th>
<th>Bitwise Operation</th>
</tr>
</thead>
<tbody>

<tr><td>
 
    $x->setValue($v)

</td><td>
    
![SetValue](https://latex.codecogs.com/gif.latex?x%20%3D%20v)
<!-- $$ x = v$$ -->
</td></tr>

<tr><td>
 
    $x->setBit($b)

</td><td>
    
![SetBit](https://latex.codecogs.com/gif.latex?x%20%3D%20x%20%5Cvee%202%5Eb)
<!-- $$ x = x \vee 2^b $$ -->

</td></tr>

<tr><td>
 
    $x->clearBit($b)

</td><td>
    
![ClearBit](https://latex.codecogs.com/gif.latex?x%20%3D%20x%20%5Cwedge%20%5Cbar%7B2%5Eb%7D)
<!--$$ x = x \wedge \bar{2^b} $$ -->

</td></tr>

<tr><td>
 
    $x->checkBit($b)

</td><td>

![CheckBit](https://latex.codecogs.com/gif.latex?%28x%20%5Cwedge%202%5Eb%29%20%3E%200)
<!-- $$ (x \wedge 2^b) > 0 $$ -->

</td></tr>

<tr><td>
 
    $x->setMask($m)

</td><td>

![SetMask](https://latex.codecogs.com/gif.latex?x%20%3D%20x%20%5Cvee%20m)
<!-- $$ x = x \vee m $$ -->

</td></tr>

<tr><td>
 
    $x->clearMask($m)

</td><td>

![ClearMask](https://latex.codecogs.com/gif.latex?x%20%3D%20x%20%5Cwedge%20%5Cbar%7Bm%7D)
<!-- $$ x = x \wedge \bar{m} $$ -->

</td></tr>

<tr><td>
 
    $x->checkMask($m)

</td><td>

![CheckMask](https://latex.codecogs.com/gif.latex?%28x%20%5Cwedge%20m%29%20%3E%200)

<!-- $$ (x \wedge m) > 0 $$ -->

</td></tr>

<tr><td>
 
    $x->not()

</td><td>
    
![NotFcn](https://latex.codecogs.com/gif.latex?y%20%3D%20%5Cbar%7Bx%7D)
<!-- $$ y = \bar{x} $$ -->

</td></tr>

<tr><td>
 
    $x->or($y)

</td><td>

![OrFcn](https://latex.codecogs.com/gif.latex?z%20%3D%20x%20%5Cvee%20y)
<!-- $$ z = x \vee y $$ -->

</td></tr>

<tr><td>
 
    $x->and($y)

</td><td>
    
![AndFcn](https://latex.codecogs.com/gif.latex?z%20%3D%20x%20%5Cwedge%20y)
<!-- $$ z = x \wedge y $$ -->

</td></tr>

</tbody>
</table>
</div>


## Example

    $X = new Bitmask(3);  
    echo $X;                                // Bitmask(64|62|2) [ 0000 0011 ]

    $Y = Bitmask::create(5);    
    echo $Y;                                // Bitmask(64|61|3) [ 0000 0101 ]

    // Return new object
    echo $X->and($Y);                       // Bitmask(64|61|3) [ 0000 0101 ]       
    echo $X->and($Y);                       // Bitmask(64|61|3) [ 0000 0111 ]

    // Alter the object
    echo $X->clearBit(0);                   // Bitmask(64|62|2) [ 0000 0010 ]
    echo $X->setBit(4);                     // Bitmask(64|59|5) [ 0001 0010 ]

    // Check bit (convention starts from 0)
    echo $X->checkBit(2) ? "true":"false";  // false
    echo $X->checkBit(4) ? "true":"false";  // true


### Credits
- [Vincenzo Calabrò](www.cybertronics.cloud/vc)

### Support quality code
[![Foo](https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif)](https://paypal.me/muawijhe)

### License

The MIT License (MIT). Please see [LICENSE](LICENSE.md) for more information.
