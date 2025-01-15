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
