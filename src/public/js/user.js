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

    const success = document.querySelector(".alert-success");
    success.animate(keyframes, options);
}
