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
        },

        initComponent: function() {
            var me = this;
            me.title = me.snippets.title;
            me.netsAmountAuthorized = 0;
            me.items = [
                me.createForm()
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
            me.netsCheckoutPaymentStore.load({
                params: {
                    id: me.record.get('number')
                },
                callback: function(records, operation, success) {
                      if(records.length > 0) {
                          console.log( records );
                          form.loadRecord(records[0]);
                          me.enable();
                    }
                },
                scope: this
            });
        },

        /**
         *
         */
        createDetailsContainer: function()
        {
            var me = this;

            me.detailsContainer = Ext.create('Ext.form.Panel', {
                cls: 'confirm-panel-main',
                bodyPadding: 5,
                margin: '0 0 5 0',
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
                    },
                ],

                items: me.createFields()

            });

            return me.detailsContainer;
        },

        createFields: function() {
            var me = this;

            var items = [
                {
                    xtype: 'textfield',
                    name: 'amountAuthorized',
                    fieldLabel: 'Amount to be captured',
                    value: me.netsAmountAuthorized
                },
                // hiddenfield
                {
                    xtype: 'hiddenfield',
                    name: 'id',
                    value: me.record.get('number')
                },
            ];

            return items;
        },

    });