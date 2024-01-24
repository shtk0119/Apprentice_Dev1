const setDate = (date) => {
  const dateElement = document.querySelector('.cal-date');
  dateElement.innerHTML = date;
};

export { setDate };