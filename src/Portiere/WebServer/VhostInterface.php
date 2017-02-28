<?php

namespace Portiere\WebServer;

/**
 * Interface VhostInterface
 *
 * @package Portiere\WebServer
 * @author Ignacio Velazquez <ivelazquez85@gmail.com>
 */
interface VhostInterface
{
    /**
     * Gets the filename
     *
     * @return string
     */
    public function getFilename();

    /**
     * Gets the error log filename
     *
     * @return string
     */
    public function getErrorLogFilename();

    /**
     * Gets the access log filename
     *
     * @return string
     */
    public function getAccessLogFilename();
}
