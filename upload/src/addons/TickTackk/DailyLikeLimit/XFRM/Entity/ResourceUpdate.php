<?php

namespace TickTackk\DailyLikeLimit\XFRM\Entity;

use TickTackk\DailyLikeLimit\Entity\ContentTrait;

/**
 * Class ResourceUpdate
 *
 * @package TickTackk\DailyLikeLimit\XFRM\Entity
 */
class ResourceUpdate extends XFCP_ResourceUpdate
{
    use ContentTrait;

    /**
     * @return bool
     */
    protected function getDailyLikeLimit()
    {
        $visitor = \XF::visitor();
        if (!$visitor->user_id)
        {
            return false;
        }

        $resource = $this->Resource;
        if (!$resource)
        {
            return false;
        }

        return $resource->hasPermission('dailyLikeLimit');
    }
}