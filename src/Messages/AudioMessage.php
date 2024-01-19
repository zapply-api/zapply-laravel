<?php

namespace Zapply\Laravel\Messages;

class AudioMessage extends Message
{
    /**
     * The url of the message.
     *
     * @var string
     */
    public string $url;

    /**
     * Create a new message instance.
     *
     * @param mixed $url
     * @return AudioMessage
     */
    public static function create($url): self
    {
        return new static($url);
    }

    /**
     *
     * @param mixed $url
     * @return void
     */
    public function __construct($url)
    {
        $this->url = $url;
    }

    /**
     * Set the url of the message.
     *
     * @param mixed $url
     * @return AudioMessage
     */
    public function url($url): self
    {
        $this->url = $url;

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
            'type' => 'media',
            'message' => [
                'url' => $this->url,
                'sendAudioAsVoice' => true
            ]
        ];
    }
}
