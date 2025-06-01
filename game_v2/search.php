<?php
require_once 'db.php';
session_start();

if (isset($_GET['query'])) {
    $search = '%' . $_GET['query'] . '%';
    
    $stmt = $conn->prepare("SELECT * FROM games WHERE 
        title LIKE ? OR 
        description LIKE ? OR 
        genre LIKE ?");
        
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }
    
    $stmt->bind_param("sss", $search, $search, $search);
    
    if (!$stmt->execute()) {
        die("Error executing statement: " . $stmt->error);
    }
    
    $result = $stmt->get_result();
    $games = $result->fetch_all(MYSQLI_ASSOC);
}

include 'header.php';
?>

<div class="container">
    <h2>Search Results for "<?php echo htmlspecialchars($_GET['query']); ?>"</h2>
    
    <?php if (!empty($games)): ?>
        <div class="games-grid">
            <?php foreach ($games as $game): ?>
                <div class="game-card">
                    <img src="<?php echo htmlspecialchars($game['image']); ?>" alt="<?php echo htmlspecialchars($game['title']); ?>">
                    <h3><?php echo htmlspecialchars($game['title']); ?></h3>
                    <!-- Add other game details as needed -->
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>No games found matching your search.</p>
    <?php endif; ?>
</div>

