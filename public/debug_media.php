<?php
// Clear view cache
$basePath = dirname(__DIR__);
$viewCache = $basePath . '/storage/framework/views';
$count = 0;
if (is_dir($viewCache)) {
    foreach (glob("$viewCache/*.php") as $f) {
        if (basename($f) !== '.gitignore') {
            unlink($f);
            $count++;
        }
    }
}
echo "<p>✅ View cache cleared: <strong>$count files</strong> deleted.</p>";

// Also verify the media path
$storagePub = $basePath . '/storage/app/public';
$dbVal = 'media/kepala-sekolah/2026/02/1027a58b-7f51-4c2b-b839-a6b71e92e40f.png';
$stripped = ltrim(preg_replace('/^(media\/|storage\/)+/', '', $dbVal), '/');

echo "<h2>Media Path Debug</h2>";
echo "<p><strong>DB value:</strong> " . htmlspecialchars($dbVal) . "</p>";
echo "<p><strong>After strip:</strong> " . htmlspecialchars($stripped) . "</p>";

$c1 = $storagePub . '/' . $stripped;
$c2 = $storagePub . '/media/' . $stripped;

echo "<p><strong>Candidate 1:</strong> $c1<br>→ " . (file_exists($c1) ? '<span style="color:green">✅ EXISTS</span>' : '<span style="color:red">❌ NOT FOUND</span>') . "</p>";
echo "<p><strong>Candidate 2:</strong> $c2<br>→ " . (file_exists($c2) ? '<span style="color:green">✅ EXISTS</span>' : '<span style="color:red">❌ NOT FOUND</span>') . "</p>";

echo '<h3>Image via /media/ route:</h3>';
echo '<img src="/media/kepala-sekolah/2026/02/1027a58b-7f51-4c2b-b839-a6b71e92e40f.png" style="max-width:200px; border:3px solid orange;" onerror="this.style.border=\'3px solid red\'; this.alt=\'FAILED - Image not loading\'">';

echo '<h3>Image via /media/media/ route (old double prefix):</h3>';
echo '<img src="/media/media/kepala-sekolah/2026/02/1027a58b-7f51-4c2b-b839-a6b71e92e40f.png" style="max-width:200px; border:3px solid orange;" onerror="this.style.border=\'3px solid red\'; this.alt=\'FAILED\'">';
?>
