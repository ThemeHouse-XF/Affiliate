<?php

class ThemeHouse_Affiliate_Model_Invitation extends XenForo_Model
{
    /**
     * Selets invitation by id
     *
     * @param $invitationId
     * @return array
     */
    public function getInvitationById($invitationId)
    {
        return $this->_getDb()->fetchRow("
            SELECT *
            FROM xf_invitation
            WHERE invite_id = ?
        ", $invitationId);
    }

    public function getInvitationByUserAndEmail($userId, $email)
    {
        return $this->_getDb()->fetchRow("
            SELECT *
            FROM xf_invitation
            WHERE inviter_user_id=?
            AND invited_email=?
        ", array($userId, $email));
    }

    public function getAllInvitationsByUserId($userId)
    {
        return $this->fetchAllKeyed("
            SELECT invite.*, user.*
            FROM xf_invitation AS invite
            LEFT JOIN xf_user AS user ON (user.user_id=invite.invited_user_id)
            WHERE invite.inviter_user_id=?
            ", 'invite_id', $userId);
    }

    public function getInvitationByCode($affiliateCode)
    {
        return $this->_getDb()->fetchRow("
            SELECT invite.*, user.*
            FROM xf_invitation AS invite
            LEFT JOIN xf_user AS user ON (user.user_id=invite.inviter_user_id)
            WHERE code=?
            AND invited_user_id=0
            LIMIT 1
            ", $affiliateCode);
    }

    public function getUserByCode($affiliateCode)
    {
        return $this->_getDb()->fetchRow("
            SELECT user.*
            FROM xf_user AS user
            WHERE affiliate_code=?
            LIMIT 1
            ", $affiliateCode);
    }

    /**
     * Generates random affiliate code
     *
     * @param int $length
     * @return string
     */
    public function generateCode($length=10)
    {
        $strBox = 'abcdefghijklmnopqrstuvwxyz1234567890';
        $maxGen = strlen($strBox) - 1;
        $randomString = '';
        for ($i=0;$i<$length;++$i) {
            $randKey = rand(0,$maxGen);
            $randomString .= $strBox[$randKey];
        }

        return $randomString;
    }

    /**
     * Send email invitation to the specified user.
     *
     * @param array $user User to send to
     * @param array|null $confirmation Existing confirmation record; if null, generates a new record
     *
     * @return boolean True if the email was sent successfully
     */
    public function sendEmailInvitation($email, array $user, $affiliateCode)
    {
        $params = array(
            'username' => $user['username'],
            'affiliate_code' => $affiliateCode,
        );

        $mail = XenForo_Mail::create('th_affiliate_invitation', $params, $user['language_id']);

        return $mail->send($email, '');
    }
}