"use-strict";
{
    // ハンバーガーメニュー
    const MENU_OPEN = document.querySelector(".humburger__open");
    const MENU_CLOSE = document.querySelector(".humburger__close");
    const MENU_PANEL = document.querySelector(".humburger-menu__elements");

    MENU_OPEN.addEventListener("click", () => {
        MENU_PANEL.style.transform = "none";
        document.body.style.overflow = "hidden";
    });

    MENU_CLOSE.addEventListener("click", () => {
        MENU_PANEL.style.transform = "translateX(100%)";
        document.body.style.overflow = "auto";
    });
}
