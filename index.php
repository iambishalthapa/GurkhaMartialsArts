<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Your Company Name</title>
<link rel="stylesheet" href="style.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/fetch/3.0.0/fetch.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v17.0" nonce="4Sf6ljZI"></script>
<style>
  .features-section {
    text-align: center;
    padding: 20px;
  }

  .features-heading {
    font-size: 40px;
    margin-bottom: 20px;
    color:white;
  }

  .features-container {
    display: flex;
    justify-content: space-between;
    border: 1px solid red;
    padding: 20px;
  }

  .feature-box {
    text-align: center;
  }

  .feature-icon {
    font-size: 36px;
    margin-bottom: 10px;
  }

  .feature-name {
    font-size: 18px;
    color: white;
  }
</style>
</head>
<body>
<?php
include 'menubar.php';
?>
  <div class="video-container">
    <div class="video-wrapper">
      <video autoplay muted loop height="315">
        <source src="videos/Training Motivation MMA & Muay Thai.mp4" type="video/mp4">
        Your browser does not support the video tag.
      </video>
    </div>
    <div class="video-wrapper">
      <video autoplay muted loop height="315">
        <source src="videos/TaeKwonDo Promotional Video _ 2017.mp4" type="video/mp4">
        Your browser does not support the video tag.
      </video>
    </div>
  </div>

  <div class="join-section">
    <h2 class="join-heading">Join for Free</h2>
    <p class="join-text">Unlock amazing content and receive a special discount today!</p>
    <div class="discount-grab" onclick="openLoginModal()">Grab your discount</div>

  </div>
  <div class="ourprogram" id="program-section">
    <h1 class="program-heading">Our Program</h1>
    <div class="program-container">
        <section class="program-section">
            <img class="program-icon" src="photos/Kids-Martial-Arts.jpg" alt="Icon">
            <h4 class="program-title">Kids Jiu-Jitsu, Judo</h4>
        </section>
        <section class="program-section">
            <img class="program-icon" src="photos/kidkarate.jpg" alt="Icon">
            <h4 class="program-title">Karate</h4>
        </section>
        <section class="program-section">
            <img class="program-icon" src="photos/karate-student.jpg " alt="Icon">
            <h4 class="program-title" style="
    margin-right: 5px;
    margin-left: 5px;
