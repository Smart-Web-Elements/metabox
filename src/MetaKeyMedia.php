<?php

namespace SweMetaBox;

/**
 *
 */
class MetaKeyMedia extends MetaKey
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

    /**
     * @param string $key
     * @param int|null $postId
     * @param string $size
     * @param string $attr
     * @return void
     */
    public static function thePostMedia(string $key, ?int $postId = null, string $size = 'thumbnail', string $attr = '')
    {
        echo self::getThePostMedia($key, $postId, $size, $attr);
    }

    /**
     * @param string $key
     * @param int|null $postId
     * @param string $size
     * @param string $attr
     * @return string
     */
    public static function getThePostMedia(
        string $key,
        ?int $postId = null,
        string $size = 'thumbnail',
        string $attr = ''
    ): string {
        return wp_get_attachment_image(self::getPostMediaId($key, $postId), $size, false, $attr);
    }

    /**
     * @param string $key
     * @param int|null $postId
     * @return mixed
     */
    public static function getPostMediaId(string $key, ?int $postId = null)
    {
        if ($postId === null) {
            $postId = get_the_ID();
        }

        return get_post_meta($postId, $key, true);
    }
}