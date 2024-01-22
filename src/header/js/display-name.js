export const displayName = () => {
    const userName = sessionStorage.getItem("name");
    const nameElem = document.querySelector(".header-username-span");
    nameElem.innerHTML = userName ? userName : "達人くん";
}