">Openmat/Personal Practice</h4>
        </section>
        <section class="program-section">
            <img class="program-icon" src="photos/adult-martial-arts-3.jpg" alt="Icon">
            <h4 class="program-title">Private Tution</h4>
        </section>
        <section class="program-section">
            <img class="program-icon" src="photos/220px-Muay_Thai_Fight_Us_Vs_Burma_(80668065).jpeg" alt="Icon">
            <h4 class="program-title">Muay Thai</h4>
        </section>
 </div>
 <a id="membership-section"></a>
 <h1 class="program-heading">Subscription Plan</h1>
 <div class="package-container">
    <div class="package">
        <h2>Basic</h2>
        <p>1 martial art – 2 sessions per week</p>
        <?php if (isset($_SESSION["user_email"])): ?>
            <form class="package-form" id="basic-plan-form" method="post" action="process_purchase.php">
                <input type="hidden" name="user_email" value="<?php echo $_SESSION['user_email']; ?>">
                <input type="hidden" name="package_name" value="Basic">
                <input type="hidden" name="description" value="1 martial art – 2 sessions per week">
                <label for="basic-plan-start-date">Start Date:</label>
                <input type="date" id="start-date"  id="basic-plan-start-date" name="Basic-start-date" required>
                <label for="sessions-per-week">Number of Sessions Per Week:</label>
                <input type="text" id="sessions-per-week" name="sessions-per-week" value="2" readonly>
                <input type="hidden" id="Basic-total-price" name="Basic-total-price" value="15.00">
                <p>Total Price: £<span id="Basic-total-price">25.00</span>/ Month</p>
                <button type="submit" class="package-button">Purchase</button>
                <div class="purchase-message" id="<?php echo $package_name; ?>-message"></div>
            </form>
        <?php else: ?>
            <button class="checksbtn" type="button" onclick="showRegistrationModal()">Check</button>
        <?php endif; ?>
    </div>
  

    <div class="package">
        <h2>Private Martial Arts Tuition</h2>
        <p>One-on-one instruction with a skilled instructor</p>
        <form class="package-form" id="private-tuition-form" method="post" action="process_purchase.php">
            <?php if (isset($_SESSION["user_email"])): ?>
                <input type="hidden" name="user_email" value="<?php echo $_SESSION['user_email']; ?>">
                <input type="hidden" name="package_name" value="Private Martial Arts Tuition">
                <input type="hidden" name="description" value="One-on-one instruction with a skilled instructor">
                <label for="private-tuition-start-date">Start Date:</label>
                <input type="date" id="private-tuition-start-date" name="private-tuition-start-date" required>
                <label for="hours-per-day">Number of Hours Per Day:</label>
                <input type="number" id="hours-per-day" name="hours-per-day" min="1" value="1" required>
                <p>Total Price: £<span id="private-tuition-total-price">15.00</span>/Hr/30 Day</p>
                <input type="hidden" id="private-tuition-total-price-input" name="private-tuition-total-price">
                <button type="submit" class="package-button">Purchase</button>
                <div class="purchase-message" id="<?php echo $package_name; ?>-message"></div>
            <?php else: ?>
                <button class="checksbtn" type="button" onclick="showRegistrationModal()">Check</button>
            <?php endif; ?>
        </form>
    </div>

    <div class="plan specialist-course">
    <h2>Specialist Course</h2>
    <p>Six-week beginners’ self-defence course (2 × 1-hour session per week)</p>
    <form  class="package-form" id="specialist-course-form" class="extra-options" method="post" action="process_purchase.php">
    <?php if (isset($_SESSION["user_email"])): ?>
    <input type="hidden" name="user_email" value="<?php echo $_SESSION['user_email']; ?>">
        <input type="hidden" name="package_name" value="Specialist Course">
        <input type="hidden" name="description" value="Six-week beginners’ self-defence course (2 × 1-hour session per week)">
        <label for="specialist-course-start-date">Start Date:</label>
        <input type="date" id="start-date"  id="specialist-course-start-date" name="specialist-course-start-date" required>
        <button id="toggle-extra-options-button" class="package-button" type="button">Extra Service</button>

        <div id="extra-options" class="extra-options" style="display: none;">
            <div class="checkbox-label">
                <input type="checkbox" id="fitness-room" name="fitness-room" value="fitness-room">
                <label for="fitness-room">Use of fitness room – £6.00 per visit</label>
            </div>
            <input type="number" id="fitness-room-count" name="fitness-room-count" min="1" value="1" disabled>
            <div class="checkbox-label">
                <input type="checkbox" id="personal-fitness" name="personal-fitness" value="personal-fitness">
                <label for="personal-fitness">Personal fitness training – £35.00 per hour</label>
            </div>
            <input type="number" id="personal-fitness-hours" name="personal-fitness-hours" min="1" value="1" disabled>
        </div>

        <input type="hidden" id="specialist-course-total-price" name="specialist-course-total-price" value="180.00">
        <p>Total Price: £<span id="display-specialist-course-total-price">180.00</span></p>
        <button type="submit" class="package-button">Purchase</button>
        <div class="purchase-message" id="<?php echo $package_name; ?>-message"></div>

    </form>
    <?php else: ?>
      <button class="checksbtn" type="button" onclick="showRegistrationModal()">Check</button>
    <?php endif; ?>
    </div>

    <div class="package">
        <h2>Intermediate</h2>
        <p>1 martial art – 3 sessions per week</p>
        <form class="package-form" id="intermediate-plan-form" method="post" action="process_purchase.php">
            <?php if (isset($_SESSION["user_email"])): ?>
                <input type="hidden" name="user_email" value="<?php echo $_SESSION['user_email']; ?>">
                <input type="hidden" name="package_name" value="Intermediate">
                <input type="hidden" name="description" value="1 martial art – 3 sessions per week">
                <label for="intermediate-plan-start-date">Start Date:</label>
                <input type="date" id="start-date"  id="intermediate-plan-start-date" name="intermediate-plan-start-date" required>
                <label for="sessions-per-week">Number of Sessions Per Week:</label>
                <input type="text" id="sessions-per-week" name="sessions-per-week" value="3" readonly>
                <p>Total Price: £<span id="intermediate-plan-total-price">35.00</span>/ Month</p>
                <button type="submit" class="package-button">Purchase</button>
                <div class="purchase-message" id="<?php echo $package_name; ?>-message"></div>
            <?php else: ?>
                <button class="checksbtn" type="button" onclick="showRegistrationModal()">Check</button>
            <?php endif; ?>
        </form>
    </div>

    <div class="package">
        <h2>Advanced</h2>
        <p>Any 2 martial arts – 5 sessions per week</p>
        <form class="package-form" id="advanced-plan-form" method="post" action="process_purchase.php">
            <?php if (isset($_SESSION["user_email"])): ?>
                <input type="hidden" name="user_email" value="<?php echo $_SESSION['user_email']; ?>">
                <input type="hidden" name="package_name" value="Advanced">
                <input type="hidden" name="description" value="Any 2 martial arts – 5 sessions per week">
                <label for="advanced-plan-start-date">Start Date:</label>
                <input type="date" id="start-date"  id="advanced-plan-start-date" name="advanced-plan-start-date" required>
                <label for="sessions-per-week">Number of Sessions Per Week:</label>
                <input type="text" id="sessions-per-week" name="sessions-per-week" value="5" readonly>
                <p>Total Price: £<span id="advanced-plan-total-price">45.00</span>/ Month</p>
                <button type="submit" class="package-button">Purchase</button>
                <div class="purchase-message" id="<?php echo $package_name; ?>-message"></div>
            <?php else: ?>
                <button class="checksbtn" type="button" onclick="showRegistrationModal()">Check</button>
            <?php endif; ?>
        </form>
    </div>

    <div class="package">
        <h2>Elite</h2>
        <p>Unlimited Classes</p>
        <form class="package-form" id="elite-plan-form" method="post" action="process_purchase.php">
            <?php if (isset($_SESSION["user_email"])): ?>
                <input type="hidden" name="user_email" value="<?php echo $_SESSION['user_email']; ?>">
                <input type="hidden" name="package_name" value="Elite">
                <input type="hidden" name="description" value="Unlimited Classes">
                <label for="elite-plan-start-date">Start Date:</label>
                <input type="date" id="start-date"  id="elite-plan-start-date" name="elite-plan-start-date" required>
                <label for="unlimited-sessions">Unlimited Sessions:</label>
                <input type="text" id="sessions-per-week" name="sessions-per-week" value="1" readonly>
                <p>Total Price: £<span id="elite-plan-total-price">60.00</span>/ Month</p>
                <button type="submit" class="package-button">Purchase</button>
                <div class="purchase-message" id="<?php echo $package_name; ?>-message"></div>
            <?php else: ?>
                <button class="checksbtn" type="button" onclick="showRegistrationModal()">Check</button>
            <?php endif; ?>
        </form>
    </div>

    <div class="package">
        <h2>Junior Membership</h2>
        <p>Can attend all-kids martial arts sessions</p>
        <form class="package-form" id="junior-membership-form" method="post" action="process_purchase.php">
            <?php if (isset($_SESSION["user_email"])): ?>
                <input type="hidden" name="user_email" value="<?php echo $_SESSION['user_email']; ?>">
                <input type="hidden" name="package_name" value="Junior Membership">
                <input type="hidden" name="description" value="Can attend all-kids martial arts sessions">
                <label for="junior-membership-start-date">Start Date:</label>
                <input type="date" id="start-date"  id="junior-membership-start-date" name="junior-membership-start-date" required>
                <label for="accesstojs">Access to Junior classes:</label>
                <input type="text" id="sessions-per-week" name="sessions-per-week" value="1" readonly>
                <p>Total Price: £<span id="junior-membership-total-price">25.00</span>/ Month</p>
                <button type="submit" class="package-button">Purchase</button>
                <div class="purchase-message" id="<?php echo $package_name; ?>-message"></div>
            <?php else: ?>
                <button class="checksbtn" type="button" onclick="showRegistrationModal()">Check</button>
            <?php endif; ?>
        </form>
    </div>
