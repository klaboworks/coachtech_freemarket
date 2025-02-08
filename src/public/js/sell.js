"use-strict";
{
    // 出品画面カテゴリー選択
    const CATEGORY_CHECKS = document.querySelectorAll("input[type=checkbox]");

    CATEGORY_CHECKS.forEach(function (CATEGORY_CHECK) {
        CATEGORY_CHECK.addEventListener("change", () => {
            CATEGORY_CHECK.parentNode.classList.toggle("active");
        });
    });

    const HAS_ERRORS = document.getElementById("has-errors").value;
    if (HAS_ERRORS === "true") {
        CATEGORY_CHECKS.forEach(function (CATEGORY_CHECK) {
            if (CATEGORY_CHECK.checked) {
                CATEGORY_CHECK.parentNode.classList.add("active");
            }
        });
    }

    // 入力価格３桁でカンマ区切り
    const PRICE_INPUT_PREVIEW = document.getElementById("price-input__preview");
    const PRICE_INPUT_FIX = document.getElementById("price-input__fix");

    PRICE_INPUT_PREVIEW.addEventListener("input", function (event) {
        const INPUT_VALUE = event.target.value.replace(/[^0-9]/g, "");
        const FORMATTED_VALUE = INPUT_VALUE.replace(
            /\B(?=(\d{3})+(?!\d))/g,
            ","
        );
        event.target.value = FORMATTED_VALUE;
        PRICE_INPUT_FIX.value = Number(FORMATTED_VALUE.replace(/,/g, ""));
    });
}
