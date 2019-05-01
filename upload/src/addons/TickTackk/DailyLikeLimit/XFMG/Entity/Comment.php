<?php

namespace TickTackk\DailyLikeLimit\XFMG\Entity;

use TickTackk\DailyLikeLimit\Entity\ContentTrait;

/**
 * Class Comment
 *
 * @package TickTackk\DailyLikeLimit\XFMG\Entity
 */
class Comment extends XFCP_Comment
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

        $content = $this->Content;
        if (!$content)
        {
            return false;
        }

        return $content->hasPermission('dailyCommentLikeLimit');
    }
}