<?php

namespace SweMetaBox;

use WP_Taxonomy;

/**
 *
 */
class MetaKeyTaxonomy extends MetaKey
{
    /**
     * @var WP_Taxonomy[]
     */
    private array $taxonomies;

    /**
     * @param string $key
     * @param string $label
     * @param int $type
     * @param Template|null $template
     */
    public function __construct(string $key, string $label, int $type = self::TYPE_DEFAULT, ?Template $template = null)
    {
        $this->taxonomies = [];
        parent::__construct($key, $label, $type, $template);
    }

    /**
     * @param WP_Taxonomy $taxonomy
     * @return void
     */
    public function addTaxonomy(WP_Taxonomy $taxonomy)
    {
        $this->taxonomies[] = $taxonomy;
    }

    /**
     * @return WP_Taxonomy[]
     */
    public function getTaxonomies(): array
    {
        return $this->taxonomies;
    }

    /**
     * @param int|null $postId
     * @return array|mixed
     */
    public function getValue(?int $postId = null)
    {
        $value = parent::getValue($postId);
        return empty($value) ? [] : $value;
    }
}