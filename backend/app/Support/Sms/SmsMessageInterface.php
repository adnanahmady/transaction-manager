<?php

namespace App\Support\Sms;

interface SmsMessageInterface
{
    /**
     * Specifies Message Receptor.
     * This field is required.
     *
     * @param string $receptor Receptor.
     *
     * @return SmsMessageInterface
     */
    public function receptor(string $receptor): SmsMessageInterface;

    /**
     * Returns Message Receptor.
     *
     * @return string
     */
    public function getReceptor(): string;

    /**
     * Specifies The Content of Message.
     * This field is required.
     *
     * @param string $content Content.
     *
     * @return SmsMessageInterface
     */
    public function content(string $content): SmsMessageInterface;

    /**
     * Returns Message Content.
     *
     * @return string
     */
    public function getContent(): string;

    /**
     * Specifies Sender Line Number.
     * if its not specified then default
     * line number will be chosen for sending
     * message.
     *
     * @param string $number Number.
     *
     * @return SmsMessageInterface
     */
    public function lineNumber(string $number): SmsMessageInterface;

    /**
     * Returns Sender Line Number.
     *
     * @return string
     */
    public function getLineNumber(): string;
}
