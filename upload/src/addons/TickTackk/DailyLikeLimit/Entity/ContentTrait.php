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

        $dailyLikeLimit = $this->getDailyLikeLimit();
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
        return $dailyLikeLimit > (int) $likedContentRepo->findLikesByUserForContent($contentType, $contentId, $user)
                ->total();
    }
}