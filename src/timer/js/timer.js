const timer = new Timer();
const selectElement = document.querySelector('.timer-task-select');
const timerButtonElement = document.getElementById('timer-button');
const timeElement = document.getElementById('time');

let selectedIndex;
selectElement.addEventListener('change', (e) => {
  timer.stop();
  selectedIndex = e.target.selectedIndex-1;
  timeElement.innerHTML = taskLogs[selectedIndex].time;
});

timerButtonElement.addEventListener('click', () => {
  if (selectedIndex != null) {
    for (let i=0; i<timerButtonElement.children.length; i++) {
      timerButtonElement.children[i].classList.toggle('clear');
    }
  
    if (timerButtonElement.classList.toggle('start')) {
      timer.start({ startValues: { seconds: timeStringToSeconds(taskLogs[selectedIndex].time) } });
    } else {
      timer.pause();
      const updatedTime = timer.getTimeValues().toString();
      taskLogs[selectedIndex].time = updatedTime;
      updateTaskTime(taskLogs[selectedIndex].id, updatedTime, taskLogs[selectedIndex].task_id, taskLogs[selectedIndex].user_id);
    }
  } else {
    alert('タスクを選択してください');
  }
});

timer.addEventListener('secondsUpdated', () => {
  timeElement.innerHTML = timer.getTimeValues().toString();
});

const timeStringToSeconds = (timeString) => {
  // 時、分、秒を分割
  const [hours, minutes, seconds] = timeString.split(':').map(Number);

  // 各単位を秒に変換して合算
  const totalSeconds = hours * 3600 + minutes * 60 + seconds;

  return totalSeconds;
};

const updateTaskTime = (id, newTime, taskId, userId) => {
  const xhr = new XMLHttpRequest();
  xhr.open('POST', 'timer/update-time.php', true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  
  const data = `id=${encodeURIComponent(id)}&newTime=${encodeURIComponent(newTime)}&taskId=${encodeURIComponent(taskId)}&userId=${encodeURIComponent(userId)}`;
  
  xhr.send(data);
};