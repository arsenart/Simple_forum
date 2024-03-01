<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Student Forum</title>
    <link rel="stylesheet" href="css.css">
</head>

<body>

<?php
if(isset($_COOKIE['user']))
{
    include_once 'header_reg.php';
}
else
{
    include_once 'header.php';
}


?>

<section id="about-us">
    <h2>About Us</h2>
    <p>Welcome to the Student.cz – a place for students to connect, share experiences, and discuss various topics related to education and student life. Our forum is dedicated to fostering a supportive community where students can engage in meaningful conversations and exchange ideas.</p>

    <h3>Our Mission</h3>
    <p>Our mission is to provide a platform for students from different backgrounds and disciplines to come together. We aim to create an inclusive space where everyone feels heard and respected. Whether you're seeking advice, sharing insights, or just looking for a friendly conversation, the Student.cz is here for you.</p>

    <h3>Get Involved</h3>
    <p>Join our community by signing up for an account. Participate in discussions, ask questions, and contribute to the vibrant exchange of ideas. Your unique perspective adds value to our forum, and we look forward to hearing from you.</p>

    <h3>Contact Us</h3>
    <p>If you have any questions or suggestions, feel free to reach out to us. We value your feedback and are dedicated to continuously improving our platform to better serve the student community.</p>

</section>

<?php
include "footer.php"
?>

</body>

</html>
