"use-strict";
{
    // メッセージ編集パネル
    const EDIT_BUTTONS = document.querySelectorAll(".message-operation__edit");
    const UPDATE_PANELS = document.querySelectorAll(".message-change__edit");
    const CANCEL_EDIT_BUTTONS = document.querySelectorAll(
        ".btn__cancel-update"
    );

    for (let i = 0; i < EDIT_BUTTONS.length; i++) {
        EDIT_BUTTONS[i].addEventListener("click", () => {
            UPDATE_PANELS[i].classList.remove("hide-element");
        });
        CANCEL_EDIT_BUTTONS[i].addEventListener("click", () => {
            UPDATE_PANELS[i].classList.add("hide-element");
        });
    }

    // メッセージ削除パネル
    const DELETE_BUTTONS = document.querySelectorAll(
        ".message-operation__delete"
    );
    const DELETE_PANELS = document.querySelectorAll(".message-change__delete");
    const CANCEL_DELETE_BUTTONS = document.querySelectorAll(
        ".btn__cancel-delete"
    );

    for (let i = 0; i < EDIT_BUTTONS.length; i++) {
        DELETE_BUTTONS[i].addEventListener("click", () => {
            DELETE_PANELS[i].classList.remove("hide-element");
        });
        CANCEL_DELETE_BUTTONS[i].addEventListener("click", () => {
            DELETE_PANELS[i].classList.add("hide-element");
        });
    }

    // 入力メッセージ保持機能
    document.addEventListener("DOMContentLoaded", function () {
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

            // sessionStorage に値が存在する場合、input 要素に設定
            if (STORED_VALUE) {
                input.value = STORED_VALUE;
            }

            // input 要素の値が変更されたら sessionStorage に保存
            input.addEventListener("change", function () {
                sessionStorage.setItem(STORAGE_KEY, this.value);
            });

            // 親の form 要素の submit イベントを監視
            const FORM_ELEMENT = input.closest("form");
            if (FORM_ELEMENT) {
                FORM_ELEMENT.addEventListener("submit", function () {
                    // フォームが送信されたら、対応する sessionStorage の値を削除
                    sessionStorage.removeItem(STORAGE_KEY);
                });
            }
        });
    });
}
