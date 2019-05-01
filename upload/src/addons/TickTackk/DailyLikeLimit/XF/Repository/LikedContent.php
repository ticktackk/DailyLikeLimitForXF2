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
     * @param string          $contentType
     * @param int             $contentId
     * @param UserEntity|null $user
     *
     * @return \XF\Mvc\Entity\Finder
     */
    public function findLikesByUserForContent($contentType, $contentId, UserEntity $user = null)
    {
        if (!$user)
        {
            $user = \XF::visitor();
        }

        return $this->finder('XF:LikedContent')
            ->where('content_type', $contentType)
            ->where('content_id', $contentId)
            ->where('like_user_id', $user->user_id)
            ->where('like_date', '>=', strtotime('midnight', \XF::$time))
            ->setDefaultOrder('like_date', 'DESC');
    }
}