<?php

namespace Helix\Shopify\Api;

use RuntimeException;

/**
 * A cURL or Shopify error.
 *
 * Errors with codes below 400 are cURL errors.
 *
 * The API class returns `null` for `404`; it's never thrown.
 */
class ShopifyError extends RuntimeException {

    /**
     * Messages for codes with garbage response bodies.
     *
     * @see https://help.shopify.com/en/api/getting-started/response-status-codes
     */
    const NO_DATA = [
        400 => 'Bad Request',
        401 => 'Unauthorized',
        403 => 'Forbidden',
        423 => 'Locked',
        406 => 'Not Acceptable',
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout'
    ];

    /**
     * @var array
     */
    protected $curlInfo = [];

    /**
     * @param int $code
     * @param string $message
     * @param array $curlInfo
     */
    public function __construct (int $code, string $message, array $curlInfo) {
        parent::__construct(self::NO_DATA[$code] ?? $message, $code);
        $this->curlInfo = $curlInfo;
    }

    /**
     * @return array
     */
    public function getCurlInfo (): array {
        return $this->curlInfo;
    }

    /**
     * @return bool
     */
    final public function isCurl (): bool {
        return $this->code < 400;
    }
}