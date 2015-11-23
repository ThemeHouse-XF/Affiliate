<?php

class ThemeHouse_Affiliate_DataWriter_Withdraw extends XenForo_DataWriter
{

	/**
	 * Gets the fields that are defined for the table.
	 * See parent for explanation.
	 *
	 * @return array
	 */
	protected function _getFields()
	{
		return array(
			'xf_withdraw' => array(
				'withdraw_id' => array(
					'type' => self::TYPE_UINT,
					'autoIncrement' => true
				),
				'user_id' => array(
					'type' => self::TYPE_INT,
					'required' => true
				),
				'amount' => array(
					'type' => self::TYPE_FLOAT,
					'required' => true
				),
				'status' => array(
					'type' => self::TYPE_STRING,
					'default' => 'pending',
				)
			)
		);
	}

	/**
	 * Gets the actual existing data out of data that was passed in.
	 * See parent for explanation.
	 *
	 * @param mixed
	 *
	 * @return array|false
	 */
	protected function _getExistingData($data)
	{
		if (!$id = $this->_getExistingPrimaryKey($data, 'withdraw_id')) {
			return false;
		}

		$withdrawal = $this->_getWithdrawalModel()->getWithdrawalById($id);
		if (!$withdrawal) {
			return false;
		}

		return $this->getTablesDataFromArray($withdrawal);
	}

	/**
	 * Gets SQL condition to update the existing record.
	 *
	 * @return string
	 */
	protected function _getUpdateCondition($tableName)
	{
		return 'withdraw_id = ' . $this->_db->quote($this->getExisting('withdraw_id'));
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