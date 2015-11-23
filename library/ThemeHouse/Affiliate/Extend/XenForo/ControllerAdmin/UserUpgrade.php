<?php
/**
 *
 * @see XenForo_ControllerAdmin_UserUpgrade
 */
class ThemeHouse_Affiliate_Extend_XenForo_ControllerAdmin_UserUpgrade extends XFCP_ThemeHouse_Affiliate_Extend_XenForo_ControllerAdmin_UserUpgrade
{
	public function actionSave()
	{
		$GLOBALS['th_affiliate_values'] = array(
			'custom_affiliate_points' => $this->_input->filterSingle('custom_affiliate_points', XenForo_Input::BOOLEAN),
			'affiliate_points'		  => $this->_input->filterSingle('affiliate_points', XenForo_Input::STRING),
		);

		return parent::actionSave();
	}
}

if (false) {
	class XFCP_ThemeHouse_Affiliate_Extend_XenForo_ControllerAdmin_UserUpgrade extends XenForo_ControllerAdmin_UserUpgrade {}
}