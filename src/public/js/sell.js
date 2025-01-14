"use-strict";
{
    // 出品画面カテゴリー選択
    const categoryButtons = document.querySelectorAll(".category-picker");

    categoryButtons.forEach(function (categoryButton) {
        categoryButton.addEventListener("click", () => {
            console.log("clicked");
            categoryButton.classList.toggle("active");
        });
    });
}
