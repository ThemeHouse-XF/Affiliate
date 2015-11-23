<?php
/**
 *
 * @see XenForo_ControllerPublic_Register
 */
class ThemeHouse_Affiliate_Extend_XenForo_ControllerPublic_Register extends XFCP_ThemeHouse_Affiliate_Extend_XenForo_ControllerPublic_Register
{
	public function actionIndex()
	{
		$ref = $this->_input->filterSingle('ref', XenForo_Input::STRING);
		if (!empty($ref)) {
			$invitationModel = $this->_getInvitationModel();
			$invitationType = 'i';
			$invitation = $invitationModel->getInvitationByCode($ref);
			$invitationKey = null;
			if (!$invitation) {
				$invitationType = 'u';
				$invitation = $invitationModel->getUserByCode($ref);
				if ($invitation) {
					$invitationKey = $invitation['user_id'];
				}
			} else {
				$invitationKey = $invitation['invite_id'];
			}

			if ($invitation) {
				$cookieVal = $invitationType.'_'.$ref;
				XenForo_Helper_Cookie::setCookie('ref', $cookieVal);
			}
		}

		return parent::actionIndex();
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
	class XFCP_ThemeHouse_Affiliate_Extend_XenForo_ControllerPublic_Register extends XenForo_ControllerPublic_Register {}
}