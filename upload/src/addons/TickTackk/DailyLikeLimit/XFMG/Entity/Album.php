<?php

namespace TickTackk\DailyLikeLimit\XFMG\Entity;

use TickTackk\DailyLikeLimit\Entity\ContentTrait;

/**
 * Class Album
 *
 * @package TickTackk\DailyLikeLimit\XFMG\Entity
 */
class Album extends XFCP_Album
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

        return $this->hasPermission('dailyAlbumLikeLimit');
    }
}