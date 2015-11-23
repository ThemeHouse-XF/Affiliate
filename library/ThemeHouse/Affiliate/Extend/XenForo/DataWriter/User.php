<?php

/**
 *
 * @see XenForo_DataWriter_User
 */
class ThemeHouse_Affiliate_Extend_XenForo_DataWriter_User extends XFCP_ThemeHouse_Affiliate_Extend_XenForo_DataWriter_User
{
	protected static $_invitationId = false;

	protected function _getFields()
	{
		$fields = parent::_getFields();

		$fields['xf_user']['invited_users'] = array('type' => self::TYPE_UINT, 'default' => 0);
		$fields['xf_user']['affiliate_points'] = array('type' => self::TYPE_FLOAT, 'default' => 0.00);
		$fields['xf_user']['affiliate_code'] = array('type' => self::TYPE_STRING, 'default' => '');
		$fields['xf_user']['ref_user_id'] = array('type' => self::TYPE_UINT, 'default' => 0);
		return $fields;
	}

	protected function _preSave()
	{
		parent::_preSave();

		$code = $this->get('affiliate_code');

		if (empty($code)) {
			$this->setAffiliateCode();
		}

		if ($this->isInsert()) {
			$invitationModel = $this->_getInvitationModel();
			$cookieVal = XenForo_Helper_Cookie::getCookie('ref');
			if ($cookieVal) {
				$cookieParts = explode('_', $cookieVal);
				if (isset($cookieParts[1])) {
					$ref = $cookieParts[1];

					$invitation = false;
					if ($cookieParts[0] == 'u') {
						$invitation = $invitationModel->getUserByCode($ref);
					} else if ($cookieParts[0] == 'i') {
						$invitation = $invitationModel->getInvitationByCode($ref);
					}

					if ($invitation) {
						if ($cookieParts[0] == 'i') {
							self::$_invitationId = $invitation['invite_id'];
						}
						$this->set('ref_user_id', $invitation['user_id']);
					}
				}
			}
		}
	}

	public function _postSave()
	{
		parent::_postSave();
		if ($this->isInsert()) {
			$refId = $this->get('ref_user_id');
			if ($refId) {
				$userWriter = XenForo_DataWriter::create('XenForo_DataWriter_User');
				$userWriter->setExistingData($refId);
				$user = $userWriter->getMergedData();
				if ($user) {
					$userWriter->set('invited_users', $user['invited_users'] + 1);
				}
				$userWriter->save();

				if (self::$_invitationId) {
					$invitationWriter = XenForo_DataWriter::create('ThemeHouse_Affiliate_DataWriter_Invitation');
					$invitationWriter->setExistingData(self::$_invitationId);
					$newUser = $this->getMergedData();
					$invitationWriter->set('invited_user_id', $newUser['user_id']);
					$invitationWriter->save();
				}
			}
		}
	}

	public function setAffiliateCode()
	{
		$code = $this->_getInvitationModel()->generateCode();
		$this->set('affiliate_code', $code);
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
	class XFCP_ThemeHouse_Affiliate_Extend_XenForo_DataWriter_User extends XenForo_DataWriter_User {}
}