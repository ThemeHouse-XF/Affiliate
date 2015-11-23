<?php

class ThemeHouse_Affiliate_Model_Withdraw extends XenForo_Model
{
	/**
	 * Selects withdrawal by id
	 *
	 * @param $withdrawalId
	 * @return array
	 */
	public function getWithdrawalById($withdrawalId)
	{
		return $this->_getDb()->fetchRow("
            SELECT *
            FROM xf_withdraw
            WHERE withdraw_id = ?
        ", $withdrawalId);
	}

	public function getPendingWithdrawals()
	{
		return $this->fetchAllKeyed("
			SELECT withdrawal.*, user.*
			FROM xf_withdraw AS withdrawal
			LEFT JOIN xf_user AS user ON (user.user_id = withdrawal.user_id)
			WHERE status='pending'
			", 'withdraw_id');
	}
}