</div>
<div class="features-section">
    <h2 class="features-heading">Our Features</h2>
    <div class="features-container">
      <div class="feature-box">
        <div class="feature-icon"><img src="photos/icons8-wrestling-50.png" alt="largemartialarts" ></div>
        <div class="feature-name">Large Martial Arts Area</div>
      </div>
      <div class="feature-box">
        <div class="feature-icon"><img src="photos/icons8-gym-50.png" alt="gym" ></div>
        <div class="feature-name">Fully-equipped Gym</div>
      </div>
      <div class="feature-box">
        <div class="feature-icon"><img src="photos/iconssauna.png" alt="sauna" ></div>
        <div class="feature-name">Sauna</div>
      </div>
      <div class="feature-box">
        <div class="feature-icon"><img src="photos/icons8-room-64.png" alt="steamroom" width="54px" ></div>
        <div class="feature-name">Steam Room</div>
      </div>
      <div class="feature-box">
        <div class="feature-icon"><img src="photos/icons8-shower-50.png" alt="sauna" ></div>
        <div class="feature-name">Changing & Shower Facilities</div>
      </div>
    </div>
  </div>
  

<a id="timetable-section"></a>
    <div class="timetable-container">
        <h1 class="program-heading"id="mytimetable">Martial Arts Class Timetable</h1>
        <table class="timetable">
          <tr>
            <th class="time-column">Time</th>
            <th class="day-column">Monday</th>
            <th class="day-column">Tuesday</th>
            <th class="day-column">Wednesday</th>
            <th class="day-column">Thursday</th>
            <th class="day-column">Friday</th>
            <th class="day-column">Saturday</th>
            <th class="day-column">Sunday</th>
          </tr>
          <tr>
            <td>06:00–07:30</td>
            <td>Jiu-jitsu</td>
            <td>Karate</td>
            <td>Judo</td>
            <td>Jiu-jitsu</td>
            <td>Muay Thai</td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td>08:00–10:00</td>
            <td>Muay Thai</td>
            <td>Private tuition</td>
            <td>Private tuition</td>
            <td>Private tuition</td>
            <td>Jiu-jitsu</td>
            <td>Private tuition</td>
            <td>Private tuition</td>
          </tr>
          <tr>
            <td>10:30–12:00</td>
            <td>Private tuition</td>
            <td>Private tuition</td>
            <td>Private tuition</td>
            <td>Private tuition</td>
            <td>Private tuition</td>
            <td>Judo</td>
            <td>Karate</td>
          </tr>
          <tr>
            <td>13:00–14:30</td>
            <td>Open mat/ personal practice</td>
            <td>Open mat/ personal practice</td>
            <td>Open mat/ personal practice</td>
            <td>Open mat/ personal practice</td>
            <td>Open mat/ personal practice</td>
            <td>Karate</td>
            <td>Judo</td>
          </tr>
          <tr>
            <td>15:00–17:00</td>
            <td>Kids Jiu-jitsu</td>
            <td>Kids Judo</td>
            <td>Kids Karate</td>
            <td>Kids Jiu-jitsu</td>
            <td>Kids Judo</td>
            <td>Muay Thai</td>
            <td>Jiu-jitsu</td>
          </tr>
          <tr>
            <td>17:30–19:00</td>
            <td>Karate</td>
            <td>Muay Thai</td>
            <td>Judo</td>
            <td>Jiu-jitsu</td>
            <td>Muay Thai</td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td>19:00–21:00</td>
            <td>Jiu-jitsu</td>
            <td>Judo</td>
            <td>Jiu-jitsu</td>
            <td>Karate</td>
            <td>Private tuition</td>
            <td></td>
            <td></td>
          </tr>
        </table>
      </div>
      <div class="instructors-container">
    <h1 class="program-heading">Our Instructor Details</h1>
    <div class="instructor-list">
        <div class="instructor">
            <img src="photos/instructor1.jpg.jpg" alt="Instructor 1">
            <div>
                <h3>Thomas Cook</h3>
                <p>Gym Owner / Head Martial Arts Coach</p>
                <div class="rating">★★★★☆</div>
            </div>
            <button class="showourdetails">Details</button>
            <div class="details">
                <p>Thomas Cook is an experienced martial artist and gym owner. With extensive training and expertise in multiple martial arts disciplines, he leads the way in providing high-quality instruction...</p>
            </div>
        </div>
        <div class="instructor">
            <img src="photos/instructor2.jpg" alt="Instructor 2">
            <div>
                <h3>Andrew Smith</h3>
                <p>Assistant Martial Arts Coach</p>
                <div class="rating">★★★★☆</div>
            </div>
            <button class="showourdetails">Details</button>
            <div class="details">
                <p>Andrew Smith is a dedicated assistant martial arts coach with a strong background in karate. He has achieved a 5th Dan black belt and is committed to helping students develop their skills...</p>
            </div>
        </div>
        <div class="instructor">
            <img src="photos/instructor3.jpg" alt="Instructor 3">
            <div>
                <h3>Powel Johnson</h3>
                <p>Assistant Martial Arts Coach</p>
                <div class="rating">★★★★☆</div>
            </div>
            <button class="showourdetails">Details</button>
            <div class="details">
                <p>Powel Johnson is a skilled assistant martial arts coach specializing in jiu-jitsu and judo. With a 2nd Dan black belt in jiu-jitsu and a 1st Dan black belt in judo, he brings a unique blend of techniques...</p>
            </div>
        </div>
        <div class="instructor">
            <img src="photos/instructor4.jpg" alt="Instructor 4">
            <div>
                <h3>Harris William</h3>
                <p>Assistant Martial Arts Coach</p>
                <div class="rating">★★★★☆</div>
            </div>
            <button class="showourdetails">Details</button>
            <div class="details">
                <p>Harris William is a highly regarded assistant martial arts coach, holding an accreditation as a Muay Thai coach. He also boasts a 3rd Dan black belt in karate...</p>
            </div>
        </div>
        <div class="instructor">
            <img src="photos/instructor5.jpg" alt="Instructor 5">
            <div>
                <h3>Joseph Anderson</h3>
                <p>Fitness Coach</p>
                <div class="rating">★★★★☆</div>
            </div>
            <button class="showourdetails">Details</button>
            <div class="details">
                <p>Joseph Anderson is a dedicated fitness coach with a strong academic background in Sports Science. His expertise lies in devising tailored strength and conditioning programs...</p>
            </div>
        </div>
        <div class="instructor">
            <img src="photos/instructor6.jpg" alt="Instructor 6">
            <div>
                <h3>Allen Murphy</h3>
                <p>Fitness Coach</p>
                <div class="rating">★★★★☆</div>
            </div>
            <button class="showourdetails">Details</button>
            <div class="details">
                <p>Allen Murphy is a highly educated fitness coach, holding both a BSc in Physiotherapy and an MSc in Sports Science. His diverse knowledge enables him to...</p>
            </div>
        </div>
        <!-- Add more instructors with similar structure -->
    </div>
