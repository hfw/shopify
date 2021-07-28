<?php

namespace Helix\Shopify\Customer;

use Helix\Shopify\Base\Data;
use Helix\Shopify\Customer;

/**
 * An invitation email for an existing customer.
 *
 * @see https://help.shopify.com/en/api/reference/customers/customer#send_invite-2020-04
 *
 * @method $this    setFrom             (string $from)
 * @method $this    setTo               (string $to)
 * @method $this    setBcc              (string[] $bcc)
 * @method $this    setSubject          (string $subject)
 * @method $this    setCustomMessage    (string $message)
 * @todo checked
 */
class Invite extends Data
{

    /**
     * @var Customer
     */
    protected $customer;

    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
        parent::__construct($customer);
    }

    public function send(): void
    {
        $this->api->post("{$this->customer}/send_invite", [
            'customer_invite' => $this->data
        ]);
    }
}