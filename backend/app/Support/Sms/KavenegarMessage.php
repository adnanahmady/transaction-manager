<?php

namespace App\Support\Sms;

class KavenegarMessage implements SmsMessageInterface
{
    /**
     * If receptor is not set, then message wouldn't
     * be sent.
     *
     * @var string|null Message Receptor.
     */
    private string|null $receptor;

    /**
     * @var string Message Content.
     */
    private string $content;

    /**
     * @var string Line Number.
     */
    private string $lineNumber;

    /**
     * Specifies Message Receptor.
     * This field is required.
     *
     * @param string|null $receptor Receptor.
     *
     * @return SmsMessageInterface
     */
    public function receptor(string|null $receptor = null): SmsMessageInterface
    {
        $this->receptor = $receptor;

        return $this;
    }

    /**
     * Returns Message Receptor.
     *
     * @return string
     */
    public function getReceptor(): string
    {
        return $this->receptor;
    }

    /**
     * Specifies The Content of Message.
     * This field is required.
     *
     * @param string $content Content.
     *
     * @return SmsMessageInterface
     */
    public function content(string $content): SmsMessageInterface
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Returns Message Content.
     *
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

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
    public function lineNumber(string $number): SmsMessageInterface
    {
        $this->lineNumber = $number;

        return $this;
    }

    /**
     * Returns Sender Line Number.
     *
     * @return string
     */
    public function getLineNumber(): string
    {
        return $this->lineNumber ?? config('sms.kavenegar.line_number');
    }
}
