<?php
/**
 * @var MetaKeyTaxonomy $metaKey
 */

use SweMetaBox\MetaKeyTaxonomy;
use SweMetaBox\Template;

?>

<div class="taxonomydiv">

    <p class="post-attributes-label-wrapper">
        <label class="post-attributes-label"><?php
            echo $metaKey->getLabel(); ?></label>
    </p>
    <?php

    $args = array(
        'orderby' => 'name',
        'order' => 'ASC',
        'hide_empty' => false,
        'fields' => 'all',
        'parent' => 0,
        'hierarchical' => true,
        'child_of' => 0,
        'pad_counts' => false,
        'cache_domain' => 'core'
    );

    $termList = get_terms($metaKey->getTaxonomies(), $args);

    $metaValues = $metaKey->getValue();

    if (empty($metaValues)) {
        $metaValues = [];
    }

    ?>

    <input type="hidden" name="<?php
    echo $metaKey->getKey(); ?>[]" value="0">
    <ul class="categorychecklist" data-wp-lists="list:category">

        <?php
        foreach ($termList as $term) : ?>

            <?php
            $listItem = new Template('partials/meta-key-term-default.php', [
                'term' => $term,
                'metaKey' => $metaKey,
            ]); ?>

            <?php
            echo $listItem->render(); ?>

        <?php
        endforeach; ?>
    </ul>

</div>