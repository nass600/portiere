<?php

namespace Nass600\Builder;

/**
 * Class Vhost
 *
 * @package Nass600\Builder
 * @author Ignacio Velazquez <ivelazquez85@gmail.com>
 */
class Vhost
{
    /**
     * @var string
     */
    protected $filename;

    /**
     * @var string
     */
    protected $serverName;

    /**
     * @var string
     */
    protected $documentRoot;

    /**
     * @var string
     */
    protected $errorLogFilename;

    /**
     * @var string
     */
    protected $accessLogFilename;

    /**
     * @var string
     */
    protected $env;

    /**
     * @param string $filename
     */
    public function __construct($filename)
    {
        $this->filename = $filename;
        $this->errorLogFilename = $this->filename . '.error.log';
        $this->accessLogFilename = $this->filename . '.access.log';
    }

    /**
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * @param string $filename
     *
     * @return Vhost
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;

        return $this;
    }

    /**
     * @return string
     */
    public function getServerName()
    {
        return $this->serverName;
    }

    /**
     * @param string $serverName
     *
     * @return Vhost
     */
    public function setServerName($serverName)
    {
        $this->serverName = $serverName;

        return $this;
    }

    /**
     * @return string
     */
    public function getDocumentRoot()
    {
        return $this->documentRoot;
    }

    /**
     * @param string $documentRoot
     *
     * @return Vhost
     */
    public function setDocumentRoot($documentRoot)
    {
        $this->documentRoot = $documentRoot;

        return $this;
    }

    /**
     * @return string
     */
    public function getErrorLogFilename()
    {
        return $this->errorLogFilename;
    }

    /**
     * @param string $errorLogFilename
     *
     * @return Vhost
     */
    public function setErrorLogFilename($errorLogFilename)
    {
        if (null === $errorLogFilename) {
            return $this;
        }

        $this->errorLogFilename = $errorLogFilename;

        return $this;
    }

    /**
     * @return string
     */
    public function getAccessLogFilename()
    {
        return $this->accessLogFilename;
    }

    /**
     * @param string $accessLogFilename
     *
     * @return Vhost
     */
    public function setAccessLogFilename($accessLogFilename)
    {
        if (null === $accessLogFilename) {
            return $this;
        }

        $this->accessLogFilename = $accessLogFilename;

        return $this;
    }

    /**
     * @return string
     */
    public function getEnv()
    {
        return $this->env;
    }

    /**
     * @param string $env
     *
     * @return Vhost
     */
    public function setEnv($env)
    {
        if (null === $env) {
            return $this;
        }

        $this->env = $env;

        return $this;
    }
}
