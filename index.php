<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>GrowRight</title>
    <link rel="stylesheet" href="style.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
    />
  </head>
  <body>
    <header class="header">
      <div class="nav">
        <a href="#" class="nav_logo">GrowRight</a>
        <ul class="nav_items">
          <li class="nav_item">
            <a href="#Home" class="nav_link active">Home</a>
            <a href="#services" class="nav_link">Services</a>
            <a href="#contact" class="nav_link">Contact</a>
            <a href="#privacy" class="nav_link">Privacy</a>
            <a href="#about" class="nav_link">About</a>
          </li>
        </ul>
        <button class="button">
          <a href="login.php" style="color: aliceblue">Login</a>
        </button>
      </div>
    </header>
    <section class="page active" id="Home">
      <img src="./images/4.png" alt="IMAGE"/>
      <section class="hero">
        
        <h2>Fitness and nutrition for Kids</h2>
        <p>
          GrowRight personalizes routines and daily intake by age group. Users
          have full control over who can view their details and can grant
          specialists secure access.
        </p>
        <button class="btn btn-fill">Get started</button>
        <button class="btn btn-outline">Learn about privacy</button>

        <div class="info-boxes">
          <div class="info-box">
            <h3>Fun Workouts</h3>
            <p>short,playful sessions that build</p>
            <p>strength,balance and coordination</p>
          </div>
          <div class="info-box">
            <h3>Kids-Approved Meals</h3>
            <p>Simple,colorful recipes</p>
            <p>even picky eaters can enjoy</p>
          </div>
          <div class="info-box">
            <h3>Healthy Habits</h3>
            <p>Mindful eating,Hydration,and</p>
            <p>sleep mode easy.</p>
          </div>
        </div>
      </section>

      <section class="programs">
        <h2>Age-specific programs</h2>
        <p>
          Each group gets tailored routines and nutrition guidance designed by
          specialists.
        </p>
      </section>
      <section class="programs">
        <div class="cards">
          <div class="card">
            <h3>Mini Movers</h3>
            <p>Ages 3-5</p>
            <ul>
              <li>Animal walks</li>
              <li>Rainbow snacks</li>
              <li>Parent oversight</li>
            </ul>
            <button class="explore">Explore plans</button>
          </div>
          <div class="card">
            <h3>Power Players</h3>
            <p>Ages 6-9</p>
            <ul>
              <li>Balance & Agility</li>
              <li>Meal plans by goal</li>
              <li>Hydration goals</li>
            </ul>
            <button class="explore">Explore plans</button>
          </div>
          <div class="card senior">
            <h3>Future Champs</h3>
            <p>Ages 10-13</p>
            <ul>
              <li>Strength & Stamina</li>
              <li>Smart swaps</li>
              <li>Confidence</li>
            </ul>
            <button class="explore">Explore plans</button>
          </div>
        </div>
      </section>
      <div class="lead">
        <h2>Nutrition that kids love</h2>
      </div>
      <section class="tips-section">
        <div class="card tip">
          <span class="label">Tip</span>
          <h3>Rainbow Plates</h3>
          <p>Fill half the plate with colorful fruits and veggies.</p>
        </div>

        <div class="card snack">
          <span class="label">Snack</span>
          <h3>Snack Smart</h3>
          <p>Pair protein + fiber for steady energy.</p>
        </div>

        <div class="card hydrate">
          <span class="label">Hydrate</span>
          <h3>Water First</h3>
          <p>Make water the go-to drink between meals.</p>
        </div>
      </section>
      <section class="features">
        <div class="feature">
          <h3>Progress Tracking</h3>
          <p>
            Track your child’s workouts, meals, hydration, and improvements over
            time in a fun way.
          </p>
        </div>
        <div class="feature">
          <h3>Fun Activities</h3>
          <p>
            Enjoy age-based physical exercises and mental games that make
            fitness playful and engaging.
          </p>
        </div>
        <div class="feature">
          <h3>Healthy Habits</h3>
          <p>
            Learn and follow daily routines like mindful eating, hydration, and
            sleep to grow strong and healthy.
          </p>
        </div>
      </section>

      <section class="testimonial-slider">
        <div class="slider-track">
          <div class="testimonial">
            “My 7-year-old asks for the rainbow plate game every night. He’s
            trying new foods!” <br /><span>— Priya, parent</span>
          </div>
          <div class="testimonial">
            “Short, silly workouts that our whole family enjoys. We look forward
            to it!” <br /><span>— Marco, parent</span>
          </div>
          <div class="testimonial">
            “My daughter drinks more water now because of the water first rule.”
            <br /><span>— Sarah, parent</span>
          </div>
          <div class="testimonial">
            “Healthy snacking tips made lunch packing so much easier!”
            <br /><span>— John, parent</span>
          </div>
          <div class="testimonial">
            “The rainbow plate idea made veggies fun again.” <br /><span
              >— Anita, parent</span
            >
          </div>
          <div class="testimonial">
            “My 7-year-old asks for the rainbow plate game every night. He’s
            trying new foods!” <br /><span>— Priya, parent</span>
          </div>
          <div class="testimonial">
            “Short, silly workouts that our whole family enjoys. We look forward
            to it!” <br /><span>— Marco, parent</span>
          </div>
        </div>
      </section>

      <footer class="footer">
        <div class="footer-col">
          <h4>GrowRight</h4>
          <p>Personalized fitness and nutrition for every age group.</p>
        </div>
        <div class="footer-col">
          <h4>Product</h4>
          <ul>
            <li><a href="login.php">Routines</a></li>
            <li><a href="login.php">Nutrition</a></li>
          </ul>
        </div>
        <div class="footer-col">
          <h4>Company</h4>
          <ul>
            <li><a href="#about" class="nav_link">About</a></li>
            <li><a href="#privacy" class="nav_link">Privacy</a></li>
          </ul>
        </div>
        <div class="footer-col">
          <h4>Contact</h4>
          <a href="#">growright@gmail.com</a>
        </div>
      </footer>
    </section>
    <section id="services" class="page" style="display: none">
      <div class="block"></div>
      <div class="container">
        <h2>Our Services</h2>
      </div>
      <div class="info">
        <p>
          GrowRight offers fun and healthy activities for kids to stay active,
          eat well, and develop good habits.
        </p>

        <ul class="services-list">
          <li>
            <strong>Physical Activities:</strong> age-based exercises like
            animal walks, balance games, and playful workouts.
          </li>
          <li>
            <strong>Mental Activities:</strong> focus games, mindfulness, and
            creativity challenges to keep kids sharp.
          </li>
          <li>
            <strong>Diet Plans:</strong> meals suggested according to the
            child’s region, with preparation steps and nutrition details.
          </li>
          <li>
            <strong>Nutrition & Calories:</strong> every meal shows proteins,
            vitamins, carbs, and calorie intake tailored for different ages.
          </li>
          <li>
            <strong>Healthy Habits:</strong> hydration, mindful eating, and
            sleep routines made fun and easy for kids.
          </li>
        </ul>
      </div>
    </section>

    <section id="contact" class="page" style="display: none">
      <div class="block"></div>
      <div class="container">
        <h2>Contact Us</h2>
      </div>
      <div class="info">
        <p>
          Have questions, feedback, or suggestions? Parents can always reach out
          to us – we’d love to hear from you!
        </p>

        <div class="email-box">
          <strong>Email:</strong>
          <a href="mailto:growright@gmail.com">growright@gmail.com</a>
        </div>
      </div>
    </section>

    <section id="privacy" class="page" style="display: none">
      <div class="block"></div>
      <div class="container">
        <h2>Privacy Policy</h2>
      </div>
      <div class="info">
        <p>
          At GrowRight, children’s safety and privacy always come first. We make
          sure kids’ information stays secure and only parents control what is
          shared.
        </p>

        <h3>Our Privacy Promise:</h3>
        <ul class="privacy-list">
          <li>
            <strong>Safe Data:</strong> All personal details like age,
            preferences, or routines are stored securely.
          </li>
          <li>
            <strong>Parental Control:</strong> Parents decide what information
            is shared, and nothing is made public without permission.
          </li>
          <li>
            <strong>No Advertising:</strong> GrowRight never uses kids’ data for
            advertising.
          </li>
          <li>
            <strong>Consent First:</strong> Any activity or data sharing happens
            only with parental consent.
          </li>
        </ul>

        <p class="goal">
          <strong>Our Goal:</strong> To create a fun, safe, and trustworthy
          environment where kids can enjoy learning about health and fitness
          without worrying about their privacy.
        </p>
      </div>
    </section>

    <section id="about" class="page" style="display: none">
      <div class="block"></div>
      <div class="container">
        <h2>About GrowRight</h2>
      </div>
      <div class="info">
        <p>
          GrowRight is a safe and playful platform made especially for kids to
          grow strong, active, and healthy. We combine fun physical and mental
          activities with balanced diet plans to support children’s all-round
          development.
        </p>

        <h3>What we offer:</h3>
        <ul class="info-list">
          <li>
            <strong>Physical Activities:</strong> age-based exercises like
            animal walks, balance games, and playful workouts.
          </li>
          <li>
            <strong>Mental Activities:</strong> focus games, mindfulness, and
            creativity challenges to keep kids sharp.
          </li>
          <li>
            <strong>Diet Plans:</strong> meals are suggested according to the
            user’s region/area, making food choices familiar and easy to follow.
          </li>
          <li>
            <strong>Nutrition Details:</strong> every meal comes with its
            nutritional values (proteins, vitamins, carbs) and calorie intake
            tailored for different age groups.
          </li>
        </ul>

        <p class="goal">
          <strong>Our Goal:</strong> To give every child the right mix of fun
          routines, tasty meals, and healthy habits so they can enjoy growing up
          strong – both in body and mind.
        </p>
      </div>
    </section>
    <script src="script.js"></script>
  </body>
</html>
