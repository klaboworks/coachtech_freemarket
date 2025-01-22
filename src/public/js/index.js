"use-strict";
{
    // 商品一覧ページタブ色変え
    const currentURL = window.location.href;
    const pageRecommend = document.querySelector(".page__recommend");
    const pageMylist = document.querySelector(".page__mylist");

    if (currentURL.includes("mylist")) {
        pageMylist.style.color = "red";
    } else {
        pageRecommend.style.color = "red";
    }
}
