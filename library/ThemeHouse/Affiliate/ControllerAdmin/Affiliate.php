<?php
class ThemeHouse_Affiliate_ControllerAdmin_Affiliate extends XenForo_ControllerAdmin_Abstract
{
	public function actionWithdraw()
	{
		$viewParams = array(
			'withdrawals'	=> $this->_getWithdrawalModel()->getPendingWithdrawals(),
		);

		return $this->responseView('ThemeHouse_Affiliate_ViewAdmin_Affiliate_Withdraw', 'th_withdraw_affiliate', $viewParams);
	}

	public function actionWithdrawComplete()
	{
		$id = $this->_input->filterSingle('id', XenForo_Input::UINT);

		$withdrawalWriter = XenForo_DataWriter::create('ThemeHouse_Affiliate_DataWriter_Withdraw');
		$withdrawalWriter->setExistingData($id);
		$withdrawalWriter->set('status', 'complete');
		$withdrawalWriter->save();

		return $this->responseRedirect(XenForo_ControllerResponse_Redirect::SUCCESS, XenForo_Link::buildAdminLink('affiliate/withdraw'));
	}

	/**
	 *
	 * @return ThemeHouse_Affiliate_Model_Withdraw
	 */
	protected function _getWithdrawalModel()
	{
		return $this->getModelFromCache('ThemeHouse_Affiliate_Model_Withdraw');
	}
}