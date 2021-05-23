<p>[

<?php if (User::isLoggedIn()): ?>
	| <a href="<?= BASE_URL . "logout" ?>">Logout (<?= User::getUsername() ?>)</a>
<?php else: ?>
<?php endif; ?>

]</p>
