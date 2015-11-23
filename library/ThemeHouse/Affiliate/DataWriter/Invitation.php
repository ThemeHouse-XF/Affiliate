<?php

class ThemeHouse_Affiliate_DataWriter_Invitation extends XenForo_DataWriter
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
            'xf_invitation' => array(
                'invite_id' => array(
                    'type' => self::TYPE_UINT,
                    'autoIncrement' => true
                ),
                'inviter_user_id' => array(
                    'type' => self::TYPE_INT,
                    'required' => true
                ),
                'invited_user_id' => array(
                    'type' => self::TYPE_INT,
                    'required' => false,
                    'default' => 0,
                ),
                'invited_email' => array(
                    'type' => self::TYPE_STRING,
                    'required' => false,
                    'default' => '',
                ),
                'note' => array(
                    'type' => self::TYPE_STRING,
                    'default' => ''
                ),
                'code' => array(
                    'type' => self::TYPE_STRING,
                    'required' => true
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
        if (!$invitationId = $this->_getExistingPrimaryKey($data, 'invite_id')) {
            return false;
        }

        $invitation = $this->_getInvitationModel()->getInvitationById($invitationId);
        if (!$invitation) {
            return false;
        }

        return $this->getTablesDataFromArray($invitation);
    }

    /**
     * Gets SQL condition to update the existing record.
     *
     * @return string
     */
    protected function _getUpdateCondition($tableName)
    {
        return 'invite_id = ' . $this->_db->quote($this->getExisting('invite_id'));
    }

    /**
     *
     * @return ThemeHouse_Affiliate_Model_Invitation
     */
    protected function _getInvitationModel()
    {
        return $this->getModelFromCache('ThemeHouse_Affiliate_Model_Invitation');
    }
}