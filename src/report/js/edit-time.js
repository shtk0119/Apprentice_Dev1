const editTimeElems = document.querySelectorAll(".daily-time-input")
const taskFormElem = document.querySelectorAll(".report-task-form")
editTimeElems.forEach((editTimeElem) => {
    editTimeElem.addEventListener("change", () => {
        taskFormElem.submit()
    })
})