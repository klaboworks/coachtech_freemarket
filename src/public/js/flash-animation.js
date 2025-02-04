"use-strict";
{
    const KEYFRAMES = {
        opacity: [1, 0],
        translate: ["0 0", "0 -100%"],
    };

    const OPTIONS = {
        duration: 1000,
        delay: 1500,
        easing: "ease-out",
        fill: "forwards",
    };

    try {
        const SUCCESS = document.querySelector(".alert-success");
        SUCCESS.animate(KEYFRAMES, OPTIONS);
    } catch {
        const DANGER = document.querySelector(".alert-danger");
        DANGER.animate(KEYFRAMES, OPTIONS);
    }
}
