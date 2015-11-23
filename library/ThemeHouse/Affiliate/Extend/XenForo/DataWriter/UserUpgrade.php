<?php

/**
 *
 * @see XenForo_DataWriter_UserUpgrade
 */
class ThemeHouse_Affiliate_Extend_XenForo_DataWriter_UserUpgrade extends XFCP_ThemeHouse_Affiliate_Extend_XenForo_DataWriter_UserUpgrade
{
	protected static $_invitationId = false;

	protected function _getFields()
	{
		$fields = parent::_getFields();

		$fields['xf_user_upgrade']['custom_affiliate_points'] = array('type' => self::TYPE_BOOLEAN, 'default' => 0);
		$fields['xf_user_upgrade']['affiliate_points'] = array('type' => self::TYPE_STRING, 'default' => '0.00');

		return $fields;
	}

	protected function _preSave()
	{
		parent::_preSave();

		if (isset($GLOBALS['th_affiliate_values'])) {
			$this->set('custom_affiliate_points', $GLOBALS['th_affiliate_values']['custom_affiliate_points']);
			$this->set('affiliate_points', $GLOBALS['th_affiliate_values']['affiliate_points']);
		}
	}
}

if (false) {
	class XFCP_ThemeHouse_Affiliate_Extend_XenForo_DataWriter_UserUpgrade extends XenForo_DataWriter_UserUpgrade {}
}