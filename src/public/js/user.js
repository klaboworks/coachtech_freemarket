"use-strict";
{
    // マイページタブ色変え
    const urlRequest = window.location.href;
    const pageListed = document.querySelector(".page__sell");
    const pageBought = document.querySelector(".page__buy");

    if (urlRequest === "http://localhost/mypage?page=buy") {
        pageBought.style.color = "red";
    } else {
        pageListed.style.color = "red";
    }
}
