<?php

/**
 * Route prefix handler for affiliate in the public system.
 */
class ThemeHouse_Affiliate_Route_Prefix_Affiliate implements XenForo_Route_Interface
{

	/**
	 * Match a specific route for an already matched prefix.
	 *
	 * @see XenForo_Route_Interface::match()
	 */
	public function match($routePath, Zend_Controller_Request_Http $request, XenForo_Router $router)
	{
		return $router->getRouteMatch('ThemeHouse_Affiliate_ControllerPublic_Affiliate', $routePath, 'account');
	}
}