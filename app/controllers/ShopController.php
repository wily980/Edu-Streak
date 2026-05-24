<?php
namespace App\Controllers;

require_once '../app/core/Database.php';

class ShopController
{
    private \App\Core\Database $db;

    public function __construct()
    {
        $this->db = new \App\Core\Database();
    }

    // ── GET /shop ──────────────────────────────────────────────────────────
    public function index(): void
    {
        if (empty($_SESSION['user'])) {
            header('Location: /auth/login');
            exit;
        }

        // Always re-fetch fresh user data from DB (gems/hearts may have changed)
        $user = $this->db->fetchOne(
            "SELECT id, name, email, avatar_url, gems, hearts, xp_total FROM usr_users WHERE id = ?",
            [$_SESSION['user']['id']]
        );

        if (!$user) {
            session_destroy();
            header('Location: /auth/login');
            exit;
        }

        // Sync session
        $_SESSION['user'] = array_merge($_SESSION['user'], $user);

        // Fetch streak
        $streak = $this->db->fetchOne(
            "SELECT current_streak FROM usr_streaks WHERE user_id = ?",
            [$user['id']]
        );
        $user['streak'] = $streak['current_streak'] ?? 0;

        // Fetch active shop items
        $items = $this->db->fetchAll(
            "SELECT * FROM shp_items WHERE is_active = 1 ORDER BY cost ASC"
        );

        require_once '../app/views/Shop/shop.php';
    }

    // ── POST /shop/buy ─────────────────────────────────────────────────────
    public function buy(): void
    {
        header('Content-Type: application/json');

        if (empty($_SESSION['user'])) {
            echo json_encode(['success' => false, 'message' => 'Not logged in.']);
            exit;
        }

        $itemId = $_POST['item_id'] ?? '';
        if (!$itemId) {
            echo json_encode(['success' => false, 'message' => 'Invalid item.']);
            exit;
        }

        $userId = $_SESSION['user']['id'];

        // Re-fetch user and item fresh
        $user = $this->db->fetchOne(
            "SELECT id, gems, hearts FROM usr_users WHERE id = ?",
            [$userId]
        );
        $item = $this->db->fetchOne(
            "SELECT * FROM shp_items WHERE id = ? AND is_active = 1",
            [$itemId]
        );

        if (!$user || !$item) {
            echo json_encode(['success' => false, 'message' => 'Item not found.']);
            exit;
        }

        if ($user['gems'] < $item['cost']) {
            echo json_encode(['success' => false, 'message' => 'Not enough gems!']);
            exit;
        }

        // Apply item effect
        switch ($item['type']) {
            case 'heart':
                if ($user['hearts'] >= 5) {
                    echo json_encode(['success' => false, 'message' => 'Your hearts are already full!']);
                    exit;
                }
                $this->db->execute(
                    "UPDATE usr_users SET hearts = 5, gems = gems - ? WHERE id = ?",
                    [$item['cost'], $userId]
                );
                $newHearts = 5;
                break;

            case 'streak_freeze':
                // Just deduct gems and log the purchase — streak logic handled elsewhere
                $this->db->execute(
                    "UPDATE usr_users SET gems = gems - ? WHERE id = ?",
                    [$item['cost'], $userId]
                );
                $newHearts = $user['hearts'];
                break;

            default:
                echo json_encode(['success' => false, 'message' => 'Unknown item type.']);
                exit;
        }

        // Log purchase
        $this->db->execute(
            "INSERT INTO shp_purchases (id, user_id, item_id, gems_spent) VALUES (UUID(), ?, ?, ?)",
            [$userId, $itemId, $item['cost']]
        );

        // Refresh gems from DB
        $updated = $this->db->fetchOne(
            "SELECT gems, hearts FROM usr_users WHERE id = ?",
            [$userId]
        );
        $_SESSION['user']['gems']   = $updated['gems'];
        $_SESSION['user']['hearts'] = $updated['hearts'];

        echo json_encode([
            'success' => true,
            'message' => $item['name'] . ' purchased!',
            'gems'    => $updated['gems'],
            'hearts'  => $updated['hearts'],
        ]);
        exit;
    }
}
