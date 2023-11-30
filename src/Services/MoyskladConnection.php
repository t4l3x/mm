<?php

namespace App\Services;

use MoySklad\MoySklad;

class MoyskladConnection
{
    private $moysklad;

    /**
     * MoyskladConnection constructor.
     *
     * @param string $login
     * @param string $password
     *
     * @throws \Exception If there is an issue creating MoySklad instance.
     */
    public function __construct(string $login, string $password)
    {
        try {
            $this->moysklad = MoySklad::getInstance($login, $password);
        } catch (\Exception $e) {
            // Handle the exception, log, or rethrow if necessary
            throw new \Exception('Failed to create MoySklad instance: ' . $e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * Get the MoySklad instance.
     *
     * @return MoySklad
     */
    public function getMoySkladInstance(): MoySklad
    {
        return $this->moysklad;
    }
}