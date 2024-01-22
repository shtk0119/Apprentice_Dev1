import { calInput, setSession, setDate } from "./cal-date.js";
import { displayName } from "./display-name.js";
import { humburgerMenu } from "./humburger.js";

flatpickr("#myCal", {
    "locale": "en"
})

document.addEventListener("DOMContentLoaded", () => {
    const date = new Date();
    const today = date.toLocaleDateString('sv-SE');
    setSession(today);
    setDate();
    displayName();
})

calInput.addEventListener("change", () => {
    const calVal = calInput.value;
    setSession(calVal);
    setDate();
})

humburgerMenu();