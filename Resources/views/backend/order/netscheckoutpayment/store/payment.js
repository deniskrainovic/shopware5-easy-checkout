// store

Ext.define('Shopware.apps.Order.netscheckoutpayment.store.Payment',
{
	extend: 'Ext.data.Store',
	model: 'Shopware.apps.Order.netscheckoutpayment.model.Payment',
	storeId: 'netscheckout-payment-store',
	pageSize: 10,
	autoLoad: false,
	sorters: [
		{
			property: 'createdAt',
			direction: 'DESC'
		}
	],
	proxy: {
		type: 'ajax',
		url: '{url controller="NetsCheckout" action="getpayment"}',
		reader: {
			type: 'json',
			root: 'data',
		}
	}
});
