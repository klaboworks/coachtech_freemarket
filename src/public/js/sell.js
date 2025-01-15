"use-strict";
{
    // 出品画面カテゴリー選択
    const categoryChecks = document.querySelectorAll("input[type=checkbox]");

    categoryChecks.forEach(function (categoryCheck) {
        categoryCheck.addEventListener("change", () => {
            categoryCheck.parentNode.classList.toggle("active");
        });
    });

    const hasErrors = document.getElementById("has-errors").value;
    if (hasErrors === "true") {
        categoryChecks.forEach(function (categoryCheck) {
            if (categoryCheck.checked) {
                categoryCheck.parentNode.classList.add("active");
            }
        });
    }
}
