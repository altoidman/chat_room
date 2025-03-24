<?php
// بدء الجلسة لتمكين الوصول إلى بيانات المستخدم
session_start();
// تضمين الاتصال بقاعدة البيانات من ملف db.php
include("db.php");

// التحقق مما إذا كان المستخدم قد سجل دخوله
if (!isset($_SESSION['user'])) {
   // إذا لم يكن قد سجل دخوله، إعادة توجيه إلى صفحة تسجيل الدخول
   header("Location: login.php");
   exit();
}

// التحقق مما إذا كانت هناك بيانات مرسلة من خلال POST
if ($_SERVER['REQUEST_METHOD'] == "POST") {
   // تنظيف الرسالة من أي أكواد HTML قد تكون ضارة
   $message = trim(htmlspecialchars($_POST["message"]));

   // إذا كان هناك رد على رسالة سابقة، نقوم بإضافة ذلك إلى الرد
   if (isset($_GET['replay']) && isset($_GET['id'])) {
      $replay = "Reply to: " . htmlspecialchars($_GET['replay']) . " / by id: " . htmlspecialchars($_GET['id']);
   } else {
      // إذا لم يكن هناك رد، يتم تركه فارغاً
      $replay = null;
   }

   // التأكد من أن الرسالة ليست فارغة قبل إدخالها في قاعدة البيانات
   if (empty($message)) {
      echo "Please enter a message."; // رسالة تنبيه للمستخدم
      exit();
   }

   // الحصول على التاريخ والوقت الحاليين
   $date = date('d/m/Y H:i:s');

   // إعداد استعلام لإدخال البيانات في قاعدة البيانات
   $stmt = $conn->prepare("INSERT INTO chat (username, message, replay, `date`) VALUES (:user, :message, :replay, :date)");
   // ربط القيم بالمتحولات
   $stmt->bindParam(":user", $_SESSION['user']);
   $stmt->bindParam(":message", $message);
   $stmt->bindParam(":replay", $replay);
   $stmt->bindParam(":date", $date);

   // تنفيذ الاستعلام لإدخال البيانات
   $stmt->execute();

   // إعادة توجيه المستخدم إلى صفحة الشات بعد إرسال الرسالة
   header("location: index.php");
}

// جلب بيانات المستخدم مثل تاريخ الانضمام وصورة الملف الشخصي
$c = $conn->prepare("SELECT created, img FROM users WHERE username = :user");
$c->bindParam(":user", $_SESSION['user']);
$c->execute();
$done = $c->fetch(PDO::FETCH_ASSOC);
$created = $done['created'];
$img = $done['img'] ?? "de.png";

// جلب جميع الرسائل من قاعدة البيانات بترتيب التاريخ
$stmt = $conn->prepare("SELECT * FROM chat ORDER BY `date` DESC");
$stmt->execute();
$get = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Chat Room</title>
   <link rel="stylesheet" href="chat_style.css">
</head>
<body>
   <div class="container">
      <header>
         <!-- عرض تفاصيل المستخدم مثل الصورة واسم المستخدم -->
         <div class="user-info">
            <img src="profile/<?php echo $img ?>" alt="Profile Image" class="profile-img">
            <div class="user-details">
               <h1><?php echo $_SESSION['user'] ?? "Anonymous"; ?></h1>
               <p>Joined: <?php echo $created; ?></p>
            </div>
         </div>
         <!-- أزرار لتسجيل الخروج وإنشاء حساب جديد -->
         <div class="btn-header">
            <a href="login.php" class="btn">Log Out</a>
            <a href="register.php" class="btn">New Account</a>
         </div>
      </header>
   </div>

   <div class="chat-container">
      <div class="chat-box">
         <!-- عرض جميع الرسائل المرسلة في الشات -->
         <?php foreach ($get as $g) : ?>
            <div class="chat">
               <?php 
               // جلب صورة المستخدم الذي أرسل الرسالة
               $f = $conn->prepare("SELECT img FROM users WHERE username = :user");
               $f->bindParam(":user", $g['username']);
               $f->execute();
               $img = $f->fetch(PDO::FETCH_ASSOC);
               ?>
               <!-- عرض صورة المستخدم مع تفاصيل الرسالة -->
               <img src="profile/<?php echo $img['img'] ?? 'de.png'; ?>" alt="Profile Image" class="profile-img">
               <div class="chat-details">
                  <div>
                     <!-- عرض معرف الرسالة، ورابط الرد على الرسالة -->
                     <b>ID: <?php echo htmlspecialchars($g['id']) ?? "N/A"; ?></b>
                     <a href="index.php?replay=<?php echo htmlspecialchars($g['username']) ?>&id=<?php echo $g['id']; ?>">Reply message!</a>
                     <h3><?php echo htmlspecialchars($g['username']); ?></h3>
                     <p><?php echo htmlspecialchars($g['message']); ?></p>
                  </div>
                  <div class="replay">
                     <!-- عرض تاريخ ووقت إرسال الرسالة -->
                     <p>Sent on: <?php echo $g['date'] ?? date('d/m/Y H:i:s'); ?></p><br/>
                     <!-- إذا كانت هناك ردود، يتم عرضها هنا -->
                     <?php if ($g['replay']) : ?>
                        <p><?php echo htmlspecialchars($g['replay']); ?></p>
                     <?php endif; ?>
                  </div>
               </div>
            </div>
         <?php endforeach; ?>
      </div>
      <p><a href="#">
      <?php
      if(isset($_GET['replay']) && isset($_GET['id'])) {
         $info = "Reply to: </a>" . htmlspecialchars($_GET['replay']) . " - <a href='#'> by id: </a>" . htmlspecialchars($_GET['id']);
      } else {
         $info = null;
      }
      ?>
 <?php echo $info ?? "no Replay null"?></p>
      <!-- نموذج لإرسال رسالة جديدة -->
      <form method="POST" class="chat-form">
         <input type="text" name="message" placeholder="Type your message here..." required>
         <button type="submit">Send</button>
      </form>
   </div>
</body>
</html>