</div>

      <div class="about-container" id="about-section">
        <div class="about-header">
          <h1 style="font-size: 40px;">About Us</h1>
          <p>We are a dedicated martial arts academy committed to providing top-quality training and guidance to our students.</p>
        </div>
        <div class="about-content">
          <div class="about-text">
            <h2>Our Mission</h2>
            <p>Our mission is to empower individuals through martial arts, promoting physical fitness, mental strength, and personal growth. We strive to create a supportive and inclusive community where everyone can achieve their goals.</p>
          </div>
          <div class="about-photos">
            <div class="about-photo">
              <img src="photos/photos1.jpg" alt="Photo 1">
            </div>
            <div class="about-photo">
              <img src="photos/photos2.jpg" alt="Photo 2">
            </div>
            <div class="about-photo">
              <img src="photos/photos3.jpg" alt="Photo 3">
            </div>
            <div class="about-photo">
              <img src="photos/photos4.jpg" alt="Photo 4">
            </div>
    </div>
  </div>
</div>
  </div>
  

<h1 class="testimonial-headings">Gurkha Martial Arts Testimonials</h1>
<div class="testimonial-container">
    <div class="testimonial">
      <p class="comment">
        "I joined the martial arts program and it has been an incredible journey. The trainers are dedicated and supportive, and the training environment is top-notch."
      </p>
      <div class="commentor">
        <img src="photos/photo-1506794778202-cad84cf45f1d.jpg" alt="Commentor 1">
        <p class="name">John Doe</p>
      </div>
    </div>
    <div class="testimonial">
      <p class="comment">
        "The martial arts classes have greatly improved my discipline, focus, and self-confidence. It's not just a workout, it's a way of life."
      </p>
      <div class="commentor">
        <img src="photos/download (1).jpg" alt="Commentor 2">
        <p class="name">Jane Smith</p>
      </div>
    </div>
    <div class="testimonial">
      <p class="comment">
        "I've been training here for years and I've seen tremendous growth in my skills and overall fitness. The camaraderie among fellow students is amazing."
      </p>
      <div class="commentor">
        <img src="photos/download (2).jpg" alt="Commentor 3">
        <p class="name">Michael Johnson</p>
      </div>
    </div>
    <div class="testimonial">
      <p class="comment">
        "The instructors are not only skilled martial artists but also great mentors. They truly care about your progress and provide personalized guidance."
      </p>
      <div class="commentor">
        <img src="photos/istockphoto-637919364-612x612.jpg" alt="Commentor 4">
        <p class="name">Emily Williams</p>
      </div>
    </div>
  </div> 
  <div></div>
 <div style="text-align: center;" class="videos">
    <h1 class="testimonial-headings" >Online Videos</h1>
    <iframe width="560" height="315" src="https://www.youtube.com/embed/hihKauEb2sg" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
        <iframe width="560" height="315" src="https://www.youtube.com/embed/vrNnNTOHnz8" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
 </div>
 <a id="contact-section"></a>
