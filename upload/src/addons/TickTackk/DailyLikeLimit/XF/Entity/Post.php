<?php

namespace TickTackk\DailyLikeLimit\XF\Entity;

use TickTackk\DailyLikeLimit\Entity\ContentTrait;

/**
 * Class Post
 *
 * @package TickTackk\DailyLikeLimit\XF\Entity
 */
class Post extends XFCP_Post
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

        $thread = $this->Thread;
        if (!$thread)
        {
            return false;
        }

        return $visitor->hasNodePermission($thread, 'dailyLikeLimit');
    }
}