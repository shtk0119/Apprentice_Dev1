const taskInputElems = document.querySelectorAll(".tasks-item-input");
const editIconElems = document.querySelectorAll(".tasks-edit-rename");
const completeIconElems = document.querySelectorAll(".tasks-item-complete");

const taskInputFocus = (event) => {
    taskInputElems.forEach(taskInputElem => {
        taskInputElem.addEventListener(event, () => {
            const taskFormElem = taskInputElem.closest(".tasks-form")
            const taskCancelElem = taskFormElem.querySelector(".tasks-item-cancel")
            const editRenameElem = taskFormElem.querySelector(".tasks-edit-rename")
            taskCancelElem.classList.toggle("show");
            editRenameElem.classList.toggle("editing");
        })
    });
}

taskInputFocus("focus");
taskInputFocus("blur");

editIconElems.forEach((editIconElem) => {
    let isEdit = false;
    editIconElem.addEventListener("click", (e) => {
        const taskFormElem = editIconElem.closest(".tasks-form")
        const taskInputElem = taskFormElem.querySelector(".tasks-item-input")
        if (isEdit) {
            editIconElem.submit()
            return isEdit = false;
        } else {
            taskInputElem.focus()
            e.preventDefault()
            return isEdit = true;
        }
    })
})

completeIconElems.forEach((completeIconElem) => {
    completeIconElem.addEventListener("click", () => {
        toggleDeleteFlag(completeIconElem);
        const taskFormElem = completeIconElem.closest(".tasks-form")
        taskFormElem.submit();
    })
})

const toggleDeleteFlag = (elem) => {
    let deleteFlag = elem.value;
    if (deleteFlag === "0") {
        elem.value = "1";
    } else {
        elem.value = "0";
    }
}
