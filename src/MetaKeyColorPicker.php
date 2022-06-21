<?php

namespace SweMetaBox;

/**
 *
 */
class MetaKeyColorPicker extends MetaKey
{
    /**
     * @param string $key
     * @param string $label
     * @param int $type
     * @param Template|null $template
     */
    public function __construct(string $key, string $label, int $type = self::TYPE_DEFAULT, ?Template $template = null)
    {
        add_action('admin_enqueue_scripts', [$this, 'adminEnqueueScripts']);
        parent::__construct($key, $label, $type, $template);
    }

    /**
     * @return void
     */
    public function adminEnqueueScripts()
    {
        wp_enqueue_style('wp-color-picker');
        wp_enqueue_script('wp-color-picker');
    }
}