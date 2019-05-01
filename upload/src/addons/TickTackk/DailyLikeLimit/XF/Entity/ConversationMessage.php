<?php

namespace TickTackk\DailyLikeLimit\XF\Entity;

use TickTackk\DailyLikeLimit\Entity\ContentTrait;

/**
 * Class ConversationMessage
 *
 * @package TickTackk\DailyLikeLimit\XF\Entity
 */
class ConversationMessage extends XFCP_ConversationMessage
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

        return $visitor->hasPermission('conversation', 'dailyLikeLimit');
    }
}