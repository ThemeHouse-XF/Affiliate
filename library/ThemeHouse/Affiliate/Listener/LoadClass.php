<?php

class ThemeHouse_Affiliate_Listener_LoadClass extends ThemeHouse_Listener_LoadClass
{

    protected function _getExtendedClasses()
    {
        return array(
            'ThemeHouse_Affiliate' => array(
                'datawriter' => array(
                    'XenForo_DataWriter_User',
                    'XenForo_DataWriter_UserUpgrade',
                ),
                'controller' => array(
                    'XenForo_ControllerAdmin_UserUpgrade',
                    'XenForo_ControllerPublic_Register',
                ),
                'model' => array(
                    'XenForo_Model_UserUpgrade',
                )
            ),
        );
    }

    public static function loadClassController($class, array &$extend)
    {
        $loadClassController = new ThemeHouse_Affiliate_Listener_LoadClass($class, $extend, 'controller');
        $extend = $loadClassController->run();
    }

    public static function loadClassDataWriter($class, array &$extend)
    {
        $loadClassDataWriter = new ThemeHouse_Affiliate_Listener_LoadClass($class, $extend, 'datawriter');
        $extend = $loadClassDataWriter->run();
    }

    public static function loadClassModel($class, array &$extend)
    {
        $loadClassModel = new ThemeHouse_Affiliate_Listener_LoadClass($class, $extend, 'model');
        $extend = $loadClassModel->run();
    }
}