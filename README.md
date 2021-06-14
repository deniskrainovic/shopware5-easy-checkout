# NETS A/S - Shopware 5 Payment Module
============================================

|Module | Nets Easy Payment Module for Shopware 5
|------|----------
|Author | `Nets eCom`
|Prefix | `EASY-SW5`
|Shop Version | `5+`
|Version | `1.0.4`
|Guide | https://tech.nets.eu/shopmodules
|Github | https://github.com/DIBS-Payment-Services/shopware5-easy-checkout

## INSTALLATION

### Download / Installation
1. Unzip and upload the plugin file manually to root/custom/plugins OR Upload the zipped plugin file(https://github.com/DIBS-Payment-Services/shopware5-easy-checkout/tree/master/package)
"NetsCheckoutPayment-shopware5-1.0.4" in admin > Configuration > Plugin Manager and using the 'Upload plugin' option.
2. Clear your cache and refresh after a successful installation in admin > configuration > Cache/Performance.


### Configuration
1. To configure and setup the plugin navigate to : Admin > Configuration > Plugin Manager > Installed
2. Locate the Nets payment plugin and click on edit(pencil icon) to access Configuration.

* Settings Description
1. Login to your Nets Easy account (https://portal.dibspayment.eu/). Test and Live Keys can be found in Company > Integration.
2. Payment Environment. Select between Test/Live transactions. Live mode requires an approved account. Testcard information can be found here: https://tech.dibspayment.com/easy/test-information 
3. Checkout Flow. Redirect - Nets Hosted loads a new payment page. 
4. Enable auto-capture. This function allows you to instantly charge a payment straight after the order is placed.
   NOTE. Capturing a payment before shipment of the order might be liable to restrictions based upon legislations set in your country. Misuse can result in your Easy account being forfeit.

### Operations
* Capture / Refund
1. Navigate to admin > customers > Orders. Press on edit(pencil icon) to access order details.
2. Choose your desired action beneath Nets Checkout tab.
3. All transactions by Nets are accessible in our portal : https://portal.dibspayment.eu/login

### Troubleshooting
* Nets payment plugin is not visible as a payment method
- Ensure the Nets plugin is available in the right Sales Channel in the plugin configuration.
- Under Sales Channel section select your Shop Name for General Settings. Add plugin in Payment methods.
- Temporarily switch to Shopware 6 standard template. Custom templates might need addtional changes to ensure correct display. Consult with your webdesigner / developer.

* Nets payment window is blank
- Ensure your keys in Nets plugin Settings are correct and with no additional blank spaces.
- Temporarily deactivate 3.rd party plugins that might effect the functionality of the Nets plugin.
- Check if there is any temporary technical inconsistencies : https://nets.eu/Pages/operational-status.aspx

* Payments in live mode dont work
- Ensure you have an approved Live Easy account for production.
- Ensure your Live Easy account is approved for payments with selected currency.
- Ensure payment method data is correct and supported by your Nets Easy agreement.

### Contact
* Nets customer service
- Nets Easy provides support for both test and live Easy accounts. Contact information can be found here : https://nets.eu/en/payments/customerservice/

** CREATE YOUR FREE NETS EASY TEST ACCOUNT HERE : https://portal.dibspayment.eu/registration **
