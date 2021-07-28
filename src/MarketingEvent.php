<?php

namespace Helix\Shopify;

use Helix\Shopify\Base\AbstractEntity;
use Helix\Shopify\Base\AbstractEntity\CrudTrait;
use Helix\Shopify\MarketingEvent\Engagement;
use Helix\Shopify\MarketingEvent\Resource;

/**
 * A marketing event.
 *
 * @see https://shopify.dev/docs/admin-api/rest/reference/marketingevent
 *
 * @method number       getBudget               ()
 * @method string       getBudgetType           () see the budget constants
 * @method string       getCurrency             ()
 * @method string       getDescription          ()
 * @method string       getEndedAt              ()
 * @method string       getEventType            () see the type constants.
 * @method string       getManageUrl            ()
 * @method Resource[]   getMarketedResources    ()
 * @method string       getMarketingChannel     () see the channel constants.
 * @method bool         isPaid                  ()
 * @method string       getPreviewUrl           ()
 * @method string       getReferringDomain      ()
 * @method string       getRemoteId             ()
 * @method string       getScheduledToEndAt     ()
 * @method string       getStartedAt            ()
 * @method string       getUtmCampaign          ()
 * @method string       getUtmMedium            ()
 * @method string       getUtmSource            ()
 *
 * @method $this        setBudget               (number $budget)
 * @method $this        setBudgetType           (string $type) see the budget constants
 * @method $this        setCurrency             (string $currency)
 * @method $this        setDescription          (string $text)
 * @method $this        setEndedAt              (string $iso8601)
 * @method $this        setEventType            (string $type) @depends required, see the type constants.
 * @method $this        setManageUrl            (string $url)
 * @method $this        setMarketedResources    (Resource[] $resources)
 * @method $this        setMarketingChannel     (string $channel) @depends required, see the channel constants.
 * @method $this        setPaid                 (bool $paid) @depends required
 * @method $this        setPreviewUrl           (string $url)
 * @method $this        setReferringDomain      (string $domain)
 * @method $this        setRemoteId             (string $id)
 * @method $this        setScheduledToEndAt     (string $iso8601)
 * @method $this        setStartedAt            (string $iso8601) @depends required
 * @method $this        setUtmCampaign          (string $campaign)
 * @method $this        setUtmMedium            (string $medium)
 * @method $this        setUtmSource            (string $source)
 */
class MarketingEvent extends AbstractEntity
{

    use CrudTrait;

    const TYPE = 'marketing_event';
    const DIR = 'marketing_events';

    const MAP = [
        'marketed_resources' => [Resource::class]
    ];

    const BUDGET_DAILY = 'daily';
    const BUDGET_LIFETIME = 'lifetime';

    const CHANNEL_DISPLAY = 'display';
    const CHANNEL_EMAIL = 'email';
    const CHANNEL_REFERRAL = 'referral';
    const CHANNEL_SEARCH = 'search';
    const CHANNEL_SOCIAL = 'social';

    const TYPE_ABANDONED_CART = 'abandoned_cart';
    const TYPE_AD = 'ad';
    const TYPE_AFFILIATE = 'affiliate';
    const TYPE_LOYALTY = 'loyalty';
    const TYPE_MESSAGE = 'message';
    const TYPE_NEWSLETTER = 'newsletter';
    const TYPE_POST = 'post';
    const TYPE_RETARGETING = 'retargeting';
    const TYPE_TRANSACTIONAL = 'transactional';

    /**
     * Factory.
     *
     * @return mixed
     */
    public function newEngagement()
    {
        return $this->api->factory($this, Engagement::class);
    }

    /**
     * Factory.
     *
     * @return Resource
     */
    public function newResource()
    {
        return $this->api->factory($this, Resource::class);
    }

    /**
     * @param Engagement[] $engagements
     * @return $this
     */
    public function sendEngagements(array $engagements)
    {
        $this->api->post("{$this}/engagements", [
            'engagements' => $engagements
        ]);
        return $this;
    }
}