<div class="contact-container">
   <div class="social-media">
            <h2 style="color: white;">Social Media</h2>
            <div class="fb-page" data-href="https://www.facebook.com/profile.php?id=100094753437250" data-tabs="timeline" data-width="300" data-height="400px" data-small-header="true" data-adapt-container-width="true" data-hide-cover="true" data-show-facepile="true"><blockquote cite="https://www.facebook.com/profile.php?id=100094753437250" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/profile.php?id=100094753437250">Gurkhamartialarts</a></blockquote></div>
            <div id="space"></div>
            <a class="twitter-timeline" href="https://twitter.com/gorkhamartial?ref_src=twsrc%5Etfw"
              data-width="380px"  
              data-height="290px"> <!-- Adjust the height as needed -->
              Tweets by gorkhamartial
            </a>
            <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
          </div>

          <div class="contact-form">
    <h2 style="color: white;">Contact Us</h2>
    <form id="contact-form" method="post" action="process_form.php" onsubmit="return submitForm();">
        <label class="lbl" for="name">Name:</label>
        <input type="text" id="yourname" name="yourname" style="width: 250px;" required><br>
        <label class="lbl" for="email">Email:</label>
        <input type="email" id="youremail" name="youremail" style="width: 245px;" required><br>
        <label class="lbl" for="subject">Subject:</label>
        <input type="text" id="yoursubject" name="yoursubject" style="width: 250px;" required><br>
        <label class="lbl" for="message">Message:</label>
        <textarea id="yourmessage" name="yourmessage" rows="5" cols="30" style="width: 400px;resize: none;"required></textarea><br>
        <div id="char-count">0/250</div>
        <div id="message-status" style="color: white;"></div>

<!-- This is where you will put your message box and character counter-->
        <input class="btnsubmits" type="submit" value="Submit" style="width: 250px;">
    </form>
    <div id="success-message" style="color: white;"></div>
</div>





        <div class="contact-info">
          <h2 style="color: white;">Contact Information</h2>
          <p>123 Martial Arts Street</p>
          <p>City, State, ZIP</p>
          <p>Phone: 061-127890</p>
          <p>Email: info@martialarts.com</p>
          <iframe src="https://www.google.com/maps/embed?pb=!1m17!1m12!1m3!1d7032.114459592055!2d83.95830202346953!3d28.20557377878067!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m2!1m1!2zMjjCsDEyJzIxLjgiTiA4M8KwNTcnNDAuNCJF!5e0!3m2!1sen!2snp!4v1689471481144!5m2!1sen!2snp" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
      </div>
<div></div>
<footer class="site-footer">
        <div class="footer-content">
            <div class="footer-logo">
                <h1>Gurkha Martial Arts</h1>
                <p>Discover the path of strength and resilience through Gurkha Martial Arts.<br> Join us for holistic training, self-defense, and personal growth.</p>
                <div class="social-icons">
                    <a href="https://www.facebook.com/login/"><img width="48" height="48" src="https://img.icons8.com/color/48/facebook-new.png" alt="facebook-new"/></a>
                    <a href="https://www.instagram.com/accounts/login/"><img width="48" height="48" src="https://img.icons8.com/color/48/instagram-new--v1.png" alt="instagram-new--v1"/></a>
                </div>
            </div>
            <div class="footer-links">
            <a href="#about-section">About Us</a>

                <a href="privacypolicy.php">Privacy Policy</a>
            </div>
        </div>
        <div class="copyright">
            <p>&copy; 2023 Gurkha Martial Arts. All rights reserved.</p>
        </div>
    </footer>
 <!-- Registration form modal -->
<div id="registration-modal" class="modal">
    <div class="registration-modal-content">
        <span class="close" onclick="closeRegistrationModal()">&times;</span>
        <h2>Register</h2>
        <form id="register-form" action="register.php" method="post" enctype="multipart/form-data">
            <div class="label-input-container">
            <label for="name">Profile Picture:</label>
                <input type="file" id="profile-picture" name="profile_picture" accept="image/*" required>
            </div>
            <div class="label-input-container">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" placeholder="Enter your Name" required>
            </div>
            <div class="label-input-container">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="Enter your Email" required>
            </div>
            <div class="label-input-container">
                <label for="dob">Date of Birth:</label>
                <input type="date" id="dob" name="dob" required>
            </div>
            <div class="label-input-container">
    <label for="password">Password:</label>
    <input type="password" id="register-passwordone" name="password" placeholder="New Password" required>
    <img class="password-toggleone" id="register-password-toggleone" src="photos/hide.png"
         onclick="registerPasswordoneVisibility()" alt="Password Toggle" width="24">
