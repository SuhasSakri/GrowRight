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


document.addEventListener("DOMContentLoaded", function() {
  const physicalBlock = document.getElementById("physical");
  const mentalBlock = document.getElementById("mental");
  const activityPage = document.getElementById("activityPage");
  const activityTitle = document.getElementById("activityTitle");
  const activityList = document.getElementById("activityList");

  // PHP will inject the DOB here
  const userDob = "<?= htmlspecialchars($profile['dob'] ?? '') ?>";

  // Calculate user’s age
  function calculateAge(dob) {
    if (!dob) return null;
    const birthDate = new Date(dob);
    const today = new Date();
    let age = today.getFullYear() - birthDate.getFullYear();
    const m = today.getMonth() - birthDate.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
      age--;
    }
    return age;
  }

  const age = calculateAge(userDob);

  // Determine age group
  function getAgeGroup(age) {
    if (age >= 3 && age <= 5) return "3-5";
    if (age >= 6 && age <= 9) return "6-9";
    if (age >= 10 && age <= 13) return "10-13";
    return null;
  }

  const ageGroup = getAgeGroup(age);

  const activities = {
    "physical": {
      "3-5": [
        { title: "Mini Yoga", desc: "Simple poses for flexibility." },
        { title: "Ball Toss", desc: "Improves hand-eye coordination." }
      ],
      "6-9": [
        { title: "Skipping Rope", desc: "Enhances stamina and balance." },
        { title: "Running Games", desc: "Promotes strength and endurance." }
      ],
      "10-13": [
        { title: "Cycling", desc: "Improves cardio and muscle tone." },
        { title: "Team Sports", desc: "Encourages teamwork and fitness." }
      ]
    },
    "mental": {
      "3-5": [
        { title: "Color Sorting", desc: "Boosts attention and learning." },
        { title: "Story Time", desc: "Enhances imagination." }
      ],
      "6-9": [
        { title: "Memory Puzzles", desc: "Improves focus and recall." },
        { title: "Creative Drawing", desc: "Encourages expression and patience." }
      ],
      "10-13": [
        { title: "Brain Teasers", desc: "Enhances problem-solving skills." },
        { title: "Reading Challenge", desc: "Improves comprehension." }
      ]
    }
  };

  function showActivities(type) {
    if (!ageGroup) {
      activityList.innerHTML = `<p class='text-danger mt-3'>Please update your profile with a valid Date of Birth to view age-based routines.</p>`;
      return;
    }

    activityTitle.textContent = `${type === 'physical' ? '🏃‍♂️ Physical' : '🧠 Mental'} Activities for Age ${ageGroup} Years`;
    activityList.innerHTML = "";

    const selectedActivities = activities[type][ageGroup] || [];
    selectedActivities.forEach(act => {
      const div = document.createElement("div");
      div.className = "block mb-3";
      div.textContent = act.title;
      div.onclick = () => showInfo(act.title, act.desc);
      activityList.appendChild(div);
    });

    activityPage.style.display = "block";
  }

  function showInfo(title, desc) {
    document.getElementById("infoBox").style.display = "block";
    document.getElementById("infoTitle").textContent = title;
    document.getElementById("infoDescription").textContent = desc;
  }

  window.closeInfo = function() {
    document.getElementById("infoBox").style.display = "none";
  };

  window.goBack = function() {
    activityPage.style.display = "none";
  };

  physicalBlock.addEventListener("click", () => showActivities("physical"));
  mentalBlock.addEventListener("click", () => showActivities("mental"));
});
