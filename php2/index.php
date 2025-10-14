<?php
// php2/index.php
// Simple index for listing PHP exercises present in the php2 folder.

$dir = __DIR__;
$items = scandir($dir);

$entries = array_filter($items, function ($name) {
    // Skip current, parent and this index file
    if ($name === '.' || $name === '..' || strtolower($name) === 'index.php') return false;
    return true;
});

// Sort entries naturally
natcasesort($entries);
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>PHP2 — Índice de ejercicios</title>
  <style>
    body{font-family:system-ui,Segoe UI,Roboto,Arial;margin:24px}
    h1{margin-bottom:8px}
    ul{line-height:1.6}
    .meta{color:#666;font-size:0.9em}
  </style>
</head>
<body>
  <h1>PHP2 — Índice de ejercicios</h1>
  <p class="meta">Directorio: <?php echo htmlspecialchars(basename($dir)); ?> — <?php echo date('Y-m-d H:i'); ?></p>
  <?php if (empty($entries)): ?>
    <p>No hay ejercicios en esta carpeta.</p>
  <?php else: ?>
    <ul>
      <?php foreach ($entries as $entry): ?>
        <?php $path = $dir . DIRECTORY_SEPARATOR . $entry; ?>
        <li>
          <?php if (is_dir($path)): ?>
            <a href="<?php echo rawurlencode($entry); ?>/index.php"><?php echo htmlspecialchars($entry); ?>/</a>
            <small class="meta">(carpeta)</small>
          <?php else: ?>
            <a href="<?php echo rawurlencode($entry); ?>"><?php echo htmlspecialchars($entry); ?></a>
            <small class="meta"><?php echo round(filesize($path)/1024,2); ?> KB</small>
          <?php endif; ?>
        </li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>
  <p><a href="/">Volver al índice</a></p>
</body>
</html>
