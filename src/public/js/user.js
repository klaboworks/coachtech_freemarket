"use-strict";
{
    // マイページタブ色変え
    const URL_REQUEST = window.location.href;
    const LISTED_ITEM_PAGE = document.querySelector(".page__sell");
    const BOUGHT_ITEM_PAGE = document.querySelector(".page__buy");

    if (URL_REQUEST === "http://localhost/mypage?page=buy") {
        BOUGHT_ITEM_PAGE.style.color = "red";
    } else {
        LISTED_ITEM_PAGE.style.color = "red";
    }
}
