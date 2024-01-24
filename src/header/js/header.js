import { displayName } from "./display-name.js";
import { humburgerMenu } from "./humburger.js";
import { dateSubmit } from "./dateSubmit.js"

// flatpickr実行
flatpickr("#myCal", {
  "locale": "en"
});

// カレンダーの日付選択でPOSTリクエスト
const calInput = document.querySelector(".cal");
calInput.addEventListener("change", () => {
    dateSubmit();
})

// HTMLが読み込まれたら、usernameを表示
document.addEventListener("DOMContentLoaded", () => {
    displayName();
})

// ハンバーガーメニューアニメーション
humburgerMenu();
