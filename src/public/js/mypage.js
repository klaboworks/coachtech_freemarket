"use-strict";
{
    // マイページタブ色変え
    const urlRequest = window.location.href;
    const tabListed = document.querySelector(".tab__sell");
    const tabBought = document.querySelector(".tab__buy");

    if (urlRequest === "http://localhost/mypage?tab=buy") {
        tabBought.style.color = "red";
    } else {
        tabListed.style.color = "red";
    }
}
