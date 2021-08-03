{extends file="parent:frontend/checkout/confirm.tpl"}

{block name='frontend_index_content'}


	{if $sUserData.additional.payment.name == 'nets_checkout_payment' && $integrationtype == 'EmbeddedCheckout'}
		<link rel="stylesheet" href="/custom/plugins/NetsCheckoutPayment/Resources/views/frontend/_public/src/css/checkout.css">
		<script type="text/javascript" src="{$api_url}"></script>
		<div class="content--nets confirm--content">
			<div class="nets--block">
				<div class="col-12 ttop"></div>
				<div class="row">
					<div class="col-8 cenl"></div>
					<div class="col-4 cenr"></div>
				</div>
			</div>
			<div class="nets--panel panel has--border">
				<div class="panel--title primary is--underline">Nets Easy</div>
				<div class="panel--body is--wide">
					<div id="dibs-checkout-embedded">
						<div id="dibs-complete-checkout"></div>
					</div>

				</div>
				<script>
					var checkoutOptions = {
						checkoutKey: "{$checkout_key}",
						paymentId : "{$paymentID}",
						containerId : "dibs-complete-checkout",
						language: "en-GB"
					};
					var checkout = new Dibs.Checkout(checkoutOptions);
					checkout.on('payment-completed', function(response) {
						window.location = '{url module=frontend controller=NetsCheckout action=return forceSecure}' + '?paymentid=' + response.paymentId;
					});
				</script>
				<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
				<script src="/custom/plugins/NetsCheckoutPayment/Resources/views/frontend/_public/src/js/checkout.js"></script>
			</div>
		</div>
	{/if}


	{if $sUserData.additional.payment.name == 'nets_checkout_payment' && $debug}
		<div class="content--debug confirm--content">
			<div class="debug--panel panel has--border">
				<div class="panel--title primary is--underline">Nets Debug mode <span class="pid">Payment ID : {$paymentID}</span></div>
			</div>
		</div>
	{/if}

	{$smarty.block.parent}
{/block}
