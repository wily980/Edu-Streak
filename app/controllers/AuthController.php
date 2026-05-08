<?php
namespace App\Controllers;

require_once '../app/config/app.php';
require_once '../vendor/autoload.php';

use League\OAuth2\Client\Provider\Google;

class AuthController
{
    private Google $provider;

    public function __construct()
    {
        $this->provider = new Google([
            'clientId'     => GOOGLE_CLIENT_ID,
            'clientSecret' => GOOGLE_CLIENT_SECRET,
            'redirectUri'  => GOOGLE_REDIRECT_URI,
        ]);
    }

    public function redirectToGoogle()
    {
        $authUrl = $this->provider->getAuthorizationUrl([
            'scope' => ['email', 'profile']
        ]);
        $_SESSION['oauth2state'] = $this->provider->getState();
        header('Location: ' . $authUrl);
        exit;
    }

    public function handleGoogleCallback()
    {
        if (empty($_GET['state']) || $_GET['state'] !== $_SESSION['oauth2state']) {
            unset($_SESSION['oauth2state']);
            die('Invalid state');
        }

        $token = $this->provider->getAccessToken('authorization_code', [
            'code' => $_GET['code']
        ]);

        $googleUser = $this->provider->getResourceOwner($token);
        $userData   = $googleUser->toArray();

        $googleId = $googleUser->getId();
        $name     = $userData['name'] ?? '';
        $email    = $userData['email'] ?? '';
        $avatar   = $userData['picture'] ?? '';

        require_once '../app/core/Database.php';
        $db = new \App\Core\Database();

        $existing = $db->fetchOne(
            "SELECT * FROM usr_users WHERE google_id = ? OR email = ?",
            [$googleId, $email]
        );

        if ($existing) {
            if (empty($existing['google_id'])) {
                $db->execute(
                "INSERT INTO usr_users (id, google_id, name, email, avatar_url, username) VALUES (UUID(), ?, ?, ?, ?, ?)",
                [$googleId, $name, $email, $avatar, $email] // using email as temporary username
                );
            }
            $_SESSION['user'] = $existing;
        } else {
            $db->execute(
                "INSERT INTO usr_users (id, google_id, name, email, avatar_url, username) VALUES (UUID(), ?, ?, ?, ?, ?)",
                [$googleId, $name, $email, $avatar, $email]
            );
            $_SESSION['user'] = $db->fetchOne(
                "SELECT * FROM usr_users WHERE google_id = ?",
                [$googleId]
            );
        }

        header('Location: /Edu_Streak_Lock_in/public/students');
        exit;
    }
}
?>