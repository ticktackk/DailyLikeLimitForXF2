<?php

namespace TickTackk\DailyLikeLimit\XF\ControllerPlugin;

use XF\Mvc\Entity\Entity;

/**
 * Class Like
 *
 * @package TickTackk\DailyLikeLimit
 */
class Like extends XFCP_Like
{
    /**
     * @param Entity $entity
     * @param $confirmUrl
     * @param $returnUrl
     * @param $likesUrl
     * @param null $contentTitle
     *
     * @return \XF\Mvc\Reply\Error|\XF\Mvc\Reply\Redirect|\XF\Mvc\Reply\View
     */
    public function actionToggleLike(Entity $entity, $confirmUrl, $returnUrl, $likesUrl, $contentTitle = null)
    {
        if ($this->isPost())
        {
            $visitor = \XF::visitor();
            /** @var \TickTackk\DailyLikeLimit\XF\Repository\LikedContent $likeRepo */
            $likeRepo = $this->repository('XF:LikedContent');

            $contentType = $entity->getEntityContentType();
            $contentId = $entity->getEntityId();

            if (!$likeRepo->getLikeByContentAndLiker($contentType, $contentId, $visitor->user_id))
            {
                $dailyLikeLimit = $visitor->hasPermission('dailyLikeLimit', 'maximumAllowedLikes');

                $dailyLikedContentCount = $likeRepo->countDailyLikesByLikeUserId($visitor->user_id);

                if ($dailyLikeLimit !== -1 && ($dailyLikedContentCount >= $dailyLikeLimit))
                {
                    return $this->error(\XF::phraseDeferred('dailyLikeLimit_you_have_reached_your_daily_like_limit'));
                }
            }
        }

        return parent::actionToggleLike($entity, $confirmUrl, $returnUrl, $likesUrl, $contentTitle);
    }
}