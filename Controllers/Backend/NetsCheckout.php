<?php

use NetsCheckoutPayment\Models\NetsCheckoutPayment;
use function Shopware;

class Shopware_Controllers_Backend_NetsCheckout  extends Shopware_Controllers_Backend_Application {

    protected $model = NetsCheckoutPayment::class;

    public function getpaymentAction() {
        $orderId = $this->Request()->get('id');

        /** @var  $payment \NetsCheckoutPayment\Models\NetsCheckoutPayment */
        $payment = Shopware()->Models()->getRepository(NetsCheckoutPayment::class)->findOneBy(['orderId' => $orderId]);

        if($payment) {
            $params = ['data' => ['id' => $payment->getOrderId(),
                'orderId' => $payment->getOrderId(),
                'amountAuthorized' => ($payment->getAmountAuthorized() - $payment->getAmountCaptured() ) / 100,
                'amountCaptured' => ($payment->getAmountCaptured() - $payment->getAmountRefunded() ) / 100,
                'amountRefunded' => $payment->getAmountRefunded() / 100]];
        } else {
            $params = ['data' => []];

        }
        $this->View()->assign($params);
    }

    public function captureAction() {
      $orderId = $this->Request()->get('id');;
      /** @var $service \NetsCheckoutPayment\Components\NetsCheckoutService */
      $service = $this->get('nets_checkout.checkout_service');
      $amountToCharge = str_replace(',', '.', $this->Request()->get('amountAuthorized')) * 100;

      try {
          $service->chargePayment($orderId, $amountToCharge);
          $params = ["success" => true,
              "msg" => "success"];

      }catch (\Exception $ex ) {
          $params = ["success" => false,
              "msg" => "fail"];
      }
          $this->View()->assign($params);
    }

    public function refundAction() {
        $orderId = $this->Request()->get('id');;
        /** @var $service \NetsCheckoutPayment\Components\NetsCheckoutService */
        $service = $this->get('nets_checkout.checkout_service');
        $amountToRefund = str_replace(',', '.', $this->Request()->get('amountCaptured')) * 100;

        try {
            $service->refundPayment($orderId, $amountToRefund);
            $params = ["success" => true,
                "msg" => "success"];

        }catch (\Exception $ex ) {
            $params = ["success" => false,
                "msg" => "fail"];
        }
        $this->View()->assign($params);
    }
}
