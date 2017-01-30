<!DOCTYPE html>
<html>
	<head>
		<title>Коментарі</title>
		<link href="/views/css/bootstrap.min.css" rel="stylesheet">
		<link href="/views/css/font-awesome.min.css" rel="stylesheet">
		<link href="/views/css/style.css" rel="stylesheet">
		<script type="text/javascript" src="/views/js/jquery-1.12.2.min.js"></script>
		<script type="text/javascript" src="/views/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="/views/js/app.js"></script>
		<script> window.user = <?php echo $user ? 1 : 0 ?></script>
	</head>
	<body>

		<nav class="navbar navbar-default">
			<div class="container-fluid">
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav navbar-right">
					
					<?php if($user) : ?>
						
						<li><a href="/">Привіт, <?php echo $user->name ?></a></li>
					    <li><a href="/auth/logout">Вихід</a></li>
					
					<?php else : ?>

					    <li><a href="#" data-toggle="modal" data-target="#login-modal">Увійти</a></li>
					    <li><a href="#" data-toggle="modal" data-target="#register-modal">Зареєструватись</a></li>
					
					<?php endif; ?>

					</ul>
				</div>
			</div>
		</nav>

		<div class="container">

			<?php if($user) : ?>

				<form action="/comment/create" class="form-create">
					<div>
						<div class="form-group">
							<textarea class="form-control" name="body"></textarea>
						</div>
						<button class="btn btn-default">Надіслати</button>
					</div>
				</form>

			<?php else : ?>

				Щоб залишити коментар <a href="#" data-toggle="modal" data-target="#login-modal">авторизуйтесь</a> або <a href="#" data-toggle="modal" data-target="#register-modal">зареєструйтесь</a></li>

			<?php endif; ?>

			<h3 class="title-comments">Коментарі (<span class="count"><?php echo($count); ?></span>)</h3>
		
			<?php require 'includes/items.php'; ?>
		
		</div>

		<?php require 'includes/modals.php'; ?>

	</body>
</html>