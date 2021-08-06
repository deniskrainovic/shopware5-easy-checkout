// model payment

Ext.define('Shopware.apps.Order.netscheckoutpayment.model.Payment',
{
	extend: 'Ext.data.Model',
	fields: [
		{ name: 'id', type: 'string' },
		{ name: 'orderId', type: 'string' },
		{ name: 'amountAuthorized', type: 'string'},
		{ name: 'amountCaptured', type: 'string'},
		{ name: 'amountRefunded', type: 'string'},
		{ name: 'payStatus', type: 'string'},
		{ name: 'currency', type:'string' }
	],
});
