<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $name = strip_tags(trim($_POST["name"]));
  $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
  $phone = strip_tags(trim($_POST["phone"] ?? ""));
  $service = strip_tags(trim($_POST["service"] ?? ""));
  $company = strip_tags(trim($_POST["company"] ?? ""));
  $message = strip_tags(trim($_POST["message"]));

  if (empty($name) || empty($email) || empty($message)) {
    echo "Please fill in all required fields.";
    exit;
  }

  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "Invalid email address.";
    exit;
  }

  $to = "info@perfect10.com.ng";
  $subject = "New Inquiry from $name - Perfect10 Website";
  $headers = "From: $name <$email>\r\n";
  $headers .= "Reply-To: $email\r\n";
  $headers .= "MIME-Version: 1.0\r\n";
  $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

  $body = "You have received a new inquiry from your website:\n\n";
  $body .= "Name: $name\n";
  $body .= "Email: $email\n";
  $body .= "Phone: $phone\n";
  if ($company) $body .= "Company: $company\n";
  if ($service) $body .= "Service Needed: $service\n";
  $body .= "Message:\n$message\n";

  if (mail($to, $subject, $body, $headers)) {
    echo "success";
  } else {
    echo "Sorry, something went wrong. Please try again later.";
  }
} else {
  echo "Invalid request.";
}
