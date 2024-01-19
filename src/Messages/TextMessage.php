<?php

namespace Zapply\Laravel\Messages;

class TextMessage extends Message
{
    /**
     * The body of the message.
     *
     * @var string
     */
    public string $body;

    /**
     * Create a new message instance.
     *
     * @param mixed $body
     * @return TextMessage
     */
    public static function create($body): self
    {
        return new static($body);
    }

    /**
     *
     * @param mixed $body
     * @return void
     */
    public function __construct($body)
    {
        $this->body = $body;
    }

    /**
     * Set the body of the message.
     *
     * @param mixed $body
     * @return TextMessage
     */
    public function body($body): self
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get the payload of the message.
     *
     * @return array
     */
    public function payload(): array
    {
        return [
            'recipient_type' => 'individual',
            'type' => 'text',
            'message' => [
                'body' => $this->body
            ]
        ];
    }
}
