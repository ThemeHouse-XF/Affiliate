<?php

/**
 * Route prefix handler for affiliate in the admin control panel.
 */
class ThemeHouse_Affiliate_Route_PrefixAdmin_Affiliate implements XenForo_Route_Interface
{

	/**
	 * Match a specific route for an already matched prefix.
	 *
	 * @see XenForo_Route_Interface::match()
	 */
	public function match($routePath, Zend_Controller_Request_Http $request, XenForo_Router $router)
	{
		$action = $router->resolveActionWithIntegerParam($routePath, $request, 'id');
		$action = $router->resolveActionAsPageNumber($action, $request);
		return $router->getRouteMatch('ThemeHouse_Affiliate_ControllerAdmin_Affiliate', $action, 'home');
	}
}