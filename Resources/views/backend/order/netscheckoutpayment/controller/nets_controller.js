// controller

Ext.define('Shopware.apps.Order.netscheckoutpayment.controller.NetsController',
{
	override: 'Shopware.apps.Order.controller.Main',
	stores: ['Shopware.apps.Order.netscheckoutpayment.store.Payment'],
	showOrder: function(record) {
		var me = this;
		me.callParent(arguments);
	}
});
