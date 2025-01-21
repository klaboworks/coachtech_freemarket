"use-strict";
{
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

    try {
        const success = document.querySelector(".alert-success");
        success.animate(keyframes, options);
    } catch {
        const danger = document.querySelector(".alert-danger");
        danger.animate(keyframes, options);
    }
}
