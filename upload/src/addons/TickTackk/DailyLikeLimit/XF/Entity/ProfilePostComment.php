<?php

namespace TickTackk\DailyLikeLimit\XF\Entity;

use TickTackk\DailyLikeLimit\Entity\ContentTrait;

/**
 * Class ProfilePostComment
 *
 * @package TickTackk\DailyLikeLimit\XF\Entity
 */
class ProfilePostComment extends XFCP_ProfilePostComment
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

        return $visitor->hasPermission('profilePost', 'dailyCommentLikeLimit');
    }
}