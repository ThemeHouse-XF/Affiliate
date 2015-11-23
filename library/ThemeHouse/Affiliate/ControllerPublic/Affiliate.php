<?php
class ThemeHouse_Affiliate_ControllerPublic_Affiliate extends XenForo_ControllerPublic_Abstract
{
	protected function _preDispatch($action)
	{
		$visitor = XenForo_Visitor::getInstance();
		if (!$visitor['user_id'] || !$visitor->hasPermission('thAffiliatePermissions', 'accessAffiliateSystem')) {
			throw $this->responseException($this->responseNoPermission());
		}

		if (empty($visitor['affiliate_code'])) {
			$userWriter = XenForo_DataWriter::create('XenForo_DataWriter_User');
			$userWriter->setExistingData($visitor['user_id']);
			$userWriter->preSave();
			$userWriter->save();

			$viewingUser = $userWriter->getMergedData();
			$visitor['affiliate_code'] = $viewingUser['affiliate_code'];
			$visitor->setInstance($visitor);
		}
	}

	public function actionIndex()
	{
		$visitor = XenForo_Visitor::getInstance();
		$xenOptions = XenForo_Application::getOptions();

		$viewParams = array(
			'invitations'			=> $this->_getInvitationModel()->getAllInvitationsByUserId($visitor['user_id']),
			'showAffiliatePoints'	=> ($visitor->hasPermission('thAffiliatePermissions', 'earnAffiliatePoints') && $xenOptions->th_affiliate_enableAffiliatePoints),
		);

		return $this->responseView('ThemeHouse_Affiliate_ViewPublic_Affiliate_Index', 'th_index_affiliate', $viewParams);
	}

	public function actionWithdraw()
	{
		$visitor = XenForo_Visitor::getInstance();
		$xenOptions = XenForo_Application::getOptions();

		if (!$visitor->hasPermission('thAffiliatePermissions', 'earnAffiliatePoints') || !$xenOptions->th_affiliate_enableAffiliatePoints) {
			return $this->responseNoPermission();
		}

		if ($this->isConfirmedPost()) {
			$amount = $this->_input->filterSingle('amount', XenForo_Input::FLOAT);

			if ($amount < $xenOptions->th_affiliate_minWithdraw) {
				return $this->responseError(new XenForo_Phrase('th_you_must_withdraw_at_least_x_affiliate', array('amount' => XenForo_Template_Helper_Core::numberFormat($xenOptions->th_affiliate_minWithdraw, 2))));
			}

			if ($amount > $visitor['affiliate_points']) {
				return $this->responseError(new XenForo_Phrase('th_you_do_not_have_enough_points_affiliate', array('amount' => XenForo_Template_Helper_Core::numberFormat($xenOptions->th_affiliate_minWithdraw, 2))));
			}

			$newPoints = $visitor['affiliate_points'] - $amount;
			$userWriter = XenForo_DataWriter::create('XenForo_DataWriter_User');
			$userWriter->setExistingData(XenForo_Visitor::getUserId());
			$userWriter->set('affiliate_points', $newPoints);
			$userWriter->save();

			$withdrawalWriter = XenForo_DataWriter::create('ThemeHouse_Affiliate_DataWriter_Withdraw');
			$withdrawalWriter->set('user_id', XenForo_Visitor::getUserId());
			$withdrawalWriter->set('amount', $amount);
			$withdrawalWriter->save();

			return $this->responseRedirect(XenForo_ControllerResponse_Redirect::SUCCESS, XenForo_Link::buildPublicLink('affiliate'), new XenForo_Phrase('th_your_withdrawal_request_has_been_submitted_affiliate'));
		} else {
			$viewParams = array();
			return $this->responseView('ThemeHouse_Affiliate_ViewPublic_Affiliate_Withdraw', 'th_withdraw_affiliate', $viewParams);
		}
	}

	public function actionInvite()
	{
		$invitationModel = $this->_getInvitationModel();
		$visitor = XenForo_Visitor::getInstance();
		$xenOptions = XenForo_Application::getOptions();

		$email = $this->_input->filterSingle('email', XenForo_Input::STRING);

		$checkForUser = $this->getModelFromCache('XenForo_Model_User')->getUserByEmail($email);
		if ($checkForUser) {
			return $this->responseRedirect(XenForo_ControllerResponse_Redirect::SUCCESS, XenForo_Link::buildPublicLink('affiliate'), new XenForo_Phrase('th_this_email_is_already_registered_affiliate'));
		}

		$checkForInvite = $invitationModel->getInvitationByUserAndEmail($visitor['user_id'], $email);
		if ($checkForInvite) {
			return $this->responseRedirect(XenForo_ControllerResponse_Redirect::SUCCESS, XenForo_Link::buildPublicLink('affiliate'), new XenForo_Phrase('th_you_have_already_invited_this_user_affiliate'));
		}

		$code = $invitationModel->generateCode();

		$inviteWriter = XenForo_DataWriter::create('ThemeHouse_Affiliate_DataWriter_Invitation');
		$inviteWriter->set('inviter_user_id', $visitor['user_id']);
		$inviteWriter->set('invited_email', $email);
		$inviteWriter->set('code', $code);
		$inviteWriter->save();

		$invitationModel->sendEmailInvitation($email, $visitor->toArray(), $code);

		return $this->responseRedirect(XenForo_ControllerResponse_Redirect::SUCCESS, XenForo_Link::buildPublicLink('affiliate'));
	}

	/**
	 * @return ThemeHouse_Affiliate_Model_Invitation
	 */
	protected function _getInvitationModel()
	{
		return $this->getModelFromCache('ThemeHouse_Affiliate_Model_Invitation');
	}
}