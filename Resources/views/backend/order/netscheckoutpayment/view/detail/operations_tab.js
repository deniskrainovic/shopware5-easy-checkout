// operations tab

Ext.define('Shopware.apps.Order.netscheckoutpayment.view.detail.OperationsTab', 
{
	extend: 'Ext.container.Container',
	alias: 'widget.order-netscheckout-panel',
	cls: Ext.baseCSSPrefix + 'order-netscheckout-panel',
	id: 'order-netscheckout-panel',
	padding: 10,
	snippets: {
		title: '{s name=order/tab/title}Nets Checkout{/s}',
		captureButtonText: '{s name=order/capture_button/text}Capture{/s}',
		refundButtonText: '{s name=order/refund_button/text}Refund{/s}',
	},
	initComponent: function() {
		var me = this;
		me.title = me.snippets.title;
		me.netsAmountAuthorized = 0;
		me.netsAmountCaprured = 0;
		me.netsPayStatus = "Reserved";
		me.netsCurrency = "";
		me.items = [
			me.paymentStatus(),
			me.createCaptureForm(),
			me.createRefundForm()
		];
		me.loadPayment();
		me.callParent(arguments);
		me.disable();
	},

	createForm : function () {
		var me = this;
		return me.createDetailsContainer();
	},

	loadPayment : function () {
		var me = this;
		var form = me.detailsContainer.getForm();
		var refundForm  = me.detailsContainer1.getForm();
		var updatedStatus = me.detailsContainer2.getForm();
		me.netsCheckoutPaymentStore.load({
			params: {
				id: me.record.get('number')
			},
			callback: function(records, operation, success) {
				if(records.length > 0) {
					console.log( records );
					form.loadRecord( records[0] );
					refundForm.loadRecord(records[0]);
					updatedStatus.loadRecord(records[0]);
					me.enable();
				}
			},
			scope: this
		});
	},

	paymentStatus : function() {
		var me = this;
		me.detailsContainer2 = Ext.create('Ext.form.Panel', {
			cls: 'confirm-panel-main',
			bodyPadding: 5,
			margin: '0 0 0 0',
			bodyStyle: 'text-transform: uppercase;',
			layout: 'anchor',
			title: 'Payment Status',
			defaults: {
				anchor: '40%',
				align: 'stretch',
				width: '40%'
			},
			items: [
				{
					xtype: 'displayfield',
					name: 'payStatus',
					fieldLabel: 'Status',
					padding: '4 0 0 0',
					value: me.netsPayStatus
				}
			]

		});
		return me.detailsContainer2;
	},

	createCaptureForm: function() {
		var me = this;
		me.detailsContainer = Ext.create('Ext.form.Panel', {
			cls: 'confirm-panel-main',
			bodyPadding: 5,
			margin: '0 0 5 0',
			bodyStyle: 'display: flex;',
			layout: 'anchor',
			title: 'Nets Api operations',
			url: 'NetsCheckout/capture',
			defaults: {
				anchor: '40%',
				align: 'stretch',
				width: '40%'
			},
			buttons: [
				{
					text: me.snippets.captureButtonText,
					handler: function() {
						Ext.Msg.show({
							title:'Would you like to capture ?',
							msg: 'Amount will be captured',
							buttons: Ext.Msg.YESNO,
							icon: Ext.Msg.QUESTION,
							fn: function(btn) {
								if (btn === 'yes') {
									me.setLoading(true);
									me.detailsContainer.submit({
										success: function(form, operation) {
											me.setLoading(false);
											me.loadPayment();
											Shopware.Notification.createGrowlMessage(me.title, 'Success');
										},
										failure: function(form, operation) {
											// var response = operation.result;
											me.setLoading(false);
											me.loadPayment();
											Shopware.Notification.createGrowlMessage(me.title, 'Failure');
										}
									});
								} else if (btn === 'no') {
									console.log('No pressed');
								} else {
									console.log('Cancel pressed');
								}
							}
						});
					}
				}
			],
			items: [
				{
					xtype: 'textfield',
					name: 'amountAuthorized',
					fieldLabel: 'Amount to be captured',
					value: me.netsAmountAuthorized
				},
				{
					xtype: 'displayfield',
					name: 'currency',
					fieldLabel: '',
					padding: '4 0 0 10',
					value: me.netsCurrency
				},
				// hiddenfield
				{
					xtype: 'hiddenfield',
					name: 'id',
					value: me.record.get('number')
				}
			]
		});
		return me.detailsContainer;
	},

	createRefundForm: function() {
		var me = this;
		me.detailsContainer1 = Ext.create('Ext.form.Panel', {
			cls: 'confirm-panel-main',
			bodyPadding: 5,
			margin: '0 0 5 0',
			bodyStyle: 'display: flex;',
			layout: 'anchor',
			title: 'Nets Api operations',
			url: 'NetsCheckout/refund',
			defaults: {
				anchor: '40%',
				align: 'stretch',
				width: '40%'
			},
			buttons: [
				{
					text: me.snippets.refundButtonText,
					handler: function() {
						Ext.Msg.show({
							title:'Would you like to refund ?',
							msg: 'Amount will be refunded',
							buttons: Ext.Msg.YESNO,
							icon: Ext.Msg.QUESTION,
							fn: function(btn) {
								if (btn === 'yes') {
									me.setLoading(true);
									me.detailsContainer1.submit({
										success: function(form, operation) {
											me.setLoading(false);
											me.loadPayment();
											Shopware.Notification.createGrowlMessage(me.title, 'Success');
										},
										failure: function(form, operation) {
											//var response = operation.result;
											me.setLoading(false);
											me.loadPayment();
											Shopware.Notification.createGrowlMessage(me.title, 'Failure');
										}
									});
								} else if (btn === 'no') {
									console.log('No pressed');
								} else {
									console.log('Cancel pressed');
								}
							}
						});
					}
				},
			],
			items: [
				{
					xtype: 'textfield',
					name: 'amountCaptured',
					fieldLabel: 'Amount to be refunded',
					value: me.netsAmountCaptured
				},
				{
					xtype: 'displayfield',
					name: 'currency',
					fieldLabel: '',
					padding: '4 0 0 10',
					value: me.netsCurrency
				},
				// hiddenfield
				{
					xtype: 'hiddenfield',
					name: 'id',
					value: me.record.get('number')
				}
			]
		});
		return me.detailsContainer1;
	},
});
