<?php
/**
 * @var MetaKeyCheckbox $metaKey
 */

use SweMetaBox\MetaKeyCheckbox;

?>
<p>
    <label>
        <input type="hidden" name="<?php
        echo $metaKey->getKey(); ?>" value="0"/>
        <input type="checkbox" name="<?php
        echo $metaKey->getKey(); ?>" value="1"<?php
        checked(1, $metaKey->getValue()); ?>>
        <?php
        echo $metaKey->getLabel(); ?>
    </label>
</p>
