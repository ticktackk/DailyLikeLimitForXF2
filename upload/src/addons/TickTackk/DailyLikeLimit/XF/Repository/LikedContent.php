<?php

namespace TickTackk\DailyLikeLimit\XF\Repository;

class LikedContent extends XFCP_LikedContent
{
    public function findDailyLikesByLikeUserId($userId)
    {
        return $this->finder('XF:LikedContent')
            ->where([
                'like_user_id' => $userId
            ])
            ->where('like_date', '>=', strtotime("midnight", \XF::$time))
            ->setDefaultOrder('like_date', 'DESC');
    }

    public function countDailyLikesByLikeUserId($userId)
    {

        return $this->db()->fetchOne("
            SELECT COUNT(*) liked_content_count
            FROM xf_liked_content
            WHERE like_user_id = ?
            AND like_date >= ?
        ", [$userId, strtotime("midnight", \XF::$time)]);
    }
}