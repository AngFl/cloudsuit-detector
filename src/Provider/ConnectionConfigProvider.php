<?php
/**
 *
 */

namespace App\Provider;


interface ConnectionConfigProvider
{
    public function provide() : array ;

    public function supported(string $className) : bool ;
}