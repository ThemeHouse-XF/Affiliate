<?php

class ThemeHouse_Affiliate_Install_Controller extends ThemeHouse_Install
{

    protected function _getTables()
    {
        return array(
            'xf_invitation' => array(
				'invite_id'            => 'int(10) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY',
                'inviter_user_id'      => 'int(10) UNSIGNED NOT NULL',
                'invited_user_id'      => 'int(10) UNSIGNED NOT NULL default \'0\'',
				'invited_email'        => 'varchar(120) NOT NULL default \'\'',
				'note'       		   => 'text NOT NULL',
                'code'                 => 'varchar(120) NOT NULL default \'\'',
            ),
            'xf_withdraw' => array(
                'withdraw_id'          => 'int(10) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY',
                'user_id'              => 'int(10) UNSIGNED NOT NULL',
                'amount'               => 'DECIMAL(30,2) UNSIGNED NOT NULL DEFAULT \'0.00\'',
                'status'               => 'varchar(120) NOT NULL default \'pending\'',
            )
        );
    }

    protected function _getTableChanges()
    {
        return array(
            'xf_user' => array(
                'invited_users'     => 'int(10) UNSIGNED DEFAULT \'0\'',
                'affiliate_points'  => 'DECIMAL(30,2) UNSIGNED NOT NULL DEFAULT \'0.00\'',
                'affiliate_code'    => 'varchar(120) NOT NULL default \'\'',
                'ref_user_id'       => 'int(10) UNSIGNED DEFAULT \'0\'',
            ),
            'xf_user_upgrade' => array(
                'custom_affiliate_points'  => 'int(3) UNSIGNED NOT NULL DEFAULT \'0\'',
                'affiliate_points'  => 'varchar(250) NOT NULL DEFAULT \'0.00\'',
            ),
        );
    }

    protected function _getPermissionEntries()
    {
        return array(
            'thAffiliatePermissions'       => array(
                'accessAffiliateSystem'     => array(
                    'permission_group_id'   => 'forum',
                    'permission_id'         => 'postThread'
                )
            ),
            'earnAffiliatePoints' => array(
                'accessAffiliateSystem'     => array(
                    'permission_group_id'   => 'forum',
                    'permission_id'         => 'postThread'
                )
            ),
        );
    }
}