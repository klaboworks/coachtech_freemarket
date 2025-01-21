"use-strict";
{
    const payment = document.getElementById("payment-selector");
    const selectedPayment = document.getElementById("selected-payment");

    payment.addEventListener("change", function () {
        const selectedIndex = payment.selectedIndex;
        const selectedText = payment.options[selectedIndex].text;
        console.log(selectedText);
        selectedPayment.textContent = selectedText;
    });
}
