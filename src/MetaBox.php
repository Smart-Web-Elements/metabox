<?php

namespace SweMetaBox;

use WP_Post;

/**
 *
 */
class MetaBox extends Information
{
    /**
     * @var string
     */
    private string $id;

    /**
     * @var string
     */
    private string $title;

    /**
     * @var string
     */
    private string $context;

    /**
     * @var Template|null
     */
    private Template $template;

    /**
     * @var MetaKey[]
     */
    private array $metaKeyList;

    /**
     * @var string[]
     */
    private array $postTypeList;

    /**
     * @var string
     */
    private string $nonceName;

    /**
     * @var string
     */
    private string $nonceAction;

    /**
     * @param string $id
     * @param string $title
     * @param string $context
     * @param int $priority
     * @param Template|null $template
     */
    public function __construct(
        string $id,
        string $title,
        string $context = 'advanced',
        int $priority = 10,
        ?Template $template = null
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->context = $context;

        if ($template === null) {
            $template = new Template($this->getPartialsPath('meta-box-default.php'));
        }

        $this->template = $template;
        $this->metaKeyList = [];
        $this->postTypeList = [];
        $this->nonceName = static::class;
        $this->nonceAction = 'save-'.$this->nonceName;

        add_action('add_meta_boxes', [$this, 'add'], $priority, 1);
        add_action('save_post', [$this, 'savePost'], 10, 2);
    }

    /**
     * @return MetaKey[]
     */
    public function getMetaKeyList(): array
    {
        return $this->metaKeyList;
    }

    /**
     * @return string[]
     */
    public function getPostTypeList(): array
    {
        return $this->postTypeList;
    }

    /**
     * @param MetaKey $metaKey
     * @return void
     */
    public function addMetaKey(MetaKey $metaKey)
    {
        $metaKey->getTemplate()->setArg('metaBox', $this);
        $this->metaKeyList[] = $metaKey;
    }

    /**
     * @param string $postType
     * @param int $priority
     * @return void
     */
    public function addPostTypeSupport(string $postType, int $priority = 10)
    {
        $this->postTypeList[] = $postType;

        remove_action('add_meta_boxes', [$this, 'add']);
        add_action('add_meta_boxes_'.$postType, [$this, 'add'], $priority, 1);
    }

    /**
     * @param string|WP_Post $post
     * @return void
     */
    public function add($post)
    {
        $postType = $post instanceof WP_Post ? $post->post_type : $post;
        add_meta_box($this->id, $this->title, [$this, 'render'], $postType, $this->context);
    }

    /**
     * @return void
     */
    public function render()
    {
        wp_nonce_field($this->nonceAction, $this->nonceName);
        $this->template->setArg('metaKeyList', $this->getMetaKeyList());
        $this->template->renderEcho();
    }

    /**
     * @param int $postId
     * @param WP_Post $post
     * @return void
     */
    public function savePost(int $postId, WP_Post $post)
    {
        $postType = get_post_type_object($post->post_type);
        $currentUserCanEditPostType = current_user_can($postType->cap->edit_post, $postId);

        if (wp_is_post_autosave($postId) || wp_is_post_revision($postId) || !$currentUserCanEditPostType) {
            return;
        }

        $nonce = filter_input(INPUT_POST, $this->nonceName);

        if ($nonce === null) {
            $nonce = filter_input(INPUT_GET, $this->nonceName);
        }

        if (!wp_verify_nonce($nonce, $this->nonceAction)) {
            return;
        }

        foreach ($this->metaKeyList as $metaKey) {
            $metaKey->save($postId);
        }
    }

    /**
     * @param string $metaKey
     * @param int|null $postId
     * @return mixed
     */
    public function getPostMeta(string $metaKey, ?int $postId = null)
    {
        if ($postId === null) {
            $postId = get_the_ID();
        }

        return get_post_meta($postId, $metaKey, true);
    }

    /**
     * @param int|null $postId
     * @return array
     */
    public function getPostMetas(?int $postId = null): array
    {
        $postMetas = [];

        foreach ($this->metaKeyList as $meatKey => $type) {
            $postMetas[$meatKey] = $this->getPostMeta($meatKey, $postId);
        }

        return $postMetas;
    }
}