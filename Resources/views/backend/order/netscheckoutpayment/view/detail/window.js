// window extends
Ext.define('Shopware.apps.Order.netscheckoutpayment.view.detail.Window',
{
	override: 'Shopware.apps.Order.view.detail.Window',
	createTabPanel: function()
	{
		var me = this;
		var tab_panel = me.callParent(arguments);
		var store = Ext.getStore('Shopware.apps.Order.netscheckoutpayment.store.Payment');
		tab_panel.add(Ext.create('Shopware.apps.Order.netscheckoutpayment.view.detail.OperationsTab', {
			record: me.record,
			netsCheckoutPaymentStore:  store
		}));
		return tab_panel;
	}
});
