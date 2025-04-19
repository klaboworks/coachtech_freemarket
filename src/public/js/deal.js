"use strict";
(() => {
    // メッセージ編集パネル
    const EDIT_BUTTONS = document.querySelectorAll(".message-operation__edit");
    const UPDATE_PANELS = document.querySelectorAll(".message-change__edit");
    const CANCEL_EDIT_BUTTONS = document.querySelectorAll(
        ".btn__cancel-update"
    );

    EDIT_BUTTONS.forEach((button, index) => {
        button.addEventListener("click", () => {
            if (UPDATE_PANELS[index]) {
                UPDATE_PANELS[index].classList.remove("hide-element");
            }
        });
        if (CANCEL_EDIT_BUTTONS[index]) {
            CANCEL_EDIT_BUTTONS[index].addEventListener("click", () => {
                if (UPDATE_PANELS[index]) {
                    UPDATE_PANELS[index].classList.add("hide-element");
                }
            });
        }
    });

    // メッセージ削除パネル
    const DELETE_BUTTONS = document.querySelectorAll(
        ".message-operation__delete"
    );
    const DELETE_PANELS = document.querySelectorAll(".message-change__delete");
    const CANCEL_DELETE_BUTTONS = document.querySelectorAll(
        ".btn__cancel-delete"
    );

    DELETE_BUTTONS.forEach((button, index) => {
        button.addEventListener("click", () => {
            if (DELETE_PANELS[index]) {
                DELETE_PANELS[index].classList.remove("hide-element");
            }
        });
        if (CANCEL_DELETE_BUTTONS[index]) {
            CANCEL_DELETE_BUTTONS[index].addEventListener("click", () => {
                if (DELETE_PANELS[index]) {
                    DELETE_PANELS[index].classList.add("hide-element");
                }
            });
        }
    });

    document.addEventListener("DOMContentLoaded", function () {
        // 入力メッセージ保持機能
        const INPUT_ELEMENTS = document.querySelectorAll(
            "input[data-persist-key]"
        );

        INPUT_ELEMENTS.forEach(function (input) {
            const PERSIST_KEY = input.dataset.persistKey;
            const STORAGE_KEY = `input_${window.location.pathname.replace(
                /\//g,
                "_"
            )}_${PERSIST_KEY}`;
            const STORED_VALUE = sessionStorage.getItem(STORAGE_KEY);

            if (STORED_VALUE) {
                input.value = STORED_VALUE;
            }

            input.addEventListener("change", function () {
                sessionStorage.setItem(STORAGE_KEY, this.value);
            });

            const FORM_ELEMENT = input.closest("form");
            if (FORM_ELEMENT) {
                FORM_ELEMENT.addEventListener("submit", function () {
                    sessionStorage.removeItem(STORAGE_KEY);
                });
            }
        });

        // ユーザー評価機能
        const stars = document.querySelectorAll(".star");
        const ratingValueInput = document.getElementById("rating-value");

        stars.forEach((star) => {
            star.addEventListener("click", function () {
                const clickedRating = parseInt(this.dataset.rating);

                stars.forEach((s) => {
                    const starRating = parseInt(s.dataset.rating);
                    if (starRating <= clickedRating) {
                        s.classList.add("active");
                    } else {
                        s.classList.remove("active");
                    }
                });

                ratingValueInput.value = clickedRating;
            });
        });
    });
})();