</div>

            <div class="label-input-container">
    <label for="confirm-password">Confirm Password:</label>
    <input type="password" id="register-passwordtwo" name="confirm_password" placeholder="RE-Password" required>
    <img class="password-toggle" id="register-password-toggletwo" src="photos/hide.png"
         onclick="registerPasswordtwoVisibility()" alt="Password Toggle" width="24">
</div>
            <div class="label-input-container">
                <label for="gender">Gender:</label>
                <select id="gender" name="gender" required>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                </select>
                <img id="arrow" src="photos/down-arrow.png" alt="" width="24">
            </div>
            <div id="error-messages" class="error-messages"></div>

            <button type="submit" id="register-button">Register</button>

        </form>
    </div>
</div>

<!-- login model  -->
<!-- Login form modal -->
<!-- Login form modal -->
<div id="login-modal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeLoginModal()">&times;</span>
        <h2>Login</h2>
        <form id="login-form" action="login.php" method="post" enctype="multipart/form-data">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Enter your Email" required><br>

    <div class="form-group password-wrapper">
        <label for="login-password">Password</label>
        <input type="password" id="login-password" name="password" placeholder="Enter your password" required>
       <img class="password-toggle" id="login-password-toggle" src="photos/hide.png"
        onclick="toggleLoginPasswordVisibility()" alt="Password Toggle" width="24">
    </div>
     <div id="login-error-messages" class="error-messages"></div>
      <button type="submit" id="login-button">Login</button>
   </form>

        <div class="login-options">
            <a href="#" class="forgot-password"onclick="toggleForgotPassword()">Forgot Password?</a>
            <span class="separator"> | </span>
            <a href="#" class="existing-account" onclick="openRegistrationAndCloseLogin(); return false;">Create an Account?</a>

        </div>
    </div>
</div>
<div class="modal" id="forgotPasswordModal">
    <div class="modal-content">
        <span class="close" onclick="closeForgotPasswordModal()">&times;</span>
        <h2>Forgot Password</h2>
        <form id="forgot-password-form" onsubmit="submitForgotPasswordForm(); return false;" method="post">
            <label for="forgot-email">Email:</label>
            <input type="email" id="forgot-email" name="forgot-email" placeholder="Enter Email" required>

            <label for="new-password">New Password:</label>
            <input type="password" id="forget-passwordone" name="new-password" placeholder="Enter Your New Password" required>
            <img class="password-toggle" id="forget-password-toggleone" src="photos/hide.png"
                 onclick="forgetPasswordoneVisibility('forget-passwordone', 'forget-password-toggleone')"
                 alt="Password Toggle" width="24">

            <label for="confirm-new-password">Confirm Password:</label>
            <input type="password" id="forget-passwordtwo" name="confirm-new-password" placeholder="RE-Password"  required>
            <img class="password-toggle" id="forget-password-toggletwo" src="photos/hide.png"
                 onclick="forgetPasswordtwoVisibility('forget-passwordtwo', 'forget-password-toggletwo')"
                 alt="Password Toggle" width="24">
           
            <button type="submit" id="reset-password-button">Update Password</button>
        </form>
        <!-- Add an empty element to display response messages -->
        <div id="response-message"></div>
    </div>
</div>



























<script>



        // Function to scroll to the "About Us" section just above the heading
        function scrollToAboutUs() {
        const aboutSection = document.getElementById('about-section');
        const heading = document.querySelector('h1');
        const yOffset = -20; // You can adjust this value to fine-tune the scroll position
        const targetY = aboutSection.getBoundingClientRect().top + window.scrollY + yOffset;
        
        window.scrollTo({ top: targetY, behavior: 'smooth' });
    }

    // Add a click event listener to the "About Us" link
    const aboutUsLink = document.querySelector('a[href="#about-section"]');
    aboutUsLink.addEventListener('click', function (e) {
        e.preventDefault(); // Prevent the default link behavior
        scrollToAboutUs();
    });









// Function to update the character count and limit
function updateCharacterCount() {
    var textarea = document.getElementById("yourmessage");
    var countDisplay = document.getElementById("char-count");
    var messageDisplay = document.getElementById("message-status"); // New message display element
    var maxLength = 250;

    var currentLength = textarea.value.length;
    countDisplay.textContent = currentLength + "/" + maxLength;

    // If the character count exceeds the limit, display a warning and prevent typing
    if (currentLength > maxLength) {
      countDisplay.style.color = "red";
      messageDisplay.textContent = "Character limit exceeded!";
      textarea.value = textarea.value.substring(0, maxLength); // Truncate the text
      textarea.setAttribute("readonly", "true"); // Disable further typing
    } else {
      countDisplay.style.color = "black";
      messageDisplay.textContent = ""; // Clear the message
      textarea.removeAttribute("readonly"); // Enable typing
    }
  }

  // Add an event listener to the textarea to update the character count
  document.getElementById("yourmessage").addEventListener("input", updateCharacterCount);

  // Add an event listener to prevent typing when the character limit is reached
  document.getElementById("yourmessage").addEventListener("keypress", function (e) {
    var textarea = e.target;
    var currentLength = textarea.value.length;
    var maxLength = 250;

    if (currentLength >= maxLength) {
      e.preventDefault(); // Prevent further typing
    }
  });

  // Call the function initially to display the count
  updateCharacterCount();



 // Select all input fields with type "text" and a name attribute
 const textInputs = document.querySelectorAll('input[type="text"][name]');

