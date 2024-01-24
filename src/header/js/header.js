import { setDate } from "./calDate.js";
import { getQueryParams } from "../../js/getQueryParams.js";
import { postDateQueryParams } from "../../js/postQueryParams.js";
import { displayName } from "./display-name.js";
import { humburgerMenu } from "./humburger.js";

const calInput = document.querySelector(".cal");

humburgerMenu();

flatpickr("#myCal", {
  "locale": "en"
});

document.addEventListener("DOMContentLoaded", () => {
	// 今日の日付を取得
	const date = new Date();
	const today = date.toLocaleDateString("sv-SE");

	// URLクエリからdateを取得
	const queryParamDate = getQueryParams("date");

	// URLクエリをチェック
	if (queryParamDate === null) postDateQueryParams(today);
	
	setDate(queryParamDate);
	displayName();
});

calInput.addEventListener("change", (e) => {
	const calValue = e.target.value;
	setDate(calValue);
	postDateQueryParams(calValue);
});