"use-strict";
{
    // マイページタブ色変え
    const URL_REQUEST = window.location.href;
    const LISTED_ITEM_PAGE = document.querySelector(".page__sell");
    const BOUGHT_ITEM_PAGE = document.querySelector(".page__buy");
    const DEALING_ITEM_PAGE = document.querySelector(".page__deal");
    const DEALING_PAGE_JUMP = document.querySelectorAll(".jump-to-deal");

    if (URL_REQUEST === "http://localhost/mypage?page=buy") {
        BOUGHT_ITEM_PAGE.style.color = "red";
    } else if (URL_REQUEST === "http://localhost/mypage?page=deal") {
        DEALING_ITEM_PAGE.style.color = "red";
        DEALING_PAGE_JUMP.forEach((element) => {
            element.style.display = "block";
        });
    } else {
        LISTED_ITEM_PAGE.style.color = "red";
    }
}
