<?php

/**
 *
 * @see XenForo_Model_UserUpgrade
 */
class ThemeHouse_Affiliate_Extend_XenForo_Model_UserUpgrade extends XFCP_ThemeHouse_Affiliate_Extend_XenForo_Model_UserUpgrade
{

	public function upgradeUser($userId, array $upgrade, $allowInsertUnpurchasable = false, $endDate = null)
	{
		$xenOptions = XenForo_Application::getOptions();
		$response = parent::upgradeUser($userId, $upgrade, $allowInsertUnpurchasable, $endDate);

		if ($response) {
			$user = $this->_getUserModel()->getUserById($userId);
			if ($user['ref_user_id']) {
				$refUser = $this->_getUserModel()->getUserById($user['ref_user_id']);
				if ($refUser) {
					$pointsToAdd = $xenOptions->th_affiliate_affiliatePointsPerUpgrade;
					if ($upgrade['custom_affiliate_points']) {
						$pointsToAdd = $upgrade['affiliate_points'];
					}

					if (strpos($pointsToAdd, '%')) {
						$pointsToAdd = (float) $pointsToAdd;
						$pointsToAdd = ($pointsToAdd / 100) * $upgrade['cost_amount'];
					}
					$userWriter = XenForo_DataWriter::create('XenForo_DataWriter_User', XenForo_DataWriter::ERROR_SILENT);
					$userWriter->setExistingData($user['ref_user_id']);
					$userWriter->set('affiliate_points', $refUser['affiliate_points'] + $pointsToAdd);
					$userWriter->save();
				}
			}
		}
	}

	/**
	 * @return ThemeHouse_Affiliate_Model_Invitation
	 */
	protected function _getInvitationModel()
	{
		return $this->getModelFromCache('ThemeHouse_Affiliate_Model_Invitation');
	}
}

if (false) {
	class XFCP_ThemeHouse_Affiliate_Extend_XenForo_Model_UserUpgrade extends XenForo_Model_UserUpgrade {}
}