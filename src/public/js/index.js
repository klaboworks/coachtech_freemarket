"use-strict";
{
    // 商品一覧ページタブ色変え
    const currentURL = window.location.href;
    const tabRecommend = document.querySelector(".tab__recommend");
    const tabMylist = document.querySelector(".tab__mylist");

    if (currentURL === "http://localhost/") {
        tabRecommend.style.color = "red";
    }

    if (currentURL === "http://localhost/?tab=mylist") {
        tabMylist.style.color = "red";
    }
}
