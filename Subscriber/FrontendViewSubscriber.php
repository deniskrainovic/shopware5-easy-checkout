<?php
namespace NetsCheckoutPayment\Subscriber;

use Doctrine\Common\Collections\ArrayCollection;
use Enlight\Event\SubscriberInterface;
use Shopware\Components\Theme\LessDefinition;
use NetsCheckoutPayment\Components\NetsCheckoutService;

class FrontendViewSubscriber implements SubscriberInterface
{

    /**
     *
     * @var string
     */
    private $pluginDir;

    /**
     *
     * @param string $pluginDir
     */

    /** @var \NetsCheckoutPayment\Components\NetsCheckoutService */
    private $checkoutService;

    public function __construct($pluginDir)
    {
        $this->pluginDir = $pluginDir;
    }
    
    public function getIconUrl()
    {
        return "url here";
    }

    public static function getSubscribedEvents()
    {
        return [
            'Theme_Inheritance_Template_Directories_Collected' => 'onCollectTemplateDir',   /* Template Pfad festlegen */
			'Theme_Compiler_Collect_Plugin_Javascript' => 'onCollectJavascript',    /* JavaScript Dateien einbinden */
	//		'Theme_Compiler_Collect_Plugin_Less' => 'onCollectLessFiles',    /* Less Dateien einbinden */
			'Enlight_Controller_Action_PostDispatchSecure_Frontend' => 'onPostDispatch'
        ];
    }

    /**
     *
     * @param \Enlight_Event_EventArgs $args
     */
    public function onCollectTemplateDir(\Enlight_Event_EventArgs $args)
    {
        $dirs = $args->getReturn();
        $dirs[] = $this->pluginDir . '/Resources/views/';
        $args->setReturn($dirs);
    }

    /**
     *
     * @return ArrayCollection
     */
    public function onCollectJavascript()
    {
        $jsPath = [
            $this->pluginDir . '/Resources/views/frontend/_public/src/js/jquery.checkout.js'
        ];
        return new ArrayCollection($jsPath);
    }

    /**
     *
     * @return ArrayCollection
     */
    public function onCollectLessFiles()
    {
        $less = new LessDefinition([], [
            $this->pluginDir . '/Resources/views/frontend/_public/src/less/checkout.less'
        ], $this->pluginDir);

        return new ArrayCollection([
            $less
        ]);
    }

    public function onPostDispatch(\Enlight_Controller_ActionEventArgs $args)
    {
        try {
            /** @var \Enlight_Controller_Action $controller */
            $controller = $args->getSubject();

            /** @var \Enlight_Controller_Request_Request $request */
            $request = $controller->Request();

            /** @var \Enlight_Components_Session_Namespace $session */
            $session = $controller->get('session');

            /** @var \Enlight_View_Default $view */
            $view = $controller->View();

            $action = $request->getActionName();
            $shop = Shopware()->Shop();
            $config = Shopware()->Container()
                ->get('shopware.plugin.cached_config_reader')
                ->getByPluginName('NetsCheckoutPayment', $shop);

            $args->getSubject()
                ->View()
                ->assign('debug', $config['debug']);

             $args->getSubject()
                 ->View()
                 ->assign('nets_iconbar', $config['nets_icons_bar']);

            $paymentData = '';

            if ($action === 'confirm' && $config['integrationtype'] == 'EmbeddedCheckout') {

                $checkoutService = Shopware()->Container()->get('nets_checkout.checkout_service');
                $paymentData = $this->handleConfirmDispatch($view, $session, $checkoutService);

                $args->getSubject()
                    ->View()
                    ->assign('nets_path', $this->pluginPath . '/Resources/views/frontend/_public/src/img/nets_logo.png');
                $args->getSubject()
                    ->View()
                    ->assign('api_url', 'https://checkout.dibspayment.eu/v1/checkout.js');
                $args->getSubject()
                    ->View()
                    ->assign('checkout_key', $config['live_checkout_key']);
                if ($config['testmode']) {
                    $args->getSubject()
                        ->View()
                        ->assign('api_url', 'https://test.checkout.dibspayment.eu/v1/checkout.js');
                    $args->getSubject()
                        ->View()
                        ->assign('checkout_key', $config['test_checkout_key']);
                }

                $args->getSubject()
                    ->View()
                    ->assign('integrationtype', $config['integrationtype']);
                $args->getSubject()
                    ->View()
                    ->assign('paymentID', $paymentData['paymentId']);
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            exit();
        }
    }

    private function handleConfirmDispatch(\Enlight_View_Default $view, \Enlight_Components_Session_Namespace $session, NetsCheckoutService $checkoutService)
    {
        $payment = $checkoutService->createPayment($session->offsetGet('sUserId'), $view->getAssign('sBasket'), $session->offsetGet('sessionId'));
        $paymentData = json_decode($payment, true);

        return $paymentData;
    }
}
