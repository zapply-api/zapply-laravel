<?php

namespace Zapply\Laravel\Messages;

class DocumentMessage extends Message
{
    /**
     * The caption of the message.
     *
     * @var string
     */
    public string $caption;

    /**
     * The url of the document.
     *
     * @var string
     */
    public string $url;

    /**
     * Create a new message instance.
     *
     * @param mixed $caption
     * @return DocumentMessage
     */
    public static function create(string $url, ?string $caption): self
    {
        return new static($url, $caption);
    }

    /**
     *
     * @param mixed $caption
     * @return void
     */
    public function __construct(string $url, string $caption)
    {
        $this->url = $url;
        $this->caption = $caption;
    }

    /**
     * Set the caption of the message.
     *
     * @param mixed $caption
     * @return DocumentMessage
     */
    public function caption($caption): self
    {
        $this->caption = $caption;

        return $this;
    }

    /**
     * Set the url of the document.
     *
     * @param mixed $url
     * @return DocumentMessage
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
                'caption' => $this->caption,
                'sendMediaAsDocument' => true
            ]
        ];
    }
}
