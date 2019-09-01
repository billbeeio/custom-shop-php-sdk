<?php
/**
 * This file is part of the Billbee Custom Shop API package.
 *
 * Copyright 2019 by Billbee GmbH
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 *
 * Created by Julian Finkler <julian@mintware.de>
 */

namespace Billbee\CustomShopApi\Repository;

use Billbee\CustomShopApi\Exception\NotImplementedException;
use Billbee\CustomShopApi\Model\ShippingProfile;

interface ShippingProfileRepositoryInterface extends RepositoryInterface
{
    /**
     * Return all available shipping profiles
     *
     * @return ShippingProfile[] The shipping profiles
     *
     * @throws NotImplementedException If the method is not implemented
     */
    public function getShippingProfiles();
}
