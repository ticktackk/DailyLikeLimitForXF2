<?php

namespace TickTackk\DailyLikeLimit\Entity;

use TickTackk\DailyLikeLimit\XF\Repository\LikedContent as ExtendedLikedContentRepo;
use XF\Entity\User as UserEntity;

/**
 * Trait ContentTrait
 *
 * @package TickTackk\DailyLikeLimit\Entity
 */
trait ContentTrait
{
    /**
     * @return int
     */
    abstract protected function getDailyLikeLimit();

    /**
     * @param null $error
     *
     * @return bool
     */
    public function canLike(&$error = null)
    {
        $canLike = parent::canLike($error);

        if ($canLike)
        {
            $canLike = $this->hasReachedLikeLimit();
        }

        return $canLike;
    }

    /**
     * @param UserEntity|null $user
     *
     * @return bool
     */
    public function hasReachedLikeLimit(UserEntity $user = null)
    {
        if (!$user)
        {
            $user = \XF::visitor();
        }

        if (!$user->user_id)
        {
            return true;
        }

        /** @var \XF\App $app */
        $app = $this->app();
        $contentTypeSpecific = (bool) $app->options()->tckDailyLikeLimit_contentTypeSpecific;
        $dailyLikeLimit = $contentTypeSpecific ? $this->getDailyLikeLimit() : $user->hasPermission(
            'general', 'dailyLikeLimit'
        );

        if ($dailyLikeLimit === -1)
        {
            return false;
        }

        if ($dailyLikeLimit === false)
        {
            return true;
        }

        $contentId = $this->getEntityId();
        $contentType = $this->getEntityContentType();
        if (!$contentType)
        {
            throw new \LogicException('No content type provided for {' . __CLASS__ . '}::hasReachedLikeLimit()');
        }

        /** @var ExtendedLikedContentRepo $likedContentRepo */
        $likedContentRepo = $this->repository('XF:LikedContent');
        if ($contentTypeSpecific)
        {
            $likeCount = $likedContentRepo->findLikesByUserTodayForContent($contentType, $contentId, $user)->total();
        }
        else
        {
            $likeCount = $likedContentRepo->findLikesByUserToday($user)->total();
        }

        return $dailyLikeLimit > $likeCount;
    }
}