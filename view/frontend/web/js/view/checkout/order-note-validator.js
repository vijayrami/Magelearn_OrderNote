define(
    [
        'uiComponent',
        'Magento_Checkout/js/model/payment/additional-validators',
        'Magelearn_OrderNote/js/model/checkout/order-note-validator'
    ],
    function (Component, additionalValidators, ordernoteValidator) {
        'use strict';

        additionalValidators.registerValidator(ordernoteValidator);

        return Component.extend({});
    }
);
