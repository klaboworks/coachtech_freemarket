"use-strict";
{
    // マイページタブ色変え
    const URL_REQUEST = window.location.href;
    const LISTED_ITEM_PAGE = document.querySelector(".page__sell");
    const BOUGHT_ITEM_PAGE = document.querySelector(".page__buy");
    const DEALING_ITEM_PAGE = document.querySelector(".page__deal");
    const DEALING_PAGE_JUMP = document.querySelectorAll(".jump-to-deal");

    if (URL_REQUEST === "http://localhost/mypage?page=buy") {
        BOUGHT_ITEM_PAGE.style.color = "red";
    } else if (URL_REQUEST === "http://localhost/mypage?page=deal") {
        DEALING_ITEM_PAGE.style.color = "red";
    } else {
        LISTED_ITEM_PAGE.style.color = "red";
    }

    // ユーザー評価表示機能
    document.addEventListener("DOMContentLoaded", function () {
        const ratingContainers = document.querySelectorAll(".star-rating");

        ratingContainers.forEach((ratingContainer) => {
            const averageRating = parseInt(
                ratingContainer.dataset.averageRating
            );

            if (!isNaN(averageRating)) {
                displayRating(ratingContainer, averageRating);
            }
        });
    });

    function displayRating(containerElement, rating, totalStars = 5) {
        containerElement.innerHTML = "";

        for (let i = 1; i <= totalStars; i++) {
            const star = document.createElement("span");
            star.classList.add("star");
            star.textContent = "★";

            if (i <= rating) {
                star.classList.add("active");
            }

            containerElement.appendChild(star);
        }
    }
}
