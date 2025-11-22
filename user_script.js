// ------------------ Navbar Tab Switching ------------------
document.querySelectorAll(".tab-link").forEach(link => {
  link.addEventListener("click", function (e) {
    e.preventDefault();
    document.querySelectorAll(".section").forEach(sec => sec.classList.remove("active"));
    document.querySelectorAll(".tab-link").forEach(tab => tab.classList.remove("active"));
    document.getElementById(this.dataset.tab).classList.add("active");
    this.classList.add("active");
  });
});

// ------------------ Routines Logic ------------------
document.addEventListener("DOMContentLoaded", function() {
  const physicalBtn = document.getElementById("physical");
  const mentalBtn = document.getElementById("mental");
  const activityPage = document.getElementById("activityPage");
  const activityTitle = document.getElementById("activityTitle");
  const activityList = document.getElementById("activityList");
  const modal = new bootstrap.Modal(document.getElementById("infoModal"));

  const age = userAge;

  function getAgeGroup(age) {
    if (!age) return null;
    if (age >= 3 && age <= 5) return "3-5";
    if (age >= 6 && age <= 9) return "6-9";
    if (age >= 10 && age <= 13) return "10-13";
    // Other ages are not allowed
    return null;
  }

  const ageGroup = getAgeGroup(age);

  // -------- Enhanced Activity Dataset --------
  const activities = {
    physical: {
      "3-5": [
        { title: "Mini Yoga", desc: "Simple poses to improve flexibility." },
        { title: "Ball Toss", desc: "Fun way to enhance coordination." },
        { title: "Hopscotch", desc: "Improves balance and focus." },
        { title: "Dance Time", desc: "Encourages rhythm and joy." },
        { title: "Catch & Run", desc: "Boosts reaction and agility." }
      ],
      "6-9": [
        { title: "Skipping Rope", desc: "Improves stamina and agility." },
        { title: "Tag Game", desc: "Builds endurance and teamwork." },
        { title: "Mini Obstacle Course", desc: "Improves flexibility and fun." },
        { title: "Stretch Routine", desc: "Encourages mobility and strength." },
        { title: "Hula Hoop", desc: "Develops coordination." }
      ],
      "10-13": [
        { title: "Cycling", desc: "Excellent for cardio and balance." },
        { title: "Swimming", desc: "Full-body exercise for fitness." },
        { title: "Skipping Challenge", desc: "Fun and strengthens legs." },
        { title: "Morning Jog", desc: "Enhances stamina and focus." },
        { title: "Plank Practice", desc: "Improves core strength." }
      ]
    },
    mental: {
      "3-5": [
        { title: "Color Sorting", desc: "Enhances focus and creativity." },
        { title: "Story Time", desc: "Develops imagination." },
        { title: "Shape Hunt", desc: "Improves memory and recognition." },
        { title: "Music Play", desc: "Encourages rhythm and focus." },
        { title: "Matching Cards", desc: "Boosts memory retention." }
      ],
      "6-9": [
        { title: "Puzzle Solving", desc: "Improves logic and patience." },
        { title: "Creative Drawing", desc: "Boosts expression skills." },
        { title: "Story Chain", desc: "Improves creativity and language." },
        { title: "Memory Game", desc: "Develops short-term memory." },
        { title: "Math Riddles", desc: "Sharpens problem-solving." }
      ],
      "10-13": [
        { title: "Sudoku", desc: "Builds logical reasoning." },
        { title: "Reading Challenge", desc: "Enhances comprehension." },
        { title: "Brain Quiz", desc: "Boosts critical thinking." },
        { title: "Journaling", desc: "Improves mindfulness." },
        { title: "Crossword", desc: "Enhances vocabulary." }
      ]
    }
  };

  // ------------------ Daily routines (persistent) ------------------
  function getDailyRoutines(type) {
    if (!ageGroup) {
      // Not allowed
      return null;
    }

    const today = new Date().toISOString().slice(0, 10); // YYYY-MM-DD
    const storageKey = `routines_${type}_${ageGroup}`;

    // check if routines already exist for today
    const stored = JSON.parse(localStorage.getItem(storageKey));
    if (stored && stored.date === today) {
      return stored.activities;
    }

    // select 4 random routines for today
    const acts = [...(activities[type][ageGroup] || [])];
    const shuffled = acts.sort(() => 0.5 - Math.random());
    const selected = shuffled.slice(0, 4);

    // save in localStorage
    localStorage.setItem(storageKey, JSON.stringify({ date: today, activities: selected }));

    return selected;
  }

  function showActivities(type) {
    activityList.innerHTML = "";

    if (!ageGroup) {
      activityList.innerHTML = `<div class='alert alert-danger'>Routines are available only for ages 3-13. Your profile age does not qualify.</div>`;
      activityPage.classList.remove("d-none");
      return;
    }

    activityTitle.textContent = `${type === "physical" ? "🏃‍♂️ Physical" : "🧠 Mental"} Activities for Age ${ageGroup}`;
    const dailyActs = getDailyRoutines(type);

    dailyActs.forEach(act => {
      const btn = document.createElement("button");
      btn.className = "list-group-item list-group-item-action text-start";
      btn.textContent = act.title;
      btn.onclick = () => {
        document.getElementById("infoTitle").textContent = act.title;
        document.getElementById("infoDescription").textContent = act.desc;
        modal.show();
      };
      activityList.appendChild(btn);
    });

    activityPage.classList.remove("d-none");
  }

  window.goBack = () => activityPage.classList.add("d-none");

  physicalBtn.addEventListener("click", () => showActivities("physical"));
  mentalBtn.addEventListener("click", () => showActivities("mental"));
});

// ------------------ Water Reminder ------------------
function dismissReminder() {
  const reminder = document.querySelector('.water-reminder');
  reminder.style.display = 'none';
}

setInterval(() => {
  const reminder = document.querySelector('.water-reminder');
  if (reminder) reminder.style.display = 'block';
}, 2 * 60 * 60 * 1000);


const emojis = document.querySelectorAll('.meal-emoji');
  const observer = new IntersectionObserver((entries)=>{
    entries.forEach(entry=>{
      if(entry.isIntersecting){ entry.target.classList.add('visible'); }
    });
  }, {threshold:0.5});
  emojis.forEach(e=>observer.observe(e));

  document.addEventListener('DOMContentLoaded', () => {
  const tipBox = document.getElementById('daily-tip');
  setTimeout(() => {
    tipBox.style.opacity = '1';
    tipBox.style.transform = 'translateY(0)';
  }, 200);
});

