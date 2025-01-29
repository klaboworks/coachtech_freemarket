"use-strict";
{
    document.addEventListener("DOMContentLoaded", function () {
        const input = document.getElementById("image");
        const preview = document.getElementById("preview");
        const frame = document.querySelector(".image-preview");

        input.addEventListener("change", function (e) {
            const file = e.target.files[0];
            const maxSize = 2097152;

            if (file.size > maxSize) {
                alert(
                    "ファイルサイズが大きすぎます。2MB以下の画像を選択してください。"
                );
                input.value = "";
            }

            if (file && file.size < maxSize) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.src = e.target.result;
                    preview.style.display = "block";
                };
                reader.readAsDataURL(file);
                frame.style = "z-index:1000";
            }
        });
    });
}
