"use-strict";
{
    // ハンバーガーメニュー
    const menuOpen = document.querySelector(".humburger__open");
    const menuClose = document.querySelector(".humburger__close");
    const menuPanel = document.querySelector(".humburger-menu__elements");

    menuOpen.addEventListener("click", () => {
        menuPanel.style.transform = "none";
        document.body.style.overflow = "hidden";
    });

    menuClose.addEventListener("click", () => {
        menuPanel.style.transform = "translateX(100%)";
        document.body.style.overflow = "auto";
    });

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
