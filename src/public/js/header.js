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
}
