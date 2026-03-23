<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>System Notatek</title>
    <style>
        body { font-family: sans-serif; max-width: 500px; margin: 20px auto; background: #f4f4f4; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h2 { border-bottom: 2px solid #333; padding-bottom: 10px; }
        .note { background: white; padding: 10px; margin-bottom: 5px; border-left: 5px solid #007bff; }
        .error { color: red; font-weight: bold; }
        .success { color: green; }
        textarea { width: 100%; height: 60px; margin-bottom: 10px; }
        button { cursor: pointer; padding: 10px; border: none; border-radius: 5px; color: white; }
        .btn-add { background: #28a745; }
        .btn-del { background: #dc3545; margin-top: 20px; }
    </style>
</head>
<body>

    <h2>--- SYSTEM NOTATEK ---</h2>

    <?php
    $file = 'notes.txt';

    // 1. DODAWANIE NOTATKI
    if (isset($_POST['add'])) {
        $content = trim($_POST['content']);
        if (!empty($content)) {
            $date = date('Y-m-d H:i:s');
            $entry = "[$date] $content" . PHP_EOL;
            
            if (file_put_contents($file, $entry, FILE_APPEND | LOCK_EX)) {
                echo "<p class='success'>Dodano notatkę!</p>";
            } else {
                echo "<p class='error'>Błąd zapisu! Sprawdź uprawnienia.</p>";
            }
        } else {
            echo "<p class='error'>Wpisz coś najpierw!</p>";
        }
    }

    // 2. USUWANIE WSZYSTKICH NOTATEK
    if (isset($_POST['clear'])) {
        if (file_exists($file)) {
            unlink($file);
            echo "<p class='success'>Wszystkie notatki usunięte!</p>";
        }
    }
    ?>

    <form method="post">
        <textarea name="content" placeholder="Treść notatki..."></textarea><br>
        <button type="submit" name="add" class="btn-add">1. Dodaj nową notatkę</button>
    </form>

    <h3>2. Wyświetl wszystkie notatki:</h3>
    <div>
        <?php
        if (file_exists($file) && filesize($file) > 0) {
            $notes = file($file);
            foreach ($notes as $index => $line) {
                echo "<div class='note'><strong>" . ($index + 1) . ".</strong> " . htmlspecialchars($line) . "</div>";
            }
        } else {
            echo "<p>Brak notatek lub plik nie istnieje.</p>";
        }
        ?>
    </div>

    <form method="post" onsubmit="return confirm('Na pewno usunąć wszystko?');">
        <button type="submit" name="clear" class="btn-del">3. Usuń wszystkie notatki</button>
    </form>

    <p><small>4. Aby zakończyć, po prostu zamknij kartę w przeglądarce.</small></p>

</body>
</html>