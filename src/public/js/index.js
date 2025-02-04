"use-strict";
{
    // 商品一覧ページタブ色変え
    const CURRENT_URL = window.location.href;
    const RECOMMEND_ITEM_PAGE = document.querySelector(".page__recommend");
    const MYLIST_PAGE = document.querySelector(".page__mylist");

    if (CURRENT_URL.includes("mylist")) {
        MYLIST_PAGE.style.color = "red";
    } else {
        RECOMMEND_ITEM_PAGE.style.color = "red";
    }
}
