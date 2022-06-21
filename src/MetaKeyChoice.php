<?php

namespace SweMetaBox;

/**
 *
 */
class MetaKeyChoice extends MetaKey
{
    /**
     * @var array
     */
    private array $choices;

    /**
     * @param string $key
     * @param string $label
     * @param int $type
     * @param Template|null $template
     */
    public function __construct(string $key, string $label, int $type = self::TYPE_DEFAULT, ?Template $template = null)
    {
        $this->choices = [];
        parent::__construct($key, $label, $type, $template);
    }

    /**
     * @return array
     */
    public function getChoices(): array
    {
        return $this->choices;
    }

    /**
     * @param $value
     * @param string $label
     * @return void
     */
    public function addChoice($value, string $label)
    {
        $this->choices[] = [
            'value' => $value,
            'label' => $label,
        ];
    }
}