<?php

namespace TickTackk\DailyLikeLimit\XF\Repository;

use XF\Entity\User as UserEntity;

/**
 * Class LikedContent
 *
 * @package TickTackk\DailyLikeLimit
 */
class LikedContent extends XFCP_LikedContent
{
    /**
     * @param UserEntity|null $user
     *
     * @return \XF\Mvc\Entity\Finder
     */
    public function findLikesByUserToday(UserEntity $user = null)
    {
        if (!$user)
        {
            $user = \XF::visitor();
        }

        return $this->findLikesByLikeUserId($user)
            ->where('like_date', '>=', strtotime('midnight', \XF::$time));
    }

    /**
     * @param string          $contentType
     * @param int             $contentId
     * @param UserEntity|null $user
     *
     * @return \XF\Mvc\Entity\Finder
     */
    public function findLikesByUserTodayForContent($contentType, $contentId, UserEntity $user = null)
    {
        return $this->findLikesByUserToday($user)
            ->where('content_type', $contentType)
            ->where('content_id', $contentId);
    }
}