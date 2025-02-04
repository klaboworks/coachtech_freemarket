"use-strict";
{
    const PAYMENT = document.getElementById("payment-selector");
    const SELECTED_PAYMENT = document.getElementById("selected-payment");
    const PAYMENT_METHOD = document.getElementById("payment-method");

    function updateSelectedPayment() {
        const SELECTED_INDEX = PAYMENT.selectedIndex;
        const SELECTED_TEXT = PAYMENT.options[SELECTED_INDEX].text;
        SELECTED_PAYMENT.textContent = SELECTED_TEXT;
        PAYMENT_METHOD.value = SELECTED_INDEX;
    }

    PAYMENT.addEventListener("change", updateSelectedPayment);

    const HAS_ERRORS = document.getElementById("has-errors").value;
    if (HAS_ERRORS === "true") {
        updateSelectedPayment();
    }
}
