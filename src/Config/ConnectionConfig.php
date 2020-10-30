<?php
/**
 *
 */

namespace App\Config;


class ConnectionConfig
{
    private array $settings = [];

    /**
     * ConnectionConfig constructor.
     * @param array $settings
     */
    public function __construct(array $settings)
    {
        $this->settings = $settings;
    }


    public function getConfig() : array
    {
        return $this->settings;
    }
}