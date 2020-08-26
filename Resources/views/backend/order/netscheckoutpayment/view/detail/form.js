//form

Ext.define('Shopware.apps.Order.netscheckoutpayment.view.detail.form',
    {
        extend: 'Ext.form.Panel',

        alias: 'widget.order-form--panel',

        cls: Ext.baseCSSPrefix + 'order-netscheckout-confirm-panel',

        flex: 1,

        bodyPadding: '10 10 10 10',

        border: 0,

        autoScroll: true,

        collapsible: false,

        snippets:
            {
                buttons:
                    {
                        confirm: '{s name=order/buttons/confirm}Confirm{/s}',
                        cancel: '{s name=order/buttons/cancel}Cancel{/s}'
                    }
            },

        /**
         *
         */
        initComponent:function()
        {
            var me = this;
            var store = Ext.getStore('Shopware.apps.Order.netscheckoutpayment.store.Payment');
            me.items = [
                me.createDetailsContainer(),
            ];
            me.callParent(arguments);
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
                defaults: {
                    anchor: '100%',
                    align: 'stretch',
                    width: '100%'
                },
                items: me.createFields()

            });

            return me.detailsContainer;
        },

        createFields: function() {
            var me = this;

            var items = [
                {
                    xtype: 'textfield',
                    name: 'message',
                    fieldLabel: 'Amount to be captured',
                    value: 'me.message'
                }
            ];

            return items;
        },

    });
