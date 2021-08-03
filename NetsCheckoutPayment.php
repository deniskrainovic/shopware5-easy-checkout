<?php

namespace NetsCheckoutPayment;

use Doctrine\ORM\Tools\SchemaTool;

use NetsCheckoutPayment\Models\NetsCheckoutPayment as PaymentModel;

use NetsCheckoutPayment\Models\NetsCheckoutPaymentApiOperations as OperationsModel;

use Shopware\Components\Model\ModelManager;
use Shopware\Components\Plugin;
use Shopware\Components\Plugin\Context\InstallContext;
use Shopware\Components\Plugin\Context\ActivateContext;
use Shopware\Components\Plugin\Context\DeactivateContext;
use Shopware\Components\Plugin\Context\UninstallContext;
use function Shopware;

class NetsCheckoutPayment extends Plugin
{
        public function install(InstallContext $context)
        {
            /** @var \Shopware\Components\Plugin\PaymentInstaller $installer */
            $installer = $this->container->get('shopware.plugin_payment_installer');

            $options = [
                'name' => 'nets_checkout_payment',
                'description' => 'Nets Checkout',
                'action' => 'NetsCheckout',
                'active' => 0,
                'position' => 0,
                'additionalDescription' => 'Nets checkout payment method'
            ];
            $installer->createOrUpdate($context->getPlugin(), $options);
            $this->createTables();
            $this->addStates();
        }

        /**
         * @param UninstallContext $context
         */
        public function uninstall(UninstallContext $context)
        {
            //$this->removeTables();
            $this->setActiveFlag($context->getPlugin()->getPayments(), false);
        }

        /**
         * @param DeactivateContext $context
         */
        public function deactivate(DeactivateContext $context)
        {
            $this->setActiveFlag($context->getPlugin()->getPayments(), false);
        }

        /**
         * @param ActivateContext $context
         */
        public function activate(ActivateContext $context)
        {
            $this->setActiveFlag($context->getPlugin()->getPayments(), true);
        }

        /**
         * @param Payment[] $payments
         * @param $active bool
         */
        private function setActiveFlag($payments, $active)
        {
            $em = $this->container->get('models');

            foreach ($payments as $payment) {
                $payment->setActive($active);
            }
            $em->flush();
        }

    /**
     * Create all tables
     */
    private function createTables()
    {
        /** @var ModelManager $entityManager */
        $entityManager = $this->container->get('models');
        $tool = new SchemaTool($entityManager);
        $classMetaData = [
            $entityManager->getClassMetadata(PaymentModel::class),
            $entityManager->getClassMetadata(OperationsModel::class),

        ];
        $tool->updateSchema($classMetaData, true);
    }

    /**
     * Remove all tables
     */
    private function removeTables()
    {
        /** @var ModelManager $entityManager */
        $entityManager = $this->container->get('models');

        $tool = new SchemaTool($entityManager);

        $classMetaData = [
            $entityManager->getClassMetadata(PaymentModel::class),
            $entityManager->getClassMetadata(OperationsModel::class),
        ];

        $tool->dropSchema($classMetaData);
    }

    /**
     * add new states to s_oreder_states for fully and partially refund
     *
     * @throws \Zend_Db_Adapter_Exception
     */
    private function addStates() {
        $sql = " SELECT * FROM `s_core_states` WHERE  `name` = 'partially_refunded'";
        $row = Shopware()->Db()->fetchOne($sql);

        if(!$row) {
            $sql = "SET @state_id := (select max(id) from s_core_states) + 1;
                    INSERT INTO `s_core_states` (`id`, `name`, `description`, `position`, `group`, `mail`) 
                    VALUES (@state_id, ?, ?, @state_id, ?, ?);";
            Shopware()->Db()->query($sql, ['partially_refunded', 'Partially refunded', 'payment', 0]);
        }

        $sql = " SELECT * FROM `s_core_states` WHERE  `name` = 'completely_refunded'";
        $row = Shopware()->Db()->fetchOne($sql);

        if(!$row) {
            $sql = "SET @state_id := (select max(id) from s_core_states) + 1;
                    INSERT INTO `s_core_states` (`id`, `name`, `description`, `position`, `group`, `mail`) 
                    VALUES (@state_id, ?, ?, @state_id, ?, ?);";
            Shopware()->Db()->query($sql, ['completely_refunded', 'Completely refunded', 'payment', 0]);
        }
    }
}
