document.querySelectorAll(".tab-link").forEach(link => {
  link.addEventListener("click", function (e) {
    e.preventDefault();
    document.querySelectorAll(".section").forEach(sec => sec.classList.remove("active"));
    document.querySelectorAll(".tab-link").forEach(tab => tab.classList.remove("active"));
    document.getElementById(this.dataset.tab).classList.add("active");
    this.classList.add("active");
  });
});


function dismissReminder() {
  const reminder = document.querySelector('.water-reminder');
  reminder.style.display = 'none';
}

setInterval(() => {
  const reminder = document.querySelector('.water-reminder');
  reminder.style.display = 'block';
}, 10000);
