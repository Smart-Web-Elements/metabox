<?php

namespace SweMetaBox;

/**
 *
 */
class MetaKeyTextArea extends MetaKey
{
    /**
     * @param string $key
     * @param string $label
     * @param int $type
     * @param Template|null $template
     */
    public function __construct(string $key, string $label, int $type = self::TYPE_DEFAULT, ?Template $template = null)
    {
        parent::__construct($key, $label, $type, $template);
    }
}