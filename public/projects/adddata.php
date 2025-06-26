<?php
$project = $_GET['project'] ?? null;
// Find the project in the $projects array
$selectedProject = null;
foreach ($projects as $proj) {
    if ($proj['link'] === $project) {
        $selectedProject = $proj;
        break;
    }
}
if (!$selectedProject) {
    echo "<h1>Project not found</h1>";
    return;
}