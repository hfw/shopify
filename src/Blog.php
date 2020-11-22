<?php

namespace Helix\Shopify;

use Helix\Shopify\Base\AbstractEntity;
use Helix\Shopify\Base\AbstractEntity\CrudTrait;
use Helix\Shopify\Base\AbstractEntity\MetafieldTrait;
use Helix\Shopify\Blog\Article;

/**
 * A blog.
 *
 * @see https://shopify.dev/docs/admin-api/rest/reference/online-store/blog
 *
 * @method string   getCommentable          ()
 * @method string   getCreatedAt            ()
 * @method mixed    getFeedburner           ()
 * @method string   getFeedburnerLocation   ()
 * @method string   getHandle               ()
 * @method string   getTags                 ()
 * @method string   getTitle                ()
 * @method string   getUpdatedAt            ()
 *
 * @method $this    setCommentable          (string $mode)
 * @method $this    setHandle               (string $handle)
 * @method $this    setTags                 (string $csv)
 * @method $this    setTitle                (string $title)
 */
class Blog extends AbstractEntity {

    use CrudTrait;
    use MetafieldTrait;

    const TYPE = 'blog';
    const DIR = 'blogs';

    const COMMENTS_CLOSED = 'no';
    const COMMENTS_MODERATED = 'moderate';
    const COMMENTS_OPEN = 'yes';

    /**
     * Factory.
     *
     * @return Article
     */
    public function newArticle () {
        assert($this->hasId());
        return $this->api->factory($this, Article::class, [
            'blog_id' => $this->getId()
        ]);
    }
}