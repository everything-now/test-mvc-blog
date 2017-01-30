_<div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
	<div class="modal-dialog">
		<div class="loginmodal-container">
			<h1>Авторизація</h1><br>
			<form action="/auth/login" id="form-login">

				<div class="form-group">
					<input type="text" class="form-control" name="email" placeholder="Емейл">
					<span class="help-block"></span>
				</div>

				<div class="form-group">
					<input type="password" class="form-control" name="password" placeholder="Пароль">
					<span class="help-block"></span>
				</div>

					<input type="submit" name="login" class="login loginmodal-submit" value="Увійти">
			</form>
			
		  <div class="login-help">
			<a href="#" data-toggle="modal" data-target="#register-modal" data-dismiss="modal">Зареєструватись</a>
		  </div>
		</div>
	</div>
</div>

<div class="modal fade" id="register-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
	<div class="modal-dialog">
		<div class="loginmodal-container">
			<h1>Реєстрація</h1><br>
			<form action="/auth/register" id="form-register">
				<div class="form-group">
					<input type="text" class="form-control" name="name" placeholder="Ім'я">
					<span class="help-block"></span>
				</div>

				<div class="form-group">
					<input type="text" class="form-control" name="email" placeholder="Емейл">
					<span class="help-block"></span>
				</div>

				<div class="form-group">
					<input type="password" class="form-control" name="password" placeholder="Пароль">
					<span class="help-block"></span>
				</div>

				<div class="form-group">
					<input type="password" class="form-control" name="password_confirmation" placeholder="Підтвердіть пароль">
					<span class="help-block"></span>
				</div>

				<input type="submit" name="login" class="login loginmodal-submit" value="Зареєструватись">
			</form>
			
		  <div class="login-help">
			<a href="#" data-toggle="modal" data-target="#login-modal" data-dismiss="modal">Авторизуватись</a>
		  </div>
		</div>
	</div>
</div>