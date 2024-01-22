const calInput = document.querySelector(".cal");

const setSession = (val) => {
    sessionStorage.setItem("date", val);
}

const setDate=()=>{
    const dateElem = document.querySelector(".cal-date");
    let date = sessionStorage.getItem("date");
    dateElem.innerHTML = date;
}

export {calInput, setSession, setDate};