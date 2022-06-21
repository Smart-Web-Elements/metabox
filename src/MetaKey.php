<?php

namespace SweMetaBox;

/**
 *
 */
abstract class MetaKey extends Information
{
    /**
     *
     */
    const TYPE_DEFAULT = FILTER_DEFAULT;

    /**
     *
     */
    const TYPE_ARRAY = FILTER_REQUIRE_ARRAY;

    /**
     * @var string
     */
    private string $key;

    /**
     * @var string
     */
    private string $label;

    /**
     * @var int
     */
    private int $type;

    /**
     * @var Template
     */
    private Template $template;

    /**
     * @param string $key
     * @param string $label
     * @param int $type
     * @param Template|null $template
     */
    public function __construct(string $key, string $label, int $type, ?Template $template = null)
    {
        $defaultTemplateName = strtolower(preg_replace('/([a-zA-Z])(?=[A-Z])/', '$1-', static::class));
        $this->key = $key;
        $this->label = $label;
        $this->type = $type;
        $this->template = $template ?? new Template($this->getDefaultPath($defaultTemplateName.'-default.php'));
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }

    /**
     * @return Template
     */
    public function getTemplate(): Template
    {
        return $this->template;
    }

    /**
     * @param Template $template
     * @return void
     */
    public function setTemplate(Template $template)
    {
        $template->setArg('metaKey', $this);
        $this->template = $template;
    }

    /**
     * @param int|null $postId
     * @return mixed
     */
    public function getValue(?int $postId = null)
    {
        if ($postId === null) {
            $postId = get_the_ID();
        }

        return get_post_meta($postId, $this->key, true);
    }

    /**
     * @param int $postId
     * @return void
     */
    public function save(int $postId)
    {
        if ($this->getType() === FILTER_DEFAULT) {
            $value = filter_input(INPUT_POST, $this->getKey());
        } else {
            $value = filter_input(INPUT_POST, $this->getKey(), FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
        }

        update_post_meta($postId, $this->getKey(), $value);
    }
}