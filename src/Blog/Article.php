<?php

namespace Helix\Shopify\Blog;

use Helix\Shopify\Base\AbstractEntity;
use Helix\Shopify\Base\AbstractEntity\CrudTrait;
use Helix\Shopify\Base\AbstractEntity\MetafieldTrait;
use Helix\Shopify\Base\Data;
use Helix\Shopify\Blog;
use Helix\Shopify\Blog\Article\Comment;
use Helix\Shopify\Blog\Article\Image;

/**
 * A blog article.
 *
 * @see https://shopify.dev/docs/admin-api/rest/reference/online-store/article
 *
 * @method string       getAuthor           ()
 * @method string       getBlogId           () injected
 * @method string       getBodyHtml         ()
 * @method string       getCreatedAt        ()
 * @method string       getHandle           ()
 * @method null|Image   getImage            ()
 * @method string       getPublished        ()
 * @method string       getPublishedAt      ()
 * @method string       getSummaryHtml      ()
 * @method string       getTags             ()
 * @method null|string  getTemplateSuffix   ()
 * @method string       getTitle            ()
 * @method string       getUpdatedAt        ()
 * @method string       getUserId           ()
 *
 * @method $this        setAuthor           (string $author)
 * @method $this        setBodyHtml         (string $html)
 * @method $this        setHandle           (string $handle)
 * @method $this        setImage            (?Image $image)
 * @method $this        setPublished        (string $published)
 * @method $this        setPublishedAt      (string $iso8601)
 * @method $this        setSummaryHtml      (string $html)
 * @method $this        setTags             (string $tags)
 * @method $this        setTemplateSuffix   (?string $suffix)
 * @method $this        setTitle            (string $title)
 *
 * @method Comment[]    selectComments      (callable $filter) `fn( Comment $comment ): bool`
 */
class Article extends AbstractEntity
{

    use CrudTrait;
    use MetafieldTrait;

    const TYPE = 'article';
    const DIR = 'articles';

    const MAP = [
        'image' => Data::class
    ];

    protected function _container()
    {
        return $this->getBlog();
    }

    /**
     * @return Blog
     */
    public function getBlog()
    {
        return Blog::load($this, $this->getBlogId());
    }

    /**
     * @return Comment[]
     */
    public function getComments()
    {
        assert($this->hasId());
        return Comment::loadAll($this, 'comments', [
            'blog_id' => $this->getBlogId(),
            'article_id' => $this->getId()
        ]);
    }

    /**
     * @return int
     */
    public function getCommentsCount(): int
    {
        assert($this->hasId());
        return $this->api->get("comments/count", [
            'blog_id' => $this->getBlogId(),
            'article_id' => $this->getId()
        ])['count'];
    }

    /**
     * Factory.
     *
     * @return Comment
     */
    public function newComment()
    {
        assert($this->hasId());
        return $this->api->factory($this, Comment::class, [
            'blog_id' => $this->getBlogId(),
            'article_id' => $this->getId()
        ]);
    }
}