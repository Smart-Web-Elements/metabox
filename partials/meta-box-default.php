<?php
/**
 * @var MetaKey[] $metaKeyList
 */

use SweMetaBox\MetaKey;

foreach ($metaKeyList as $metaKey) {
    $metaKey->getTemplate()->renderEcho();
}