<?php

namespace NetsCheckoutPayment\Subscriber;

use Enlight\Event\SubscriberInterface;
use Shopware\Components\DependencyInjection\Container;

class Backend implements SubscriberInterface
{

    /**
     *  @var Container $container
     */
    protected $container;

    protected $pluginDirectory;

    /**
     * @param DIContainer $container
     */
    public function __construct(Container $container, $pluginDirectory)
    {
        $this->container = $container;
        $this->pluginDirectory = $pluginDirectory;
    }


    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents()
    {
        return [
            "Enlight_Controller_Action_PostDispatchSecure_Backend_Order" => "onPostDispatchBackendOrder"
        ];
    }

    /**
     * onPostDispatchBackendOrder:
     *
     * @access public
     * @param \Enlight_Event_EventArgs $args
     */
    public function onPostDispatchBackendOrder(\Enlight_Event_EventArgs $args)
    {

        /** @var \Shopware_Controllers_Backend_Order $controller */
        $controller = $args->getSubject();

        $view = $controller->View();
        $request = $controller->Request();

        $view->addTemplateDir($this->pluginDirectory . '/Resources/views');

        error_log( $this->pluginDirectory . '/Resources/views' );

        switch ($request->getActionName())
        {
            case 'index' :
                //$view->extendsTemplate('backend/order/nets/app.js');
                $view->extendsTemplate('backend/order/netscheckoutpayment/app.js');
                error_log('index envent');
                break;
            case 'load' :
                $view->extendsTemplate('backend/order/netscheckoutpayment/view/detail/window.js');
                error_log('load event');
                break;

        }
    }
}