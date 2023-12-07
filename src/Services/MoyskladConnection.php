<?php

namespace App\Services;


use Evgeek\Moysklad\Formatters\ArrayFormat;
use Evgeek\Moysklad\Http\GuzzleSenderFactory;
use Evgeek\Moysklad\MoySklad;

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
            $this->moysklad = new MoySklad(
                credentials: [$login, $password],
                formatter: new ArrayFormat(),
                requestSenderFactory: new GuzzleSenderFactory(
                    retries: 3,
                    exceptionTruncateAt: 4000
                )
            );
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