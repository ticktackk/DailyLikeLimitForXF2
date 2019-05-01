<?php

namespace TickTackk\DailyLikeLimit\XFMG\Entity;

use TickTackk\DailyLikeLimit\Entity\ContentTrait;

/**
 * Class MediaItem
 *
 * @package TickTackk\DailyLikeLimit\XFMG\Entity
 */
class MediaItem extends XFCP_MediaItem
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

        return $this->hasPermission('dailyMediaLikeLimit');
    }
}