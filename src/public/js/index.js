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

    // フラッシュメッセージアニメーション
    const keyframes = {
        opacity: [1, 0],
        translate: ["0 0", "0 -100%"],
    };

    const options = {
        duration: 1000,
        delay: 1500,
        easing: "ease-out",
        fill: "forwards",
    };

    const success = document.querySelector(".alert-success");
    success.animate(keyframes, options);
}
