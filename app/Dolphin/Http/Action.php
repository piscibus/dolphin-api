<?php


namespace App\Dolphin\Http;

/**
 * Interface Action
 * @package App\Dolphin\Http
 */
interface Action
{
    /**
     * Executes the requested action
     *
     * @return mixed
     */
    public function execute();
}
