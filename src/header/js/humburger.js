export const humburgerMenu = () => {
    const humburgerElem = document.querySelector(".header-humburger");
    const headerElem = document.querySelector(".header");
    humburgerElem.addEventListener("click", () => {
        headerElem.classList.toggle("open");
    })
}