// Add the event listener to each input field
textInputs.forEach(function(input) {
    input.addEventListener('keypress', function (e) {
        // Check if the key pressed is a number (0-9)
        if (/[0-9]/.test(e.key)) {
            e.preventDefault(); // Prevent input of numbers
        }

        // Allow one space character
        if (e.key === ' ' && this.value.includes(' ')) {
            e.preventDefault(); // Prevent input of more than one space
        }
    });
});


const showDetailsButtons = document.querySelectorAll('.showourdetails');
showDetailsButtons.forEach(button => {
  button.addEventListener('click', () => {
    const instructor = button.parentElement;
    instructor.classList.toggle('active');
  });
});
function openRegistrationAndCloseLogin() {
    openRegistrationModal();
    closeloginModal();
}


function openRegistrationModal() {
    var registrationModal = document.getElementById("registration-modal");
    registrationModal.style.display = "block";
}
function toggleForgotPassword() {
        var loginModal = document.getElementById("login-modal");
        var forgotPasswordModal = document.getElementById("forgotPasswordModal");

        loginModal.style.display = "none";
        forgotPasswordModal.style.display = "block";
    }

    function closeForgotPasswordModal() {
    var forgotPasswordModal = document.getElementById("forgotPasswordModal");
    var forgotPasswordForm = document.getElementById("forgot-password-form");
    var loginModal = document.getElementById("login-modal");

    // Reset the form
    forgotPasswordForm.reset();

    // Hide the forgotPasswordModal and show the loginModal
    forgotPasswordModal.style.display = "none";
    loginModal.style.display = "block";
}





document.getElementById('toggle-extra-options-button').addEventListener('click', function() {
  const extraOptions = document.getElementById('extra-options');
  extraOptions.style.display = extraOptions.style.display === 'none' ? 'block' : 'none';
});

document.getElementById('fitness-room').addEventListener('change', function() {
var fitnessRoomCount = document.getElementById('fitness-room-count');
fitnessRoomCount.disabled = !this.checked;
if (!this.checked) {
  fitnessRoomCount.value = "1";
}
});

document.getElementById('personal-fitness').addEventListener('change', function() {
var personalFitnessHours = document.getElementById('personal-fitness-hours');
personalFitnessHours.disabled = !this.checked;
if (!this.checked) {
  personalFitnessHours.value = "1";
}
});


// Function to calculate the total price for Private Martial Arts Tuition


// Function to calculate the total price for Private Martial Arts Tuition
function calculatePrivateTuitionTotalPrice() {
const startDate = new Date(document.getElementById('private-tuition-start-date').value);
const endDate = new Date(startDate);
endDate.setDate(startDate.getDate() + 30); // Set the end date 30 days from the start date
const hoursPerDay = parseInt(document.getElementById('hours-per-day').value);
const hourlyPrice = 15.00;
const days = Math.ceil((endDate - startDate) / (1000 * 60 * 60 * 24));
const totalPrice = hoursPerDay * hourlyPrice * days;

// Update the displayed total price
document.getElementById('private-tuition-total-price').textContent = `${totalPrice.toFixed(2)}`;

// Update the hidden input for total price
document.getElementById('private-tuition-total-price-input').value = totalPrice.toFixed(2);
}

// Event listener to update the total price for Private Martial Arts Tuition
document.getElementById('private-tuition-form').addEventListener('input', calculatePrivateTuitionTotalPrice);

// Function to calculate and set the total price for the Specialist Course package
// Function to calculate and set the total price for the Specialist Course package
function calculateAndSetTotalPrice() {
    const fitnessRoomChecked = document.getElementById('fitness-room').checked;
    const fitnessRoomCount = parseFloat(document.getElementById('fitness-room-count').value);
    const personalFitnessChecked = document.getElementById('personal-fitness').checked;
    const personalFitnessHours = parseFloat(document.getElementById('personal-fitness-hours').value);

    const fitnessRoomPrice = fitnessRoomChecked ? fitnessRoomCount * 6.00 : 0;
    const personalFitnessPrice = personalFitnessChecked ? personalFitnessHours * 35.00 : 0;

    const totalPrice = 180.00 + fitnessRoomPrice + personalFitnessPrice;

    // Set the calculated total price in the hidden input field
    document.getElementById('specialist-course-total-price').value = totalPrice.toFixed(2);

    // Update the displayed total price
    document.getElementById('display-specialist-course-total-price').textContent = `${totalPrice.toFixed(2)}`;
}

