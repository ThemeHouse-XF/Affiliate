<?php

class ThemeHouse_Affiliate_Listener_FileHealthCheck
{

    public static function fileHealthCheck(XenForo_ControllerAdmin_Abstract $controller, array &$hashes)
    {
        $hashes = array_merge($hashes,
            array(
                'library/ThemeHouse/Affiliate/ControllerAdmin/Affiliate.php' => 'a4d099586e749c9745fd8be03732f606',
                'library/ThemeHouse/Affiliate/ControllerPublic/Affiliate.php' => 'c4236986b09d1be5d9a02dc880f6b79e',
                'library/ThemeHouse/Affiliate/DataWriter/Invitation.php' => '1892e14072d91c54152f5fbebccce4c0',
                'library/ThemeHouse/Affiliate/DataWriter/Withdraw.php' => 'dde7718f4fb43fd8d8690941cddfadaa',
                'library/ThemeHouse/Affiliate/Extend/XenForo/ControllerAdmin/UserUpgrade.php' => '1e500b1cf624997f2817b5fc079a2973',
                'library/ThemeHouse/Affiliate/Extend/XenForo/ControllerPublic/Register.php' => 'e4ccc85e6c584b185c76feaa6e9c6e1d',
                'library/ThemeHouse/Affiliate/Extend/XenForo/DataWriter/User.php' => '9563b62efd4feb5aefb2998cd343a26f',
                'library/ThemeHouse/Affiliate/Extend/XenForo/DataWriter/UserUpgrade.php' => '341479c8472b97735e0beba4adfeddc7',
                'library/ThemeHouse/Affiliate/Extend/XenForo/Model/UserUpgrade.php' => 'd70e5e0ad40c5849d9088395c10d553c',
                'library/ThemeHouse/Affiliate/Install/Controller.php' => '4ae1772ecb5048a8fd01abcb0994506e',
                'library/ThemeHouse/Affiliate/Listener/LoadClass.php' => '04a716d533b9b221136e1e351e79e699',
                'library/ThemeHouse/Affiliate/Model/Invitation.php' => 'db69a1f66288136d73a9429b81d1f6b2',
                'library/ThemeHouse/Affiliate/Model/Withdraw.php' => '9928c6bb7e2014e8cfc6735f09af04db',
                'library/ThemeHouse/Affiliate/Route/Prefix/Affiliate.php' => 'd35fbc6904c42a63431cf55ba8ac10ca',
                'library/ThemeHouse/Affiliate/Route/PrefixAdmin/Affiliate.php' => '3b31e326e7688e0dff978cc97e10c172',
                'library/ThemeHouse/Install.php' => '18f1441e00e3742460174ab197bec0b7',
                'library/ThemeHouse/Install/20151109.php' => '2e3f16d685652ea2fa82ba11b69204f4',
                'library/ThemeHouse/Deferred.php' => 'ebab3e432fe2f42520de0e36f7f45d88',
                'library/ThemeHouse/Deferred/20150106.php' => 'a311d9aa6f9a0412eeba878417ba7ede',
                'library/ThemeHouse/Listener/ControllerPreDispatch.php' => 'fdebb2d5347398d3974a6f27eb11a3cd',
                'library/ThemeHouse/Listener/ControllerPreDispatch/20150911.php' => 'f2aadc0bd188ad127e363f417b4d23a9',
                'library/ThemeHouse/Listener/InitDependencies.php' => '8f59aaa8ffe56231c4aa47cf2c65f2b0',
                'library/ThemeHouse/Listener/InitDependencies/20150212.php' => 'f04c9dc8fa289895c06c1bcba5d27293',
                'library/ThemeHouse/Listener/LoadClass.php' => '5cad77e1862641ddc2dd693b1aa68a50',
                'library/ThemeHouse/Listener/LoadClass/20150518.php' => 'f4d0d30ba5e5dc51cda07141c39939e3',
            ));
    }
}