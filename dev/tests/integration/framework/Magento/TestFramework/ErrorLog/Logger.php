<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\TestFramework\ErrorLog;

class Logger extends \Magento\Framework\Logger\Monolog
{
    /**
     * @var array
     */
    protected $messages = [];

    /**
     * Minimum error level to log message
     * Possible values: -1 ignore all errors, and level constants form http://tools.ietf.org/html/rfc5424 standard
     *
     * @var int
     */
    protected $minimumErrorLevel;

    public function __construct()
    {
        $this->minimumErrorLevel = defined('TESTS_ERROR_LOG_LISTENER_LEVEL') ? TESTS_ERROR_LOG_LISTENER_LEVEL : -1;
        parent::__construct('integration-test');
    }

    /**
     * @return void
     */
    public function clearMessages()
    {
        $this->messages = [];
    }

    /**
     * @return array
     */
    public function getMessages()
    {
        return $this->messages;
    }

    /**
     * @{inheritDoc}
     *
     * @param  integer $level   The logging level
     * @param  string  $message The log message
     * @param  array   $context The log context
     * @return Boolean Whether the record has been processed
     */
    public function addRecord($level, $message, array $context = array())
    {
        if ($level <= $this->minimumErrorLevel) {
            $this->messages[] = [
                'level' => $this->getLevelName($level),
                'message' => $message,
            ];
        }
        return parent::addRecord($level, $message, $context);
    }
}
