<?php

namespace Helix\Shopify\Blog\Article;

use Helix\Shopify\Base\AbstractEntity;
use Helix\Shopify\Base\AbstractEntity\CrudTrait;
use Helix\Shopify\Blog;
use Helix\Shopify\Blog\Article;

/**
 * A blog article comment.
 *
 * @see https://shopify.dev/docs/admin-api/rest/reference/online-store/comment
 *
 * @method string   getArticleId    () injected
 * @method string   getAuthor       ()
 * @method string   getBlogId       () injected
 * @method string   getBody         ()
 * @method string   getBodyHtml     ()
 * @method string   getCreatedAt    ()
 * @method string   getEmail        ()
 * @method string   getIp           ()
 * @method string   getPublishedAt  ()
 * @method string   getStatus       ()
 * @method string   getUpdatedAt    ()
 * @method string   getUserAgent    ()
 *
 * @method $this    setAuthor       (string $author)
 * @method $this    setBody         (string $body)
 * @method $this    setBodyHtml     (string $html)
 * @method $this    setEmail        (string $email)
 * @method $this    setIp           (string $ip)
 */
class Comment extends AbstractEntity
{

    use CrudTrait;

    const TYPE = 'comment';
    const DIR = 'comments';

    protected function _container()
    {
        return $this->getArticle();
    }

    protected function _dir(): string
    {
        return 'comments';
    }

    /**
     * @return Article
     */
    public function getArticle()
    {
        return Article::load($this, $this->getArticleId());
    }

    /**
     * @return Blog
     */
    public function getBlog()
    {
        return Blog::load($this, $this->getBlogId());
    }
}