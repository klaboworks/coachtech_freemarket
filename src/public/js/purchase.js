"use-strict";
{
    const payment = document.getElementById("payment-selector");
    const selectedPayment = document.getElementById("selected-payment");
    const paymentMethod = document.getElementById("payment-method");

    function updateSelectedPayment() {
        const selectedIndex = payment.selectedIndex;
        const selectedText = payment.options[selectedIndex].text;
        console.log(selectedText);
        selectedPayment.textContent = selectedText;
        paymentMethod.value = selectedIndex;
    }

    payment.addEventListener("change", updateSelectedPayment);

    const hasErrors = document.getElementById("has-errors").value;
    if (hasErrors === "true") {
        updateSelectedPayment();
    }
}
