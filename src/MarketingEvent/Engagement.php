<?php

namespace Helix\Shopify\MarketingEvent;

use Helix\Shopify\Base\Data;
use Helix\Shopify\MarketingEvent;

/**
 * A {@link MarketingEvent} engagement.
 *
 * Engagements can only be sent to Shopify, they can't be retrieved through the API.
 *
 * @see https://shopify.dev/docs/admin-api/rest/reference/marketingevent
 *
 * @method $this    setAdSpend          (string $spend)
 * @method $this    setClicksCount      (int $count)
 * @method $this    setCommentsCount    (int $count)
 * @method $this    setFavoritesCount   (int $count)
 * @method $this    setImpressionsCount (int $count)
 * @method $this    setIsCumulative     (bool $cumulative)
 * @method $this    setOccurredOn       (string $date)
 * @method $this    setSharesCount      (int $count)
 * @method $this    setViewsCount       (int $count)
 */
class Engagement extends Data
{

}