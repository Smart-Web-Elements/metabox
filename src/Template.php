<?php

namespace SweMetaBox;

/**
 *
 */
class Template
{
    /**
     * @var array
     */
    protected array $args;

    /**
     * @var string
     */
    protected string $file;

    /**
     * @param string $file
     * @param array $args
     */
    public function __construct(string $file, array $args = []) {
        $this->file = $file;
        $this->args = $args;
    }

    /**
     * @param string $arg
     * @param $value
     * @return void
     */
    public function setArg(string $arg, $value) {
        $this->args[$arg] = $value;
    }

    /**
     * @return string
     */
    public function render(): string {
        ob_start();

        if (locate_template($this->file)) {
            locate_template($this->file, true, false, $this->args);
        }

        return ob_get_clean();
    }

    /**
     * @return void
     */
    public function renderEcho() {
        echo $this->render();
    }
}