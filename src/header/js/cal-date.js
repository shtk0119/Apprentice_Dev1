const setDate = (date) => {
	const dateElem = document.querySelector(".cal-date");
	dateElem.innerHTML = date;
};

export { setDate };