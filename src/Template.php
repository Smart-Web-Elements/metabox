<?php

namespace SweMetaBox;

/**
 *
 */
final class Template
{
    /**
     * @var array
     */
    private array $args;

    /**
     * @var string
     */
    private string $file;

    /**
     * @param string $file
     * @param array $args
     */
    public function __construct(string $file, array $args = []) {
        $this->file = $file;
        $this->args = $args;
    }

    /**
     * Add a variable to the template.
     *
     * @param string $arg
     * @param mixed $value
     * @return void
     */
    public function setArg(string $arg, $value): void {
        $this->args[$arg] = $value;
    }

    /**
     * Get the rendered template.
     *
     * @return string
     */
    public function render(): string {
        ob_start();

        if (locate_template($this->file)) {
            locate_template($this->file, true, false, $this->args);
        } elseif (file_exists($this->file)) {
            extract($this->args);
            include $this->file;
        } else {
            apply_filters('smb-render-custom', $this->file, $this->args);
        }

        return ob_get_clean();
    }

    /**
     * Echo the rendered template.
     *
     * @return void
     */
    public function renderEcho(): void {
        echo $this->render();
    }
}