// Attach event listeners to checkboxes and input fields
document.getElementById('fitness-room').addEventListener('change', calculateAndSetTotalPrice);
document.getElementById('fitness-room-count').addEventListener('input', calculateAndSetTotalPrice);
document.getElementById('personal-fitness').addEventListener('change', calculateAndSetTotalPrice);
document.getElementById('personal-fitness-hours').addEventListener('input', calculateAndSetTotalPrice);
document.addEventListener("DOMContentLoaded", function () {
    // Select all package forms
    const forms = document.querySelectorAll(".package-form");

    forms.forEach((form) => {
        form.addEventListener("submit", async (event) => {
            event.preventDefault();

            // Submit the form using AJAX
            const formData = new FormData(form);
            const response = await fetch(form.action, {
                method: "POST",
                body: formData,
            });

            if (response.ok) {
                const result = await response.text();
                const messageContainer = form.querySelector(".purchase-message");
                messageContainer.innerHTML = result;
                form.querySelector("#start-date").value = ""
                 // Automatically hide the message after 5 seconds
                 setTimeout(() => {
                    messageContainer.innerHTML = ""; // Clear the message
                }, 5000);
            } else {
                console.error("Error executing form submission.");
            }
        });
    });
});
function submitForgotPasswordForm() {
    // Prevent multiple submissions
    document.getElementById("reset-password-button").disabled = true;

    // Get form data
    var formData = new FormData(document.getElementById("forgot-password-form"));

    // Create and configure the AJAX request
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "forgot_password.php", true);
    xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            var responseMessage = document.getElementById("response-message");

            if (response.success) {
                responseMessage.innerHTML = "<p>Password updated successfully.</p>";
            } else {
                responseMessage.innerHTML = "<p>" + response.message + "</p>";
            }
             // Hide the message after 5 seconds
             setTimeout(function() {
                responseMessage.innerHTML = "";
            }, 5000);
        }
    };

    // Send the AJAX request
    xhr.send(formData);
}

function toggleLoginPasswordVisibility() {
  var passwordField = document.getElementById("login-password");
  var passwordToggle = document.getElementById("login-password-toggle");

  if (passwordField.type === "password") {
    passwordField.type = "text";
    passwordToggle.src = "photos/show.png"; // Replace with the relative path to your show password icon
  } else {
    passwordField.type = "password";
    passwordToggle.src = "photos/hide.png"; // Replace with the relative path to your hide password icon
  }
}
function registerPasswordoneVisibility() {
  var passwordField = document.getElementById("register-passwordone");
  var passwordToggle = document.getElementById("register-password-toggleone");

  if (passwordField.type === "password") {
    passwordField.type = "text";
    passwordToggle.src = "photos/show.png"; // Replace with the relative path to your show password icon
  } else {
    passwordField.type = "password";
    passwordToggle.src = "photos/hide.png"; // Replace with the relative path to your hide password icon
  }
}
function registerPasswordtwoVisibility() {
  var passwordField = document.getElementById("register-passwordtwo");
  var passwordToggle = document.getElementById("register-password-toggletwo");

  if (passwordField.type === "password") {
    passwordField.type = "text";
    passwordToggle.src = "photos/show.png"; // Replace with the relative path to your show password icon
  } else {
    passwordField.type = "password";
    passwordToggle.src = "photos/hide.png"; // Replace with the relative path to your hide password icon
  }
}

function forgetPasswordoneVisibility(passwordFieldId, toggleImageId) {
    var passwordField = document.getElementById(passwordFieldId);
    var passwordToggle = document.getElementById(toggleImageId);

    if (passwordField.type === "password") {
        passwordField.type = "text";
        passwordToggle.src = "photos/show.png"; // Replace with the relative path to your show password icon
    } else {
        passwordField.type = "password";
        passwordToggle.src = "photos/hide.png"; // Replace with the relative path to your hide password icon
    }
}

function forgetPasswordtwoVisibility(passwordFieldId, toggleImageId) {
    var passwordField = document.getElementById(passwordFieldId);
    var passwordToggle = document.getElementById(toggleImageId);

    if (passwordField.type === "password") {
        passwordField.type = "text";
        passwordToggle.src = "photos/show.png"; // Replace with the relative path to your show password icon
    } else {
        passwordField.type = "password";
        passwordToggle.src = "photos/hide.png"; // Replace with the relative path to your hide password icon
    }
}






















// Function to handle form submission
function submitForm() {
    var form = document.getElementById("contact-form");
    var formData = new FormData(form);

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "process_form.php", true);

    // Function to hide a message after a specified time (5 seconds in this case)
    function hideMessage(messageElement) {
        setTimeout(function() {
            messageElement.textContent = "";
        }, 5000);
    }

    // Set up the callback function for when the request completes
    xhr.onload = function () {
        if (xhr.status === 200) {
            // Request was successful, display the success message
            var successMessage = document.getElementById("success-message");
            successMessage.textContent = xhr.responseText;
            
            // Check if the success message indicates success
            if (xhr.responseText.includes("Message saved successfully!")) {
                // Clear input fields
                document.getElementById("yourname").value = "";
                document.getElementById("youremail").value = "";
                document.getElementById("yoursubject").value = "";
                document.getElementById("yourmessage").value = "";
                // Clear character count and set it to 0
                var charCount = document.getElementById("char-count");
                charCount.textContent = "0/250";


                // Hide the success message after 5 seconds
                hideMessage(successMessage);
            } else {
                // Hide error messages after 5 seconds
                hideMessage(successMessage);
            }
        } else {
            // Request failed, display an error message
            var errorMessage = document.getElementById("success-message");
            errorMessage.textContent = "Error occurred while submitting the form.";

            // Hide error messages after 5 seconds
            hideMessage(errorMessage);
        }
    };

    // Send the form data
    xhr.send(formData);

    // Prevent the default form submission
    return false;
}

</script>
<script src="script.js"></script>
</body>
</html>
