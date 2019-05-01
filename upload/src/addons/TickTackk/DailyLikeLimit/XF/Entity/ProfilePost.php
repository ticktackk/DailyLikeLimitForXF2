<?php

namespace TickTackk\DailyLikeLimit\XF\Entity;

use TickTackk\DailyLikeLimit\Entity\ContentTrait;

/**
 * Class ProfilePost
 *
 * @package TickTackk\DailyLikeLimit\XF\Entity
 */
class ProfilePost extends XFCP_ProfilePost
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

        return $visitor->hasPermission('profilePost', 'dailyLikeLimit');
    }
}