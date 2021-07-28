<?php

namespace Helix\Shopify\Customer;

use Helix\Shopify\Base\AbstractEntity;
use Helix\Shopify\Base\AbstractEntity\CrudTrait;
use Helix\Shopify\Customer;

/**
 * A saved search for customers.
 *
 * @see https://shopify.dev/docs/admin-api/rest/reference/customers/customersavedsearch
 *
 * @method string   getCreatedAt    ()
 * @method string   getName         ()
 * @method string   getQuery        ()
 * @method string   getUpdatedAt    ()
 *
 * @method $this    setName         (string $name)
 * @method $this    setQuery        (string $query)
 * @todo checked
 */
class SavedSearch extends AbstractEntity
{

    use CrudTrait;

    const TYPE = 'customer_saved_search';
    const DIR = 'customer_saved_searches';

    /**
     * @param array $query
     * @return Customer[]
     */
    public function getCustomers(array $query)
    {
        unset($query['fields']);
        return Customer::loadAll($this, "{$this}/customers", $query);
    }
}