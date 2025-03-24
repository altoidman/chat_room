<?php
// تضمين الاتصال بقاعدة البيانات
include("db.php");

// التحقق من إذا كان الطلب هو POST
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // تنظيف المدخلات
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);
    $confirm = htmlspecialchars($_POST['confirm']);
	 $date = date('d/m/Y H:i:s');
    // التحقق من إذا تم رفع صورة
    if (!empty($_FILES['img']['name'])) {
        $file = $_FILES['img']['name'];
        $tmp = $_FILES['img']['tmp_name'];
        // الحصول على امتداد الصورة
        $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        // تحديد الامتدادات المسموح بها
        $allowed_exts = ['jpg', 'jpeg', 'png', 'gif'];

        // التحقق من امتداد الصورة
        if (in_array($ext, $allowed_exts)) {
            // إنشاء اسم عشوائي للصورة
            $img = bin2hex(random_bytes(7)) . ".$ext";
            // نقل الصورة إلى المجلد المحدد
            if (!move_uploaded_file($tmp, "profile/$img")) {
                die("❌ Error uploading image!");
            }
        } else {
            die("❌ Image not allowed! Only JPG, JPEG, PNG, GIF are accepted.");
        }
    } else {
        // إذا لم يتم رفع صورة، تعيين صورة افتراضية
        $img = null;
    }

    // التحقق من تطابق كلمة المرور
    if ($password === $confirm && !empty($username) && !empty($password)) {
        // تشفير كلمة المرور
        $hash = password_hash($password, PASSWORD_BCRYPT);

        // إدخال البيانات في قاعدة البيانات
        $stmt = $conn->prepare("INSERT INTO users (username, password, img, created) VALUES (:username, :password, :img, :created)");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $hash);
        $stmt->bindParam(':img', $img);
        $stmt->bindParam(':created', $date);
        $stmt->execute();
        
        // إعادة توجيه إلى صفحة تسجيل الدخول
        header('location: login.php');
        exit();
    } else {
        // عرض رسالة خطأ إذا كانت كلمات المرور لا تتطابق أو الحقول فارغة
        echo "<p style='color:red;'>❌ Passwords do not match or fields are empty!</p>";
    }
}
?>

<!-- نموذج التسجيل -->
<form method="POST" enctype="multipart/form-data">
    <h1>Register page</h1>
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <input type="password" name="confirm" placeholder="Confirm Password" required>
    <input type="file" name="img">
    <button type="submit">Register</button>
</form>
