"use-strict";
{
    document.addEventListener("DOMContentLoaded", function () {
        const IMAGE_INPUT = document.getElementById("image");
        const IMAGE_PREVIEW = document.getElementById("preview");
        const IMAGE_FRAME = document.querySelector(".image-preview");

        IMAGE_INPUT.addEventListener("change", function (e) {
            const FILE = e.target.files[0];
            const MAX_SIZE = 2097152;

            if (FILE.size > MAX_SIZE) {
                alert(
                    "ファイルサイズが大きすぎます。2MB以下の画像を選択してください。"
                );
                IMAGE_INPUT.value = "";
            }

            if (FILE && FILE.size < MAX_SIZE) {
                const READER = new FileReader();
                READER.onload = function (e) {
                    IMAGE_PREVIEW.src = e.target.result;
                    IMAGE_PREVIEW.style.display = "block";
                };
                READER.readAsDataURL(FILE);
                IMAGE_FRAME.style = "z-index:1000";
            }
        });
    });
}
