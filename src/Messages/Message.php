<?php

namespace Zapply\Laravel\Messages;

abstract class Message
{
    abstract public function payload(): array;
}
