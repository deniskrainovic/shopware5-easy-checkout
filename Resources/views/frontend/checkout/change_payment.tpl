{extends file="parent:frontend/checkout/change_payment.tpl"}

{block name='frontend_checkout_payment_fieldset_input_label'}
	<div class="method--label is--first">
		<label class="method--name is--strong" for="payment_mean{$payment_mean.id}">
			{$payment_mean.description}
			{if $payment_mean.name == 'nets_checkout_payment'}
				<link rel="stylesheet" href="/custom/plugins/NetsCheckoutPayment/Resources/views/frontend/_public/src/css/checkout.css">
				<span class="nets--iconbar">
					<object type="image/svg+xml" data="{$nets_iconbar}"/></object>
				</span>
			{/if}
		</label>
	</div>
{/block}
