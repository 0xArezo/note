<?php
$filename = 'notpes.txt'; // new asave

//read note from file
if (file_exists($filename)) {
    $file = fopen($filename, 'r');
    $content = fread($file, filesize($filename));
    fclose($file);
    $notes = explode("===\n", trim($content)); // جدا کردن یادداشت ها
} else {
    $notes = array();
}

// add new note part2
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['note'])) {
    $note = trim($_POST['note']);
    if ($note !== '') {
        $file = fopen($filename, 'a'); // باز کردن فایل برای نوشتن
        fwrite($file, $note); // متن یادداشت
        if (filesize($filename) > 0) {
            fwrite($file, "\n===\n"); //add seperator
        }
        fclose($file);
        header("Location: index.php"); // برگشت صفحه
        exit();
    }
}

// حذف یادداشت
if (isset($_GET['delete'])) {
    $index = intval($_GET['delete']);
    if (isset($notes[$index])) {
        unset($notes[$index]);
        $file = fopen($filename, 'w'); //  بازنویسی فایل بخش1
        fwrite($file, implode("\n===\n", $notes)); // دوباره ذخیره کردن یادداشت‌ها بدون خط اضافی
        fclose($file);
        header("Location: index.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مدیریت یادداشت‌ها</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body dir="rtl">
<div class="container mt-5">
    <h1 class="text-center mb-4">مدیریت یادداشت‌ها</h1>

    <!-- لیست یادداشت‌ها -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">لیست یادداشت‌ها</h5>
        </div>
        <ul class="list-group list-group-flush">
            <?php foreach ($notes as $index => $note): ?>
                <li class="list-group-item d-flex justify-content-around align-items-center gap-2">
                    <pre class="mb-0"><?= htmlspecialchars($note) ?></pre>
                    <a href="?delete=<?= $index ?>" class="btn btn-danger btn-sm">حذف</a>
                </li>
            <?php endforeach; ?>
            <?php if (empty($notes)): ?>
                <li class="list-group-item text-center text-muted">هنوز یادداشتی اضافه نشده است.</li>
            <?php endif; ?>
        </ul>
    </div>

    <!-- فرم افزودن یادداشت -->
    <div class="card">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0">افزودن یادداشت جدید</h5>
        </div>
        <div class="card-body">
            <form method="post">
                <div class="mb-3">
                    <textarea name="note" class="form-control" rows="4" placeholder="یادداشت خود را وارد کنید"></textarea>
                </div>
                <button type="submit" class="btn btn-primary float-start">افزودن</button>
            </form>
        </div>
    </div>
</div>


</body>
</html>
